<?php $related = untoldstories_get_related_posts( get_the_ID(), 3 ); ?>
<?php if ( $related->have_posts() ): ?>
	<div class="entry-related">
		<?php if ( get_theme_mod( 'single_related_title', esc_html__( 'You may also like', 'untold-stories' ) ) ): ?>
			<h4 class="widget-title"><?php echo esc_html( get_theme_mod( 'single_related_title', esc_html__( 'You may also like', 'untold-stories' ) ) ); ?></h4>
		<?php endif; ?>

		<div class="row">
			<?php while ( $related->have_posts() ): $related->the_post(); ?>
				<div class="col-md-4">
					<?php get_template_part( 'content', 'entry-widget' ); ?>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>
