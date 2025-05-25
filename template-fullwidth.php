<?php
/*
* Template Name: Fullwidth Page
*/
?>

<?php get_header(); ?>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<main id="content" class="single" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">
			<div class="row">
				<div class="col-md-12">
					<?php while ( have_posts() ) : the_post(); ?>
						<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
							<h2 class="entry-title" itemprop="headline">
								<?php the_title(); ?>
							</h2>

							<?php if ( has_post_thumbnail() ) : ?>
								<div class="entry-featured">
									<a class="untoldstories-lightbox" href="<?php echo untoldstories_get_image_src( get_post_thumbnail_id(), 'large' ); ?>">
										<?php the_post_thumbnail( 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>
									</a>
								</div>
							<?php endif; ?>

							<div class="entry-content" itemprop="text">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</div>

							<?php if ( get_theme_mod( 'page_signature', 1 ) && false === untoldstories_is_wc_page() ) {
								get_template_part( 'part', 'signature' );
							} ?>

							<div class="entry-utils group">
								<?php if ( get_theme_mod( 'page_social_sharing', 1 ) ) {
									get_template_part( 'part', 'social-sharing' );
								} ?>
							</div>

							<?php comments_template(); ?>

						</article>
					<?php endwhile; ?>
				</div>
			</div>
		</main>
	</div>
</div>

<?php get_footer(); ?>