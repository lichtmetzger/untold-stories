<?php
/*
* Template Name: Recipes overview (v2)
*/
$theme = wp_get_theme();
wp_enqueue_style('template-recipes-v2', get_stylesheet_directory_uri() . '/css/template-recipes-v2.css', array(), $theme->get( 'Version' ) );
wp_enqueue_script('template-recipes-v2', get_stylesheet_directory_uri() . '/js/template-recipes-v2.js', array('jquery', 'untoldstories-masonry'), $theme->get( 'Version' ), true );
?>
<?php get_header() ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="site-content">
                    <div class="row">
                        <div class="col-md-12">
                            <h2 class="entry-title" itemprop="headline"><?php the_title() ?></h2>

                            <div class="entry-content" itemprop="text">
                                <?php the_content(); ?>
                                <?php wp_link_pages(); ?>
                            </div>

                            <div class="recipe-filter">
                                <?php
                                $recipeCategories = get_terms([
                                    'taxonomy'   => 'recipe-categories',
                                    'hide_empty' => true,
                                ]);

                                if (!is_wp_error($recipeCategories)) {
                                    foreach ( $recipeCategories as $term ) {
                                        echo '
                                            <input type="checkbox" id="' . $term->term_id . '" name="recipe-categories[]" value="' . $term->term_id . '">
                                            <label for="' . $term->term_id . '">' . esc_html($term->name) . '</label>';
                                    }
                                }
                                ?>
                            </div>
                            <div id="response"></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--content-->
<?php get_footer() ?>