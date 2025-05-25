<?php get_header(); ?>

<?php $sidebar = get_theme_mod( 'layout_other', 'side' ) === 'side' ? true : false; ?>

<div id="site-section">
	<h2 class="entry-title"><?php esc_html_e( 'Page not found' , 'untold-stories' ); ?></h2>
</div>

<div class="row">
	<div class="col-md-8 <?php echo esc_attr( $sidebar ? '' : 'col-md-offset-2' ); ?>">
		<main id="content" class="single" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
			<div class="row">
				<div class="col-md-12">
					<article class="entry">
						<div class="entry-content text-center">
							<p><?php esc_html_e( 'The page you were looking for can not be found! Perhaps try searching?', 'untold-stories' ); ?></p>
							<?php get_search_form(); ?>
						</div>
					</article>
				</div>
			</div>
		</main>
	</div>

	<?php if ( $sidebar ) : ?>
		<div class="col-md-4">
			<?php get_sidebar(); ?>
		</div>
	<?php endif; ?>

</div>

<?php get_footer(); ?>