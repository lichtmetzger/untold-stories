<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
<?php wp_body_open(); ?>

<?php if ( get_theme_mod( 'site_socials' ) == 1 ): ?>
	<div class="site-socials">
		<?php get_template_part( 'part', 'social-icons' ); ?>
	</div>
<?php endif; ?>

<div id="page">
	<div id="main-wrap">
		<header id="masthead" role="banner" class="site-header" itemscope="itemscope" itemtype="http://schema.org/Organization">
			<div class="site-bar group <?php echo esc_attr( get_theme_mod( 'header_bar_sticky', 1 ) == 1 ? 'site-bar-fixed' : '' ); ?>">
				<nav class="nav" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
					<?php wp_nav_menu( array(
						'theme_location' => 'main_menu',
						'container'      => '',
						'menu_id'        => '',
						'menu_class'     => 'navigation'
					) ); ?>

					<a class="mobile-nav-trigger" href="#mobilemenu"><i class="fa fa-navicon"></i> <?php esc_html_e( 'Menu', 'untold-stories' ); ?></a>
				</nav>
				<div id="mobilemenu"></div>

				<div class="site-tools">
					<?php if ( get_theme_mod( 'header_bar_socials', 1 ) == 1 ) {
						get_template_part( 'part', 'social-icons' );
					} ?>

					<?php if ( get_theme_mod( 'header_bar_search', 1 ) == 1 ) {
						get_search_form();
					} ?>
				</div><!-- /site-tools -->
			</div><!-- /site-bar -->

			<div class="site-logo">
				<h1 itemprop="name">
					<a itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>">
						<?php if ( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ): ?>
							<img itemprop="logo"
							     src="<?php echo esc_url( get_theme_mod( 'logo', get_template_directory_uri() . '/images/logo.png' ) ); ?>"
							     alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
						<?php else: ?>
							<?php bloginfo( 'name' ); ?>
						<?php endif; ?>
					</a>
				</h1>
				
				<?php if ( get_bloginfo( 'description' ) ): ?>
					<p class="tagline"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div><!-- /site-logo -->
			
		</header>

		<?php if ( is_home() ) {
			get_template_part( 'part', 'slider' );
		} ?>

		<div class="container">
			<div class="row">
				<div class="col-md-12">

					<?php if ( is_active_sidebar( 'untoldstories_inset' ) ) : ?>
						<div class="widgets-inset">
							<?php $inset_title = get_theme_mod( 'inset_sidebar_title' ); ?>
							<?php if ( $inset_title ) : ?>
								<h3 class="widget-title"><?php echo esc_html( $inset_title ); ?></h3>
							<?php endif; ?>
							<div class="row">
								<?php dynamic_sidebar( 'untoldstories_inset' ); ?>
							</div>
						</div>
					<?php endif; ?>

					<div id="site-content">
