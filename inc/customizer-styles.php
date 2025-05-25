<?php
add_action( 'wp_head', 'untoldstories_customizer_css' );
if( ! function_exists( 'untoldstories_customizer_css' ) ):
function untoldstories_customizer_css() {
    ?><style type="text/css"><?php

		//
		// Global
		//
		if ( get_theme_mod( 'site_text_color' ) ) {
			?>
			body {
				color: <?php echo get_theme_mod( 'site_text_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_headings_color' ) ) {
			?>
			h1, h2, h3, h4, h5, h6,
			.entry-title,
			.entry-title a {
				color: <?php echo get_theme_mod( 'site_headings_color' ); ?>;
			}

			.entry-title:after {
				background: <?php echo get_theme_mod( 'site_headings_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'site_link_color' ) ) {
			?>
			a {
				color: <?php echo get_theme_mod( 'site_link_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'site_link_color_hover' ) ) {
			?>
			a:hover {
				color: <?php echo get_theme_mod( 'site_link_color_hover' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'button_background_color' ) ) {
			?>
			.btn,
			input[type="button"],
			input[type="submit"],
			input[type="reset"],
			button,
			.comment-reply-link,
			.entry-categories a,
			.slide-categories a {
				background-color: <?php echo get_theme_mod( 'button_background_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'button_text_color' ) ) {
			?>
			.btn,
			input[type="button"],
			input[type="submit"],
			input[type="reset"],
			button,
			.comment-reply-link,
			.entry-categories a,
			.slide-categories a {
				color: <?php echo get_theme_mod( 'button_text_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'button_background_hover_color' ) ) {
			?>
			.btn:hover,
			input[type="button"]:hover,
			input[type="submit"]:hover,
			input[type="reset"]:hover,
			button:hover,
			.comment-reply-link:hover,
			.entry-categories a:hover,
			.slide-categories a:hover {
				background-color: <?php echo get_theme_mod( 'button_background_hover_color' ); ?>;
			}
			<?php
		}

		//
		// Header bar
		//
		if ( get_theme_mod( 'header_bar_bg_color' ) ) {
			?>
			.site-bar {
				background-color: <?php echo get_theme_mod( 'header_bar_bg_color' ); ?>;
			}
			<?php
		}
		
		if ( get_theme_mod( 'header_bar_border_color' ) ) {
			?>
			.site-bar {
				border-bottom: solid 1px <?php echo get_theme_mod( 'header_bar_border_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_bar_text_color' ) ) {
			?>
			.site-bar,
			#masthead .tagline {
				color: <?php echo get_theme_mod( 'header_bar_text_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_bar_link_color' ) ) {
			?>
			.site-bar a {
				color: <?php echo get_theme_mod( 'header_bar_link_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_bar_hover_color' ) ) {
			?>
			.site-bar a:hover,
			#masthead .navigation > li.sfHover > a {
				color: <?php echo get_theme_mod( 'header_bar_hover_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_bar_subnav_bg_color' ) ) {
			?>
			#masthead .navigation > li ul a,
			#masthead .navigation ul {
				background-color: <?php echo get_theme_mod( 'header_bar_subnav_bg_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_bar_subnav_link_color' ) ) {
			?>
			#masthead .navigation > li ul a {
				color: <?php echo get_theme_mod( 'header_bar_subnav_link_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'header_bar_subnav_hover_color' ) ) {
			?>
			#masthead .navigation > li ul a:hover,
			#masthead .navigation ul > li.sfHover > a {
				color: <?php echo get_theme_mod( 'header_bar_subnav_hover_color' ); ?>;
			}
			<?php
		}


		//
		// Logo
		//
		if( get_theme_mod( 'logo_padding_top' ) || get_theme_mod( 'logo_padding_bottom' ) ) {
			?>
			#masthead .site-logo img {
				<?php if( get_theme_mod( 'logo_padding_top' ) ): ?>
					padding-top: <?php echo intval( get_theme_mod( 'logo_padding_top' ) ); ?>px;
				<?php endif; ?>
				<?php if( get_theme_mod( 'logo_padding_bottom' ) ): ?>
					padding-bottom: <?php echo intval( get_theme_mod( 'logo_padding_bottom' ) ); ?>px;
				<?php endif; ?>
			}
			<?php
		}
		
		
		if ( get_theme_mod( 'header_bg_color' ) ) {
			?>
			#masthead .site-logo {
				background-color: <?php echo get_theme_mod( 'header_bg_color' ); ?>;
			}
			<?php
		}
		
		$header_image = get_header_image();
		if ( $header_image ) {
			?>
			#masthead .site-logo {
				background-image: url('<?php echo esc_url( $header_image ); ?>');
				background-repeat: <?php echo get_theme_mod( 'header_bg_repeat', 'no-repeat' ); ?>;
				background-position: <?php echo get_theme_mod( 'header_bg_position_x', 'left' ) . ' ' . get_theme_mod( 'logo_background_position_y', 'top' ); ?>;
			}
			<?php
		}
			
		if ( get_theme_mod( 'header_bg_fixed' ) == 1 ) {
			?>
			#masthead .site-logo {
				background-attachment: fixed;
			}
			<?php
		}
			
		if ( get_theme_mod( 'header_margin_bottom' ) ) {
			?>
			#masthead .site-logo {
				margin-bottom: <?php echo intval( get_theme_mod( 'header_margin_bottom' ) ); ?>px;
			}
			<?php
		}

		//
		// Footer
		//
		if( get_theme_mod( 'footer_bg_color' ) ) {
			?>
			#footer {
				background-color: <?php echo get_theme_mod( 'footer_bg_color' ); ?>;
			}
			<?php
		}
		
		if( get_theme_mod( 'footer_bg_image' ) ) {
			?>
			#footer {
				background-image: url('<?php echo get_theme_mod( 'footer_bg_image' ); ?>');
				background-repeat: <?php echo get_theme_mod( 'footer_background_repeat', 'no-repeat' ); ?>; 
				background-position: <?php echo get_theme_mod( 'footer_bg_position_x', 'left' ) . ' ' . get_theme_mod( 'footer_bg_position_y', 'top' ) ; ?>;
			}
			<?php
		}

		if( get_theme_mod( 'footer_text_color' ) ) {
			?>
			#footer .tagline,
			#footer {
				color: <?php echo get_theme_mod( 'footer_text_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'footer_link_color' ) ) {
			?>
			#footer a,
			#footer .nav .navigation li a,
			#footer .socials a,
			#footer .site-logo a {
				color: <?php echo get_theme_mod( 'footer_link_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'footer_hover_color' ) ) {
			?>
			#footer a:hover,
			#footer .nav .navigation li a:hover,
			#footer .socials a:hover,
			#footer .site-logo a:hover {
				color: <?php echo get_theme_mod( 'footer_hover_color' ); ?>;
			}
			<?php
		}


		//
		// Typography
		//
		if( get_theme_mod( 'h1_size' ) ) {
			?>
			h1 {
				font-size: <?php echo get_theme_mod( 'h1_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h2_size' ) ) {
			?>
			h2 {
				font-size: <?php echo get_theme_mod( 'h2_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h3_size' ) ) {
			?>
			h3 {
				font-size: <?php echo get_theme_mod( 'h3_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h4_size' ) ) {
			?>
			h4 {
				font-size: <?php echo get_theme_mod( 'h4_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h5_size' ) ) {
			?>
			h5 {
				font-size: <?php echo get_theme_mod( 'h5_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'h6_size' ) ) {
			?>
			h6 {
				font-size: <?php echo get_theme_mod( 'h6_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'body_text_size' ) ) {
			?>
			body {
				font-size: <?php echo get_theme_mod( 'body_text_size' ); ?>px;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_title_size' ) ) {
			?>
			#sidebar .widget-title {
				font-size: <?php echo get_theme_mod( 'widgets_title_size' ); ?>px;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_logo', 1 ) ) {
			?>
			.site-logo {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_content_headings', 1 ) ) {
			?>
			.entry-content h1,
			.entry-content h2,
			.entry-content h3,
			.entry-content h4,
			.entry-content h5,
			.entry-content h6,
			#site-section h2 {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_post_titles', 1 ) ) {
			?>
			.entry-title,
			.slide-title {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_widget_titles', 1 ) ) {
			?>
			.widget-title,
			.comment-reply-title {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_navigation', 1 ) ) {
			?>
			.nav {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_buttons', 1 ) ) {
			?>
			.btn,
			input[type="button"],
			input[type="submit"],
			input[type="reset"],
			button,
			.comment-reply-link,
			.read-more {
				text-transform: uppercase;
			}
			<?php
		}

		if ( get_theme_mod( 'capital_entry_meta', 1 ) ) {
			?>
			.entry-meta,
			.entry-tags,
			.entry-sig,
			.comment-metadata,
			.slide-meta {
				text-transform: uppercase;
			}
			<?php
		}

		//
		// Sidebar
		//
		if( get_theme_mod( 'sidebar_bg_color' ) ) {
			?>
			#sidebar {
				background-color: <?php echo get_theme_mod( 'sidebar_bg_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'sidebar_border_color' ) ) {
			?>
			#sidebar, #site-section h2 {
				border-color: <?php echo get_theme_mod( 'sidebar_border_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'widgets_border_color' ) ) {
			?>
			#sidebar .widget,
			.widget_meta ul li a,
			.widget_pages ul li a,
			.widget_categories ul li a,
			.widget_archive ul li a,
			.widget_nav_menu ul li a,
			.widget_recent_entries ul li a,
			.widget_recent_comments ul li {
				border-color: <?php echo get_theme_mod( 'widgets_border_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_title_bg_color' ) ) {
			?>
			#sidebar .widget-title {
				background-color: <?php echo get_theme_mod( 'widgets_title_bg_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_title_color' ) ) {
			?>
			#sidebar .widget-title{
				color: <?php echo get_theme_mod( 'widgets_title_color' ); ?>;
			}

			#sidebar .widget-title:after {
				background: <?php echo get_theme_mod( 'widgets_title_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'widgets_text_color' ) ) {
			?>
			#sidebar {
				color: <?php echo get_theme_mod( 'widgets_text_color' ); ?>;
			}
			<?php
		}

		if( get_theme_mod( 'widgets_link_color' ) ) {
			?>
			#sidebar a {
				color: <?php echo get_theme_mod( 'widgets_link_color' ); ?>;
			}
			<?php
		}

		if ( get_theme_mod( 'widgets_hover_color' ) ) {
			?>
			#sidebar a:hover {
				color: <?php echo get_theme_mod( 'widgets_hover_color' ); ?>;
			}
			<?php
		}

		// TODO: Remove this after two versions from when the option was removed.
		if( get_theme_mod( 'custom_css' ) ) {
			echo get_theme_mod( 'custom_css' );
		}

	?></style><?php
}
endif;

if ( ! function_exists( 'untoldstories_custom_background_cb' ) ) :
function untoldstories_custom_background_cb() {
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color ) {
		if ( is_customize_preview() ) {
			echo '<style type="text/css" id="custom-background-css"></style>';
		}
		return;
	}

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url(" . wp_json_encode( $background ) . ");";

		// Background Position.
		$position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		$position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );

		if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
			$position_x = 'left';
		}

		if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
			$position_y = 'top';
		}

		$position = " background-position: $position_x $position_y;";

		// Background Size.
		$size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );

		if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
			$size = 'auto';
		}

		$size = " background-size: $size;";

		// Background Repeat.
		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

		if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
			$repeat = 'repeat';
		}

		$repeat = " background-repeat: $repeat;";

		// Background Scroll.
		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

		if ( 'fixed' !== $attachment ) {
			$attachment = 'scroll';
		}

		$attachment = " background-attachment: $attachment;";

		$style .= $image . $position . $size . $repeat . $attachment;
	}
	?>
	<style type="text/css" id="custom-background-css">
		body.custom-background #main-wrap { <?php echo trim( $style ); ?> }
	</style>
	<?php
}
endif;
