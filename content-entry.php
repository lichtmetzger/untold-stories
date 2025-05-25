<?php
	if ( is_tag() || is_category() ) {
		$layout = untoldstories_get_layout_classes( 'layout_terms' );
	} else {
		$layout = untoldstories_get_layout_classes( 'layout_blog' );
	}
	$post_class  = $layout['post_class'];
	$post_col    = $layout['post_col'];
	$masonry     = $layout['masonry'];
	$blog_layout = $layout['layout'];
	$is_classic  = false;

	global $wp_query;
	if ( in_array( $layout['layout'], array( 'small_side', '2cols_side' ) ) && is_main_query() && $wp_query->current_post == 0 ) {
		$post_class = '';
		$post_col   = $layout['layout'] === '2cols_side' ? 'col-xs-12' : '';
		$masonry    = false;
		$is_classic = true;
	} elseif ( $post_class === 'entry-list' ) {
		get_template_part('content', 'entry-list');
		return;
	}

	if ( $blog_layout === 'classic_side' || $blog_layout === 'classic_full' ) {
		$is_classic = true;
	}
?>

<?php if ( ! empty( $post_col ) ) : ?>
	<div class="<?php echo esc_attr( $post_col ); ?> <?php echo esc_attr( $masonry ? 'entry-masonry' : '' ); ?>">
<?php endif; ?>

<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry ' . $post_class ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

	<?php the_title( sprintf( '<h2 itemprop="headline" class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<?php if ( get_post_type() === 'post' ) : ?>
		<div class="entry-meta">
			<p class="entry-categories">
				<?php the_category( ' ' ); ?>
			</p>
			<time class="entry-date" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</div>
	<?php endif; ?>

	<?php if ( $is_classic && get_post_format() === 'gallery' && !is_search() ) : ?>
		<div class="entry-featured">
			<?php
				$gallery      = untoldstories_featgal_get_attachments( get_the_ID() );
				$gallery_type = get_post_meta( get_the_ID(), 'gallery_layout', true );
			?>
			<?php if ( $gallery->have_posts() ): ?>
				<?php if ( $gallery_type === 'tiled' ) : ?>
					<div class="entry-justified" data-height='150'>
						<?php while ( $gallery->have_posts() ) : $gallery->the_post(); ?>
							<a class="untoldstories-lightbox" href="<?php echo esc_url( untoldstories_get_image_src( get_the_ID(), 'large' ) ); ?>">
								<?php $attachment = wp_prepare_attachment_for_js( get_the_ID() ); ?>
								<img src="<?php echo esc_url( untoldstories_get_image_src( get_the_ID(), 'untoldstories_thumb_wide' ) ); ?>" alt="<?php echo esc_attr( $attachment['alt'] ); ?>" />
							</a>
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
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
						<?php endwhile; ?>
						<?php wp_reset_postdata(); ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	<?php elseif ( $is_classic && ( get_post_format() === 'audio' || get_post_format() === 'video' ) && !is_search()) : ?>
		<?php // We don't want anything to appear here ?>
	<?php else : ?>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-featured">
				<a href="<?php echo esc_url( get_permalink() ); ?>">
					<?php the_post_thumbnail( $masonry ? 'untoldstories_thumb_masonry' : 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>
				</a>
			</div>
		<?php endif; ?>
	<?php endif; ?>

	<div class="entry-content" itemprop="text">
		<?php
			if ( $is_classic && !is_search() ) {
				the_content( '' );
			} else {
				the_excerpt();
			}
		?>
	</div>

	<div class="entry-utils group">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php esc_html_e( 'Continue Reading', 'untold-stories' ); ?></a>

		<?php if ( get_theme_mod( 'single_social_sharing', 1 ) ) {
			get_template_part( 'part', 'social-sharing' );
		} ?>
	</div>
</article>

<?php if ( ! empty( $post_col ) ) : ?>
	</div>
<?php endif; ?>