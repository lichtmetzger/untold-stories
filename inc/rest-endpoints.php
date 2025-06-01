<?php
/**
 * WP REST API endpoints.
 */

if ( ! defined( 'ABSPATH' ) ) {
    die( '' );
}

add_action( 'rest_api_init', 'filter_recipes_endpoint' );

/**
 * Validates if the submitted parameter is empty, an int or an array of ints.
 *
 * @param  mixed           $value   Value(s) submitted to REST endpoint.
 * @param  WP_REST_Request $request The current request object.
 * @param  string          $param   Key of the parameter.
 * @return bool
 */
function validate_rest_request( $value, $request, $param ) {
    // Parameter is empty.
    if ( empty( $value ) ) {
        return true;
    }

    // Parameter is an integer.
    if ( ctype_digit( $value ) ) {
        return true;
    }

    // Parameter is a string with comma-separated integers.
    $values = explode( ',', $value );

    if ( is_array( $values ) ) {
        foreach ( $values as $var ) {
            if ( ! is_numeric( $var ) ) {
                return false;
            }
        }

        return true;
    }

    return false;
}

/**
 * Register a new REST route for the filter-exhibitors callback function.
 *
 * @return void
 */
function filter_recipes_endpoint() {
    register_rest_route(
    // Endpoint.
        'recipes/v1',
        '/filter-recipes/',
        array(
            'methods'             => 'GET',
            'callback'            => 'filter_recipes_callback',
            'permission_callback' => '__return_true',
            'args'                => array(
                'recipeCategories' => array(
                    'validate_callback' => 'validate_rest_request',
                ),
            ),
        )
    );
}

/**
 * Endpoint callback function for filtering recipes by recipe-category.
 *
 * @param  WP_REST_Request $request The current request object.
 * @return WP_REST_Response Multidimensional array with all recipe posts.
 */
function filter_recipes_callback( $request ) {
    $categories = explode( ',', $request->get_param( 'recipeCategories' ) );;
    $data       = array();

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 60,
        // TODO: Make this dynamic
        'category_name' => 'homemaderecipes',
        'order_by' => 'date',
        'order' => 'desc',
    );

    if ( ! empty( $categories[0] ) ) {
        $args['tax_query'] =
            array(
                array(
                    'taxonomy' => 'recipe-categories',
                    'field'    => 'term_id',
                    'terms'    => $categories,
                ),
            );
    }

    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $subdata   = array();
            $post_id = get_the_ID();

            // Fields.
            $subdata['title']    = get_the_title($post_id);
            $subdata['excerpt']  = get_the_excerpt($post_id);
            $subdata['permalink']  = get_permalink($post_id);
            $subdata['imageUrl']  = get_the_post_thumbnail_url($post_id, 'untoldstories_thumb_recipe');

            $data[]           = $subdata;
            $response_message = 'Found recipes by filter data.';

        }
    } else {
        $data             = array();
        $response_message = 'No recipes found.';
    }

    // Restore original post data.
    wp_reset_postdata();

    $response_data = array(
        'message' => $response_message,
        'data'    => $data,
    );

    $response = new WP_REST_Response( $response_data );
    $response->header( 'X-WP-Total', (int) $query->found_posts );
    // $response->header( 'X-WP-TotalPages', (int) $query->max_num_pages );

    return $response;
}