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
                                            <input type="checkbox" id="' . $term->term_id . '" name="recipe-categories[]" value="' . esc_html($term->name) . '">
                                            <label for="' . $term->term_id . '">' . esc_html($term->name) . '</label>';
                                    }
                                }
                                ?>
                            </div>

                            <?php
                            $recipes = new WP_Query([
                                'post_type' => 'post',
                                'posts_per_page' => -1,
                                /* @todo: Make this category dynamic in customizer */
                                'category_name' => 'homemaderecipes',
                                'order_by' => 'date',
                                'order' => 'desc',
                            ]);
                            ?>

                            <?php if($recipes->have_posts()): ?>
                                <ul class="recipe-tiles">
                                    <?php
                                    while($recipes->have_posts()) : $recipes->the_post();
                                        get_template_part('partials/content', 'recipe');
                                    endwhile;
                                    ?>
                                </ul>
                                <?php wp_reset_postdata(); ?>
                            <?php endif; ?>

                        </div>
                        <?php /* <div class="col-md-4">
		                  <?php get_sidebar() ?>
                        </div> */ ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!--content-->
<?php get_footer() ?>