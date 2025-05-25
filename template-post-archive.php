<?php
/*
* Template Name: Full post archive
*/
$theme = wp_get_theme();
wp_enqueue_style('template-post-archive', get_stylesheet_directory_uri() . '/css/template-post-archive.css', array(), $theme->get( 'Version' ) );
?>
<?php get_header() ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="site-content">
                    <div class="row">
                        <div class="col-md-8">
                            <h2 class="entry-title" itemprop="headline"><?php the_title() ?></h2>
                            <?php
                            global $month, $wpdb;
                            $now        = current_time('mysql');
                            $arcresults = $wpdb->get_results('SELECT DISTINCT YEAR(post_date) AS year, MONTH(post_date) AS month, count(ID) as posts FROM ' . $wpdb->posts . ' WHERE post_date <\'' . $now . "' AND post_status='publish' AND post_type='post' AND post_password='' GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC");

                            if ($arcresults) {
                                foreach ($arcresults as $arcresult) {
                                    $url  = get_month_link($arcresult->year, $arcresult->month);
                                    $text = sprintf('%s %d', $month[zeroise($arcresult->month,2)], $arcresult->year);
                                    echo get_archives_link($url, $text, '','<h3>','</h3>');

                                    $thismonth   = zeroise($arcresult->month,2);
                                    $thisyear = $arcresult->year;

                                    $arcresults2 = $wpdb->get_results('SELECT ID, post_date, post_title, comment_status FROM ' . $wpdb->posts . " WHERE post_date LIKE '$thisyear-$thismonth-%' AND post_status='publish' AND post_type='post' AND post_password='' ORDER BY post_date DESC");

                                    if ($arcresults2) {
                                        echo '<ul class="postspermonth">', "\n";
                                        foreach ($arcresults2 as $arcresult2) {
                                            if ($arcresult2->post_date != '0000-00-00 00:00:00') {
                                                $url       = get_permalink($arcresult2->ID);
                                                $arc_title = $arcresult2->post_title;

                                                if ($arc_title) $text = strip_tags($arc_title);
                                                else $text = $arcresult2->ID;

                                                echo '<li>', get_archives_link($url, $text, '');
                                                $comments = $wpdb->get_results('SELECT * FROM ' . $wpdb->comments . ' WHERE comment_post_ID=' . $arcresult2->I);
                                                $comments_count = get_comments_number($arcresult2->ID);
                                                switch($comments_count) {
                                                    case 0:
                                                        echo '<span class="kwa_ccount count_0">&nbsp; - '.__('No comments', 'untold-stories').'</span>';
                                                        break;
                                                    case 1:
                                                        echo '<span class="kwa_ccount count_1">&nbsp; - '.__('1 comment', 'untold-stories').'</span>';
                                                        break;
                                                    default:
                                                        echo '<span class="kwa_ccount count_multi">&nbsp; - '.sprintf(__('%s comments', 'untold-stories'), $comments_count).'</span>';
                                                        break;
                                                }
                                                echo '</li>', "\n";
                                            }
                                        }
                                        echo '</ul>', "\n";
                                    }
                                }
                            }
                            ?>
                        </div>
                        <div class="col-md-4">
                            <?php get_sidebar() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--content-->
<?php get_footer() ?>