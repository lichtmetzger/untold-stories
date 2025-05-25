<article id="entry-<?php the_ID(); ?>" <?php post_class( 'entry entry-list' ); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="entry-featured">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail( 'post-thumbnail', array( 'itemprop' => 'image' ) ); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="entry-content-wrap">
		<?php the_title( sprintf( '<h2 itemprop="headline" class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( get_post_type() === 'post' ) : ?>
			<div class="entry-meta">
				<p class="entry-categories">
					<?php the_category( ' ' ); ?>
				</p>
				<time class="entry-date" itemprop="datePublished" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</div>
		<?php endif; ?>

		<div class="entry-content" itemprop="text">
			<?php the_excerpt(); ?>
		</div>
	</div>

	<div class="entry-utils group">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more"><?php esc_html_e( 'Continue Reading', 'untold-stories' ); ?></a>

		<?php if ( get_theme_mod( 'single_social_sharing', 1 ) ) {
			get_template_part( 'part', 'social-sharing' );
		} ?>
	</div>
</article>