					</div><!-- /site-content -->

				</div><!-- /col-md-12 -->
			</div><!-- /row -->
		</div><!-- /container -->
	</div><!-- /main-wrap -->

	<footer id="footer" class="<?php echo esc_attr( get_theme_mod( 'footer_reveal', 1 ) == 1 ? 'footer-fixed' : '' ); ?>" role="contentinfo" itemscope="itemscope" itemtype="http://schema.org/WPFooter">

		<div class="site-logo">
			<h4 itemprop="name">
				<a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>">
					<?php if( get_theme_mod( 'footer_logo', get_template_directory_uri() . '/images/logo_footer.png' ) ): ?>
						<img itemprop="logo" src="<?php echo esc_url( get_theme_mod( 'footer_logo', get_template_directory_uri() . '/images/logo_footer.png' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
					<?php else: ?>
						<?php bloginfo( 'name' ); ?>
					<?php endif; ?>
				</a>
			</h4>

			<?php if ( get_theme_mod( 'footer_tagline', 1 ) == 1 ): ?>
				<p class="tagline"><?php bloginfo( 'description' ); ?></p>
			<?php endif; ?>
		</div><!-- /site-logo -->

		<nav class="nav">
			<?php wp_nav_menu( array(
				'theme_location' => 'footer_menu',
				'container'      => '',
				'menu_id'        => '',
				'menu_class'     => 'navigation',
				'depth'			=> 0
			) ); ?>
		</nav><!-- #nav -->

		<?php if ( get_theme_mod( 'footer_search', 1 ) === 1 || get_theme_mod( 'footer_socials', 1 ) === 1 ) : ?>
			<div class="site-tools group">
				<?php if ( get_theme_mod( 'footer_search', 1 ) == 1 ) {
					get_search_form();
				} ?>

				<?php if ( get_theme_mod( 'footer_socials', 1 ) == 1 ) {
					get_template_part( 'part', 'social-icons' );
				} ?>
			</div><!-- /site-tools -->
		<?php endif; ?>

		<?php if ( get_theme_mod( 'footer_text', untoldstories_get_default_footer_text() ) ): ?>
			<p class="footer-text">
				<?php echo get_theme_mod( 'footer_text', untoldstories_get_default_footer_text() ); ?>
			</p>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'untoldstories_footer_widgets') ) : ?>
			<?php
				$attributes = sprintf( 'data-auto="%s" data-speed="%s"',
					esc_attr( get_theme_mod( 'instagram_auto', 1 ) ),
					esc_attr( get_theme_mod( 'instagram_speed', 300 ) )
				);
			?>
			<div class="footer-widget-area" <?php echo $attributes; ?>>
				<?php dynamic_sidebar( 'untoldstories_footer_widgets' ); ?>
			</div>
		<?php endif; ?>
	</footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
