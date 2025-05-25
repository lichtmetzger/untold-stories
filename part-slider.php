<?php if( get_theme_mod( 'home_slider_show', 1 ) == 1 ): ?>
	<?php
		$q    = false;
		$args = false;

		if ( get_theme_mod( 'home_slider_postids' ) ) {
			$args = array(
				'post_type'      => 'post',
				'post__in'       => explode( ',', get_theme_mod( 'home_slider_postids' ) ),
				'posts_per_page' => get_theme_mod( 'home_slider_limit', 5 ),
				'orderby'        => 'post__in',
			);
		} elseif ( get_theme_mod( 'home_slider_term' ) ) {
			$args = array(
				'post_type'      => 'post',
				'tax_query'      => array(
					array(
						'taxonomy' => 'category',
						'terms'    => get_theme_mod( 'home_slider_term' )
					),
				),
				'posts_per_page' => get_theme_mod( 'home_slider_limit', 5 ),
			);
		}

		if( $args !== false ) {
			$q = new WP_Query( $args );
		}

		$attributes = sprintf( 'data-autoplay="%s" data-autoplayspeed="%s" data-fade="%s"',
			esc_attr( get_theme_mod( 'home_slider_autoplay', 1 ) ),
			esc_attr( get_theme_mod( 'home_slider_autoplaySpeed', 3000 ) ),
			esc_attr( get_theme_mod( 'home_slider_fade', 1 ) )
		);

		$carousel_sidebar   = get_theme_mod( 'carousel_sidebar' ) == true ? true : false;
		$carousel_fullwidth = get_theme_mod( 'carousel_fullwidth' ) == true ? true : false;
		$carousel_alt       = get_theme_mod( 'carousel_alt' ) == true ? true : false;
		$slider_columns     = $carousel_sidebar == true ? 'col-md-8' : 'col-md-12';
	?>
	<?php if( $args !== false && $q !== false && $q->have_posts() ): ?>
		<?php if ( ! $carousel_fullwidth ) : ?>
			<div class="container">
				<div class="row">
					<div class="<?php echo esc_attr( $slider_columns ); ?>">
		<?php endif; ?>

		<div class="feature-slider slick-slider <?php echo esc_attr( $carousel_alt ? 'slick-slider-alt' : '' ); ?> <?php echo esc_attr( $carousel_fullwidth ? 'slider-fullwidth' : '' ); ?>" <?php echo $attributes; ?>>
			<?php while( $q->have_posts() ): $q->the_post(); ?>
				<div class="slide">
					<?php if ( $carousel_sidebar ) {
						the_post_thumbnail( 'untoldstories_thumb_slider_small' );
					} else {
						the_post_thumbnail( 'untoldstories_thumb_slider' );
					} ?>

					<div class="slide-overlay <?php echo esc_attr( $carousel_alt ? 'slide-overlay-alt' : '' ); ?>">
						<div class="slide-content">
							<div class="slide-meta">
								<p class="slide-categories">
									<?php the_category( ' ' ); ?>
								</p>
								<time class="slide-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>
							<h2 class="slide-title">
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
							</h2>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>

		<?php if ( ! $carousel_fullwidth ) : ?>
					</div>
					<?php if ( $carousel_sidebar ): ?>
						<div class="col-md-4" id="feature-instagram">
							<?php dynamic_sidebar( 'untoldstories_carousel' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>

	<?php endif; ?>
<?php endif; ?>