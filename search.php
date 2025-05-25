<?php get_header(); ?>

<?php
	$layout      = get_theme_mod( 'layout_other', 'side' );
	$content_col = 'col-md-8';
	$sidebar_col = 'col-md-4';

	if ( $layout !== 'side' ) {
		$content_col = 'col-md-8 col-md-offset-2';
		$sidebar_col = '';
	}

	global $wp_query;

	$found = $wp_query->found_posts;
	$none  = esc_html__( 'No results found. Please broaden your terms and search again.', 'untold-stories' );
	$one   = esc_html__( 'Just one result found. We either nailed it, or you might want to broaden your terms and search again.', 'untold-stories' );
	$many  = sprintf( _n( '%d result found.', '%d results found.', $found, 'untold-stories' ), $found );
?>

<div id="site-section">
	<h2><?php esc_html_e( 'Search' , 'untold-stories' ); ?></h2>
</div>

<div class="row">
	<div class="<?php echo esc_attr( $content_col ); ?>">
		<main id="content" class="entries-list" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

			<div class="row">
				<div class="col-md-12">

					<div class="search-box text-center">
						<p><?php untoldstories_e_inflect( $found, $none, $one, $many ); ?></p>
						<?php if ( $found < 2 ) {
							get_search_form();
						}?>
					</div>

					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'content', 'entry' ); ?>
					<?php endwhile; ?>
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
