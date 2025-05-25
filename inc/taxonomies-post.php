<?php
	add_action( 'init', 'untoldstories_register_recipe_categories_taxonomy' );

    function untoldstories_register_recipe_categories_taxonomy() {
        $labels = array(
            'name'              => __( 'Recipe categories', 'untold-stories' ),
            'singular_name'     => __( 'Recipe category', 'untold-stories' ),
            'search_items'      => __( 'Search recipe categories', 'untold-stories' ),
            'all_items'         => __( 'All recipe categories', 'untold-stories' ),
            'parent_item'       => __( 'Parent recipe category', 'untold-stories' ),
            'parent_item_colon' => __( 'Parent recipe category:', 'untold-stories' ),
            'edit_item'         => __( 'Edit recipe category', 'untold-stories' ),
            'update_item'       => __( 'Update recipe category', 'untold-stories' ),
            'add_new_item'      => __( 'Add new recipe category', 'untold-stories' ),
            'new_item_name'     => __( 'New recipe category', 'untold-stories' ),
            'menu_name'         => __( 'Recipe categories', 'untold-stories' ),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'recipe-category'),
        );

        register_taxonomy('recipe-categories', array('post'), $args);
    }
