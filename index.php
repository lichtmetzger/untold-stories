<?php get_header(); ?>

<?php
	if ( is_tag() || is_category() ) {
		$layout = untoldstories_get_layout_classes( 'layout_terms' );
	} else {
		$layout = untoldstories_get_layout_classes( 'layout_blog' );
	}

	$content_col = $layout['content_col'];
	$sidebar_col = $layout['sidebar_col'];
	$main_class  = $layout['main_class'];
	$post_col    = $layout['post_col'];
	$masonry     = $layout['masonry'];
?>

<?php if ( is_archive() ): ?>
	<div id="site-section">
		<h2><?php echo get_the_archive_title(); ?></h2>
	</div>
<?php endif; ?>

<div class="row">
	<div class="<?php echo esc_attr( $content_col ); ?>">
		<main id="content" class="<?php echo esc_attr( $main_class ); ?>" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

			<div class="row">
				<div class="col-md-12">
					<?php if ( ! empty( $post_col ) ) : ?>
						<div class="row <?php echo esc_attr( $masonry ? 'entries-masonry' : '' ); ?>">
					<?php endif; ?>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'entry' ); ?>
					<?php endwhile; ?>

					<?php if ( ! empty( $post_col ) ) : ?>
						</div>
					<?php endif; ?>
				</div>
			</div>

			<?php untoldstories_pagination(); ?>
		</main>
	</div>

	<?php if ( ! empty( $sidebar_col ) ) : ?>
		<div class="<?php echo esc_attr( $sidebar_col ); ?>">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>
