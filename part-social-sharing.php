<?php if( in_the_loop() ): ?>
	<ul class="socials">
		<?php
			$thumb_id = get_post_thumbnail_id();

			$facebook = add_query_arg( array(
				'u' => get_permalink(),
			), 'https://www.facebook.com/sharer.php' );

			$twitter = add_query_arg( array(
				'url' => get_permalink(),
			), 'https://twitter.com/share' );

			$pinterest = add_query_arg( array(
				'url'         => get_permalink(),
				'description' => get_the_title(),
				'media'       => untoldstories_get_image_src( get_post_thumbnail_id(), 'large' ),
			), 'https://pinterest.com/pin/create/bookmarklet/' );
		?>
		<li><a href="<?php echo esc_url( $facebook ); ?>" class="social-icon"><i class="fa fa-facebook"></i></a></li>
		<li><a href="<?php echo esc_url( $twitter ); ?>" class="social-icon"><i class="fa fa-twitter"></i></a></li>
		<?php if ( ! empty( $thumb_id ) ): ?>
			<li><a href="<?php echo esc_url( $pinterest ); ?>" class="social-icon"><i class="fa fa-pinterest"></i></a></li>
		<?php endif; ?>
	</ul>
<?php endif; ?>
