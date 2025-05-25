<div class="entry-author group" itemscope="itemscope" itemprop="author" itemtype="http://schema.org/Person">
	<?php if ( untoldstories_validate_gravatar( get_the_author_meta( 'user_email' ) ) ) : ?>
	<figure class="author-avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 102, get_option( 'avatar_default', 'mystery' ), esc_attr( get_the_author_meta( 'display_name' ) ), array( 'extra_attr' => 'itemprop="image"' ) ); ?>
	</figure>
	<?php endif; ?>

	<h4 class="widget-title" itemprop="name"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></h4>

	<?php if ( get_the_author_meta( 'description' ) ): ?>
		<p class="author-excerpt" itemprop="description">
			<?php echo wp_kses( get_the_author_meta( 'description' ), untoldstories_get_allowed_tags( 'guide' ) ); ?>
		</p>
	<?php else: ?>
		<p class="author-excerpt" itemprop="description">
			<?php esc_html_e( 'In this area you can display your biographic info. Just visit Users > Your Profile > Biographic info', 'untold-stories' ); ?>
		</p>
	<?php endif; ?>

	<?php get_template_part( 'part', 'social-icons' ); ?>
</div>
