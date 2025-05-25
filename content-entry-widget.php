<article <?php post_class( 'entry' ); ?>>
	<div class="entry-meta">
		<time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
	</div>
	<div class="entry-featured">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
	</div>
	<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
</article>