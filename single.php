<?php get_header(); ?>

<?php $sidebar = get_post_meta( get_queried_object_id(), 'layout', true ) == 'full' ? false : true; ?>

<div class="row">

	<div class="col-md-8 <?php echo esc_attr( $sidebar ? '' : 'col-md-offset-2' ); ?>">
		<main id="content" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

			<div class="row">
				<div class="col-md-12">
					<?php while ( have_posts() ) : the_post(); ?>
						<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry' ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
							<h2 class="entry-title" itemprop="headline">
								<?php the_title(); ?>
							</h2>

							<div class="entry-meta">
								<?php if ( get_theme_mod( 'single_categories', 1 ) ) : ?>
									<p class="entry-categories">
										<?php the_category( ' ' ); ?>
									</p>
								<?php endif; ?>

								<?php if ( get_theme_mod( 'single_date', 1 ) ) : ?>
									<time class="entry-date" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
								<?php endif; ?>
							</div>

							<div class="entry-featured">
								<?php
									$gallery      = untoldstories_featgal_get_attachments( get_the_ID() );
									$gallery_type = get_post_meta( get_the_ID(), 'gallery_layout', true );
								?>
								<?php if ( 'gallery' === get_post_format() && $gallery->have_posts() ) : ?>

									<?php if ( $gallery_type === 'tiled' ) : ?>
										<div class="entry-justified" data-height="150">
											<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
												<a class="untoldstories-lightbox" href="<?php echo esc_url( untoldstories_get_image_src( get_the_ID(), 'large' ) ); ?>">
													<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
													<img src="<?php echo esc_url( untoldstories_get_image_src( get_the_ID(), 'untoldstories_thumb_wide' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
												</a>
											<?php endwhile; wp_reset_postdata(); ?>
										</div>
									<?php else : ?>
										<div class="feature-slider slick-slider">
											<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
												<div class="slide">
													<a class="untoldstories-lightbox" href="<?php echo esc_url( untoldstories_get_image_src( get_the_ID(), 'large' ) ); ?>">
														<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
														<img src="<?php echo esc_url( untoldstories_get_image_src( get_the_ID(), 'post-thumbnail' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
													</a>
												</div>
											<?php endwhile; wp_reset_postdata(); ?>
										</div>
									<?php endif; ?>

								<?php elseif ( has_post_thumbnail() && get_theme_mod( 'single_featured', 1 ) && ( get_post_format() !== 'video' ) && ( get_post_format() !== 'audio' ) ) : ?>

									<a class="untoldstories-lightbox" href="<?php echo untoldstories_get_image_src( get_post_thumbnail_id(), 'large'); ?>">
										<?php the_post_thumbnail( 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>
									</a>

								<?php endif; ?>
							</div>

							<div class="entry-content" itemprop="text">
								<?php the_content(); ?>
								<?php wp_link_pages(); ?>
							</div>

							<?php if ( get_theme_mod( 'single_tags', 1 ) && has_tag() ) : ?>
								<div class="entry-tags">
									<?php the_tags( '', '' ); ?>
								</div>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'single_signature', 1 ) ) {
								get_template_part( 'part', 'signature' );
							} ?>

							<div class="entry-utils group">
								<?php if ( get_theme_mod( 'single_social_sharing', 1 ) ) {
									get_template_part( 'part', 'social-sharing' );
								} ?>
							</div>

							<?php if ( get_theme_mod( 'single_nextprev', 1 ) ) : ?>
								<div id="paging" class="group">
									<?php
										$prev_post = get_previous_post();
										$next_post = get_next_post();
									?>
									<?php if( ! empty( $next_post ) ): ?>
										<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>" class="paging-standard paging-older"><?php esc_html_e( 'Previous Post', 'untold-stories' ); ?></a>
									<?php endif; ?>
									<?php if( ! empty( $prev_post ) ): ?>
										<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>" class="paging-standard paging-newer"><?php esc_html_e( 'Next Post', 'untold-stories' ); ?></a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( get_theme_mod( 'single_authorbox', 1 ) ) {
								get_template_part( 'part', 'authorbox' );
							} ?>

							<?php if ( get_theme_mod( 'single_related', 1 ) ) {
								get_template_part( 'part', 'related' );
							} ?>

							<?php if( get_theme_mod( 'single_comments', 1 ) ) {
								comments_template();
							} ?>
						</article>
					<?php endwhile; ?>
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