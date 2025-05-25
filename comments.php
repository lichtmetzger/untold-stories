<?php
	if ( ! empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
		die ( esc_html__('Please do not load this page directly. Thanks!', 'untold-stories'));

	if ( post_password_required() )
		return;
?>

<?php if( have_comments() || comments_open() ): ?>
	<div id="comments">
<?php endif; ?>

<?php if ( have_comments() ): ?>
	<div class="post-comments group">
		<h3 class="widget-title"><?php comments_number( esc_html__( 'No comments', 'untold-stories' ), esc_html__( '1 comment', 'untold-stories' ), esc_html__( '% comments', 'untold-stories' ) ); ?></h3>
		<div class="comments-pagination"><?php paginate_comments_links(); ?></div>
		<ol id="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'type'        => 'comment',
					'avatar_size' => 64
				) );
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'type'       => 'pings'
				) );
			?>
		</ol>
		<div class="comments-pagination"><?php paginate_comments_links(); ?></div>
	</div><!-- .post-comments -->
<?php endif; ?>

<?php if ( comments_open() ): ?>
	<section id="respond">
		<div id="form-wrapper" class="group">
			<?php
			    comment_form();
                if ( is_plugin_active( 'antispam-bee/antispam_bee.php' ) ) {
                    echo '
                        <div class="antispambee-wrap">
                            '.sprintf(__('So far, %s spam comments have been deleted.', 'untold-stories'), do_action('antispam_bee_count')).'
                            <br>
                            '.__('If your comment does not appear, it will be published later.', 'untold-stories').'
                        </div>';
                }
            ?>
		</div><!-- #form-wrapper -->
	</section>
<?php endif; ?>

<?php if( have_comments() || comments_open() ): ?>
	</div><!-- #comments -->
<?php endif; ?>
