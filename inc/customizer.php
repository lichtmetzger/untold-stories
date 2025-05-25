<?php
add_action( 'customize_register', 'untoldstories_customize_register', 100 );
/**
 * Registers all theme-related options to the Customizer.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function untoldstories_customize_register( $wpc ) {

	$wpc->get_panel( 'nav_menus' )->priority = 2;

	$wpc->add_panel( 'header', array(
		'title'       => esc_html_x( 'Header', 'customizer panel title', 'untold-stories' ),
		'description' => esc_html__( 'Options affecting the header area.', 'untold-stories' ),
		'priority'    => 20
	) );
	$wpc->add_section( 'header_bar', array(
		'title'       => esc_html_x( 'Top Bar', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'Header Bar related options.', 'untold-stories' ),
		'priority'    => 10,
		'panel'       => 'header',
	) );
	$wpc->add_section( 'header_logo', array(
		'title'       => esc_html_x( 'Logo', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'Logo related options.', 'untold-stories' ),
		'panel'       => 'header',
	) );
	$wpc->add_section( 'header_bg', array(
		'title'       => esc_html_x( 'Background', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'Header Background options.', 'untold-stories' ),
		'panel'       => 'header',
	) );


	$wpc->add_section( 'layout', array(
		'title'    => esc_html_x( 'Layout Options', 'customizer section title', 'untold-stories' ),
		'priority' => 20
	) );

	$wpc->add_section( 'homepage', array(
		'title'    => esc_html_x( 'Front Page Carousel', 'customizer section title', 'untold-stories' ),
		'priority' => 25
	) );

	$wpc->add_section( 'typography', array(
		'title'    => esc_html_x( 'Typography Options', 'customizer section title', 'untold-stories' ),
		'priority' => 30
	) );

	$wpc->get_section( 'colors' )->title    = esc_html__( 'Content Colors', 'untold-stories' );
	$wpc->get_section( 'colors' )->priority = 40;

	$wpc->add_section( 'sidebar', array(
		'title'       => esc_html_x( 'Sidebar Colors', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'These options affect your sidebar (when visible).', 'untold-stories' ),
		'priority'    => 50
	) );

	// The following line doesn't work in a some PHP versions. Apparently, get_panel( 'widgets' ) returns an array,
	// therefore a cast to object is needed. http://wordpress.stackexchange.com/questions/160987/warning-creating-default-object-when-altering-customize-panels
	//$wpc->get_panel( 'widgets' )->priority = 55;
	$panel_widgets = (object) $wpc->get_panel( 'widgets' );
	$panel_widgets->priority = 55;

	$wpc->add_section( 'social', array(
		'title'       => esc_html_x( 'Social Networks', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'Enter your social network URLs. Leaving a URL empty will hide its respective icon.', 'untold-stories' ),
		'priority'    => 60
	) );

	$wpc->add_section( 'single_post', array(
		'title'       => esc_html_x( 'Posts Options', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'These options affect your individual posts.', 'untold-stories' ),
		'priority'    => 70
	) );

	$wpc->add_section( 'single_page', array(
		'title'       => esc_html_x( 'Pages Options', 'customizer section title', 'untold-stories' ),
		'description' => esc_html__( 'These options affect your individual pages.', 'untold-stories' ),
		'priority'    => 80
	) );

	$wpc->add_section( 'footer', array(
		'title'       => esc_html_x( 'Footer Options', 'customizer section title', 'untold-stories' ),
		'priority'    => 100
	) );

	// Section 'static_front_page' is not defined when there are no pages.
	if ( get_pages() ) {
		$wpc->get_section('static_front_page')->priority = 110;
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$wpc->add_section( 'theme_woocommerce', array(
			'title'    => esc_html_x( 'Theme Options', 'customizer section title', 'untold-stories' ),
			'panel'    => 'woocommerce',
			'priority' => 115, // After Other
		) );
	}

	/*
	 * Group options by registering the setting first, and the control right after.
	 */

	//
	// Layout
	//
	$wpc->add_setting( 'inset_sidebar_title', array(
		'default'           => '',
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'inset_sidebar_title', array(
		'type'    => 'text',
		'section' => 'layout',
		'label'   => esc_html__( 'Inset widgetized area title', 'untold-stories' ),
	) );

	$choices = array(
		'classic_side'  => esc_html_x( 'Classic - Sidebar', 'page layout', 'untold-stories' ),
		'classic_full'  => esc_html_x( 'Classic - Full width', 'page layout', 'untold-stories' ),
		'small_side'    => esc_html_x( 'Small images - Sidebar', 'page layout', 'untold-stories' ),
		'small_full'    => esc_html_x( 'Small images - Full width', 'page layout', 'untold-stories' ),
		'2cols_side'    => esc_html_x( 'Two columns - Sidebar', 'page layout', 'untold-stories' ),
		'2cols_full'    => esc_html_x( 'Two columns - Full width', 'page layout', 'untold-stories' ),
		'2cols_narrow'  => esc_html_x( 'Two columns - Narrow - Full width', 'page layout', 'untold-stories' ),
		'2cols_masonry' => esc_html_x( 'Two columns - Masonry', 'page layout', 'untold-stories' ),
		'3cols_full'    => esc_html_x( 'Three columns - Full width', 'page layout', 'untold-stories' ),
		'3cols_masonry' => esc_html_x( 'Three columns - Masonry - Full width', 'page layout', 'untold-stories' ),
	);
	$wpc->add_setting( 'layout_blog', array(
		'default'           => 'classic_side',
		'sanitize_callback' => 'untoldstories_sanitize_blog_terms_layout',
	) );
	$wpc->add_control( 'layout_blog', array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => esc_html__( 'Blog layout', 'untold-stories' ),
		'description' => esc_html__( 'Applies to the home page and blog-related pages.', 'untold-stories' ),
		'choices'     => $choices,
	) );

	$wpc->add_setting( 'layout_terms', array(
		'default'           => 'classic_side',
		'sanitize_callback' => 'untoldstories_sanitize_blog_terms_layout',
	) );
	$wpc->add_control( 'layout_terms', array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => esc_html__( 'Categories and Tags layout', 'untold-stories' ),
		'description' => esc_html__( 'Applies to the categories and tags listing pages.', 'untold-stories' ),
		'choices'     => $choices,
	) );

	$wpc->add_setting( 'layout_other', array(
		'default'           => 'side',
		'sanitize_callback' => 'untoldstories_sanitize_other_layout',
	) );
	$wpc->add_control( 'layout_other', array(
		'type'        => 'select',
		'section'     => 'layout',
		'label'       => esc_html__( 'Other Pages layout', 'untold-stories' ),
		'description' => esc_html__( 'Applies to all other pages, e.g. search, 404, etc.', 'untold-stories' ),
		'choices'     => array(
			'side' => esc_html_x( 'With sidebar', 'page layout', 'untold-stories' ),
			'full' => esc_html_x( 'Full width', 'page layout', 'untold-stories' ),
		),
	) );

	$wpc->add_setting( 'excerpt_length', array(
		'default'           => 55,
		'sanitize_callback' => 'absint',
	) );
	$wpc->add_control( 'excerpt_length', array(
		'type'        => 'number',
		'input_attrs' => array(
			'min'  => 10,
			'step' => 1,
		),
		'section'     => 'layout',
		'label'       => esc_html__( 'Automatically generated excerpt length (in words)', 'untold-stories' ),
	) );

	$wpc->add_setting( 'pagination_method', array(
		'default'           => 'numbers',
		'sanitize_callback' => 'untoldstories_sanitize_pagination_method',
	) );
	$wpc->add_control( 'pagination_method', array(
		'type'    => 'select',
		'section' => 'layout',
		'label'   => esc_html__( 'Pagination method', 'untold-stories' ),
		'choices' => array(
			'numbers' => esc_html_x( 'Numbered links', 'pagination method', 'untold-stories' ),
			'text'    => esc_html_x( '"Previous - Next" links', 'pagination method', 'untold-stories' ),
		),
	) );



	//
	// Header Bar
	//
	$wpc->add_setting( 'header_bar_sticky', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_bar_sticky', array(
		'type'        => 'checkbox',
		'section'     => 'header_bar',
		'label'       => esc_html__( 'Sticky header.', 'untold-stories' ),
		'description' => esc_html__( 'When enabled, the header remains visible when scrolling.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'header_bar_search', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_bar_search', array(
		'type'    => 'checkbox',
		'section' => 'header_bar',
		'label'   => esc_html__( 'Show search bar.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'header_bar_socials', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_bar_socials', array(
		'type'    => 'checkbox',
		'section' => 'header_bar',
		'label'   => esc_html__( 'Show social icons.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'header_bar_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_bg_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Background color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_border_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Border color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_text_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Text color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_link_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Link color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_hover_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Hover color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_subnav_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_subnav_bg_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Sub-menu background color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_subnav_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_subnav_link_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Sub-menu link color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'header_bar_subnav_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bar_subnav_hover_color', array(
		'section' => 'header_bar',
		'label'   => esc_html__( 'Sub-menu hover color', 'untold-stories' ),
	) ) );



	//
	// header_logo Section
	//
	$wpc->add_setting( 'logo', array(
		'default'           => get_template_directory_uri() . '/images/logo.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'logo', array(
		'section'     => 'header_logo',
		'priority'    => 20,
		'label'       => esc_html__( 'Logo', 'untold-stories' ),
		'description' => esc_html__( 'If an image is selected, it will replace the default textual logo (site name) on the header.', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'logo_padding_top', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'logo_padding_top', array(
		'type'     => 'number',
		'section'  => 'header_logo',
		'priority' => 20,
		'label'    => esc_html__( 'Logo top padding', 'untold-stories' ),
	) );

	$wpc->add_setting( 'logo_padding_bottom', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'logo_padding_bottom', array(
		'type'     => 'number',
		'section'  => 'header_logo',
		'priority' => 20,
		'label'    => esc_html__( 'Logo bottom padding', 'untold-stories' ),
	) );



	//
	// header_bg Section
	//
	// Beginning with this one, the rest of the controls in this section need a priority in order to display as they should.
	// Otherwise 'header_image' takes precedence before other controls, even if they all have a priority of 30.
	$wpc->add_setting( 'header_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'header_bg_color', array(
		'section'  => 'header_bg',
		'priority' => 29,
		'label'    => esc_html__( 'Background color', 'untold-stories' ),
	) ) );

	$wpc->get_control( 'header_image' )->priority = 30;
	$wpc->get_control( 'header_image' )->section = 'header_bg';

	$wpc->add_setting( 'header_bg_repeat', array(
		'default'           => 'no-repeat',
		'sanitize_callback' => 'untoldstories_sanitize_repeat_choices',
	) );
	$wpc->add_control( 'header_bg_repeat', array(
		'type'     => 'select',
		'section'  => 'header_bg',
		'priority' => 30,
		'label'    => esc_html__( 'Background Image Repeat', 'untold-stories' ),
		'choices'  => untoldstories_get_repeat_choices(),
	) );

	$wpc->add_setting( 'header_bg_position_x', array(
		'default'           => 'left',
		'sanitize_callback' => 'untoldstories_sanitize_bg_position_x',
	) );
	$wpc->add_control( 'header_bg_position_x', array(
		'type'     => 'select',
		'section'  => 'header_bg',
		'priority' => 30,
		'label'    => esc_html__( 'Background Image Horizontal Position', 'untold-stories' ),
		'choices'  => untoldstories_get_bg_position_x_choices(),
	) );

	$wpc->add_setting( 'logo_background_position_y', array(
		'default'	=> 'top',
		'sanitize_callback' => 'untoldstories_sanitize_bg_position_y',
	) );
	$wpc->add_control( 'logo_background_position_y', array(
		'type'     => 'select',
		'section'  => 'header_bg',
		'priority' => 30,
		'label'    => esc_html__( 'Background Image Vertical Position', 'untold-stories' ),
		'choices'  => untoldstories_get_bg_position_y_choices(),
	) );

	$wpc->add_setting( 'header_bg_fixed', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'header_bg_fixed', array(
		'type'        => 'checkbox',
		'section'     => 'header_bg',
		'priority'    => 30,
		'label'       => esc_html__( 'Fixed Background Image.', 'untold-stories' ),
		'description' => esc_html__( 'If checked, the image will not scroll along with the page.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'header_margin_bottom', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'header_margin_bottom', array(
		'type'        => 'number',
		'section'     => 'header_bg',
		'priority'    => 30,
		'label'       => esc_html__( 'Logo bottom margin', 'untold-stories' ),
		'description' => esc_html__( 'When a header image or color is set, you may want to increase this value for visual separation.', 'untold-stories' ),
	) );


	//
	// Footer
	//
	$wpc->add_setting( 'footer_reveal', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'footer_reveal', array(
		'type'        => 'checkbox',
		'section'     => 'footer',
		'label'       => esc_html__( 'Reveal effect.', 'untold-stories' ),
		'description' => esc_html__( 'When enabled, the footer reveals itself progressively instead of following the page.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'footer_text', array(
		'default'           => untoldstories_get_default_footer_text(),
		'sanitize_callback' => 'untoldstories_sanitize_footer_text',
	) );
	$wpc->add_control( 'footer_text', array(
		'type'        => 'text',
		'section'     => 'footer',
		'label'       => esc_html__( 'Footer text', 'untold-stories' ),
		'description' => esc_html__( 'Allowed tags: a (href|class), img (src|class), span (class), i (class), b, em, strong.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'footer_tagline', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'footer_tagline', array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => esc_html__( 'Show tagline.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'footer_search', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'footer_search', array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => esc_html__( 'Show search bar.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'footer_socials', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'footer_socials', array(
		'type'    => 'checkbox',
		'section' => 'footer',
		'label'   => esc_html__( 'Show social icons.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'footer_logo', array(
		'default'           => get_template_directory_uri() . '/images/logo_footer.png',
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'footer_logo', array(
		'section'     => 'footer',
		'label'       => esc_html__( 'Footer Logo', 'untold-stories' ),
		'description' => esc_html__( 'If an image is selected, it will replace the default textual logo (site name) on the footer.', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'footer_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'footer_bg_color', array(
		'section' => 'footer',
		'label'   => esc_html__( 'Background color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'footer_bg_image', array(
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( new WP_Customize_Image_Control( $wpc, 'footer_bg_image', array(
		'section'     => 'footer',
		'label'       => esc_html__( 'Background Image', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'footer_background_repeat', array(
		'default'           => 'no-repeat',
		'sanitize_callback' => 'untoldstories_sanitize_repeat_choices',
	) );
	$wpc->add_control( 'footer_background_repeat', array(
		'type'        => 'select',
		'section'     => 'footer',
		'label'       => esc_html__( 'Background Image Repeat', 'untold-stories' ),
		'choices'     => untoldstories_get_repeat_choices(),
	) );

	$wpc->add_setting( 'footer_bg_position_x', array(
		'default'           => 'left',
		'sanitize_callback' => 'untoldstories_sanitize_bg_position_x',
	) );
	$wpc->add_control( 'footer_bg_position_x', array(
		'type'        => 'select',
		'section'     => 'footer',
		'label'       => esc_html__( 'Background Image Horizontal Position', 'untold-stories' ),
		'choices'     => untoldstories_get_bg_position_x_choices(),
	) );

	$wpc->add_setting( 'footer_bg_position_y', array(
		'default'           => 'top',
		'sanitize_callback' => 'untoldstories_sanitize_bg_position_y',
	) );
	$wpc->add_control( 'footer_bg_position_y', array(
		'type'        => 'select',
		'section'     => 'footer',
		'label'       => esc_html__( 'Background Image Vertical Position', 'untold-stories' ),
		'choices'     => untoldstories_get_bg_position_y_choices(),
	) );

	$wpc->add_setting( 'footer_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'footer_text_color', array(
		'section' => 'footer',
		'label'   => esc_html__( 'Text color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'footer_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'footer_link_color', array(
		'section' => 'footer',
		'label'   => esc_html__( 'Link color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'footer_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'footer_hover_color', array(
		'section' => 'footer',
		'label'   => esc_html__( 'Hover color', 'untold-stories' ),
	) ) );

	if ( class_exists( 'null_instagram_widget' ) ) {
		$wpc->add_setting( 'instagram_auto', array(
			'default'           => 1,
			'sanitize_callback' => 'untoldstories_sanitize_checkbox',
		) );
		$wpc->add_control( 'instagram_auto', array(
			'type'    => 'checkbox',
			'section' => 'footer',
			'label'   => esc_html__( 'WP Instagram: Slideshow.', 'untold-stories' ),
		) );

		$wpc->add_setting( 'instagram_speed', array(
			'default'           => 300,
			'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
		) );
		$wpc->add_control( 'instagram_speed', array(
			'type'    => 'number',
			'section' => 'footer',
			'label'   => esc_html__( 'WP Instagram: Slideshow Speed.', 'untold-stories' ),
		) );
	}



	//
	// Social
	//
	$wpc->add_setting( 'site_socials', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'site_socials', array(
		'type'        => 'checkbox',
		'section'     => 'social',
		'label'       => esc_html__( 'Site-wide social icons.', 'untold-stories' ),
		'description' => esc_html__( 'Shows floating icons on the side of your website. Not visible on mobile devices.', 'untold-stories' ),
	) );


	$networks = untoldstories_get_social_networks();

	foreach ( $networks as $network ) {
		$wpc->add_setting( 'social_' . $network['name'], array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wpc->add_control( 'social_' . $network['name'], array(
			'type'    => 'url',
			'section' => 'social',
			'label'   => sprintf( esc_html_x( '%s URL', 'social network url', 'untold-stories' ), $network['label'] ),
		) );
	}

	$wpc->add_setting( 'rss_feed', array(
		'default'           => get_bloginfo( 'rss2_url' ),
		'sanitize_callback' => 'esc_url_raw',
	) );
	$wpc->add_control( 'rss_feed', array(
		'type'    => 'url',
		'section' => 'social',
		'label'   => esc_html__( 'RSS Feed', 'untold-stories' ),
	) );



	//
	// Typography
	//
	$wpc->add_setting( 'h1_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h1_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H1 size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'h2_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h2_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H2 size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'h3_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h3_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H3 size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'h4_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h4_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H4 size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'h5_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h5_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H5 size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'h6_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'h6_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'H6 size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'body_text_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'body_text_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'Body text size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'widgets_title_size', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
	) );
	$wpc->add_control( 'widgets_title_size', array(
		'type'    => 'number',
		'section' => 'typography',
		'label'   => esc_html__( 'Widgets title size', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_logo', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_logo', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize textual logo and site tagline.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_navigation', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_navigation', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize navigation menus.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_content_headings', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_content_headings', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize post content headings (H1-H6).', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_post_titles', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_post_titles', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize post titles.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_entry_meta', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_entry_meta', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize entry meta (categories, time, tags).', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_widget_titles', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_widget_titles', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize widget titles.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'capital_buttons', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'capital_buttons', array(
		'type'    => 'checkbox',
		'section' => 'typography',
		'label'   => esc_html__( 'Capitalize button text.', 'untold-stories' ),
	) );



	//
	// Homepage
	//
	$wpc->add_control( new Untoldstories_Customize_Slick_Control( $wpc, 'home_slider', array(
		'section'     => 'homepage',
		'label'       => esc_html__( 'Home Carousel', 'untold-stories' ),
		'description' => esc_html__( 'Fine-tune the homepage carousel.', 'untold-stories' ),
	), array(
		'taxonomy' => 'category',
	) ) );

	$wpc->add_setting( 'carousel_alt', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'carousel_alt', array(
		'type'        => 'checkbox',
		'section'     => 'homepage',
		'label'       => esc_html__( 'Alternative carousel styling.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'carousel_fullwidth', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'carousel_fullwidth', array(
		'type'        => 'checkbox',
		'section'     => 'homepage',
		'label'       => esc_html__( 'Fullwidth slider.', 'untold-stories' ),
		'description' => esc_html__( 'When checked, the "Show sidebar" option below will be ignored.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'carousel_sidebar', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'carousel_sidebar', array(
		'type'        => 'checkbox',
		'section'     => 'homepage',
		'label'       => esc_html__( 'Show sidebar next to carousel.', 'untold-stories' ),
		'description' => esc_html__( 'The widgets that will be shown next to the carousel, should be assigned to the "Homepage Carousel" widget area. For best results, only assign the WP Instagram widget.', 'untold-stories' ),
	) );



	//
	// Global colors
	//
	$wpc->get_control( 'background_image' )->section      = 'colors';
	$wpc->get_control( 'background_repeat' )->section     = 'colors';
	$wpc->get_control( 'background_attachment' )->section = 'colors';
	if ( ! is_null( $wpc->get_control( 'background_position_x' ) ) ) {
		$wpc->get_control( 'background_position_x' )->section = 'colors';
	} else {
		$wpc->get_control( 'background_position' )->section = 'colors';
		$wpc->get_control( 'background_preset' )->section   = 'colors';
		$wpc->get_control( 'background_size' )->section     = 'colors';
	}

	$wpc->add_setting( 'site_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_text_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Text color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'site_headings_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_headings_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Headings color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'site_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_link_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Link color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'site_link_color_hover', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'site_link_color_hover', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Link hover color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'button_background_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'button_background_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Button background color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'button_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'button_text_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Button text color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'button_background_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'button_background_hover_color', array(
		'section' => 'colors',
		'label'   => esc_html__( 'Button background hover color', 'untold-stories' ),
	) ) );



	//
	// Single Post
	//
	$wpc->add_setting( 'single_categories', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_categories', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show categories.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_tags', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_tags', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show tags.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_date', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_date', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show date.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_comments', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_comments', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show comments.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_featured', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_featured', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show featured media.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_signature', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_signature', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show signature.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_social_sharing', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_social_sharing', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show social sharing buttons.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_nextprev', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_nextprev', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show next/previous post links.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_authorbox', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_authorbox', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show author box.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_related', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'single_related', array(
		'type'    => 'checkbox',
		'section' => 'single_post',
		'label'   => esc_html__( 'Show related posts.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'single_related_title', array(
		'default'           => esc_html__( 'You may also like', 'untold-stories' ),
		'sanitize_callback' => 'sanitize_text_field',
	) );
	$wpc->add_control( 'single_related_title', array(
		'type'    => 'text',
		'section' => 'single_post',
		'label'   => esc_html__( 'Related Posts section title', 'untold-stories' ),
	) );



	//
	// Single Page
	//
	$wpc->add_setting( 'page_signature', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'page_signature', array(
		'type'    => 'checkbox',
		'section' => 'single_page',
		'label'   => esc_html__( 'Show signature.', 'untold-stories' ),
	) );

	$wpc->add_setting( 'page_social_sharing', array(
		'default'           => 1,
		'sanitize_callback' => 'untoldstories_sanitize_checkbox',
	) );
	$wpc->add_control( 'page_social_sharing', array(
		'type'    => 'checkbox',
		'section' => 'single_page',
		'label'   => esc_html__( 'Show social sharing buttons.', 'untold-stories' ),
	) );



	//
	// Sidebar
	//
	$wpc->add_setting( 'sidebar_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_bg_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Background color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'sidebar_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'sidebar_border_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Border color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'widgets_border_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_border_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Widget border color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'widgets_title_bg_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_title_bg_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Widget title background color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'widgets_title_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_title_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Widget title color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'widgets_text_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_text_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Widget text color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'widgets_link_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_link_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Widget link color', 'untold-stories' ),
	) ) );

	$wpc->add_setting( 'widgets_hover_color', array(
		'default'           => '',
		'sanitize_callback' => 'untoldstories_sanitize_hex_color',
	) );
	$wpc->add_control( new WP_Customize_Color_Control( $wpc, 'widgets_hover_color', array(
		'section' => 'sidebar',
		'label'   => esc_html__( 'Widget hover color', 'untold-stories' ),
	) ) );



	//
	// WooCommerce
	//
	if ( class_exists( 'WooCommerce' ) ) {
		$wpc->add_setting( 'theme_products_number', array(
			'default'           => 10,
			'sanitize_callback' => 'untoldstories_sanitize_intval_or_empty',
		) );
		$wpc->add_control( 'theme_products_number', array(
			'type'        => 'number',
			'input_attrs' => array(
				'min'  => 1,
				'step' => 1,
			),
			'section'     => 'theme_woocommerce',
			'label'       => esc_html__( 'Number of products on shop listing page.', 'untold-stories' ),
		) );
	}


}


add_action( 'customize_register', 'untoldstories_customize_register_custom_controls', 9 );
/**
 * Registers custom Customizer controls.
 *
 * @param WP_Customize_Manager $wpc Reference to the customizer's manager object.
 */
function untoldstories_customize_register_custom_controls( $wpc ) {
	require get_template_directory() . '/inc/customizer-controls/slick.php';
}
