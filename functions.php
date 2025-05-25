<?php
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/sanitization.php';
require get_template_directory() . '/inc/functions.php';
require get_template_directory() . '/inc/helpers-post-meta.php';
require get_template_directory() . '/inc/taxonomies-post.php';
require get_template_directory() . '/inc/custom-fields-post.php';
require get_template_directory() . '/inc/custom-fields-page.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/customizer-styles.php';
require get_template_directory() . '/inc/user-meta.php';
require get_template_directory() . '/inc/term-meta.php';

add_action( 'after_setup_theme', 'untoldstories_content_width', 0 );
function untoldstories_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'untoldstories_content_width', 690 );
}

add_action( 'after_setup_theme', 'untoldstories_setup' );
if( !function_exists( 'untoldstories_setup' ) ) :
function untoldstories_setup() {

	if ( ! defined( 'THEME_NAME' ) ) {
		define( 'THEME_NAME', 'untoldstories' );
	}
	if ( ! defined( 'THEME_WHITELABEL' ) ) {
		// Set the following to true, if you want to remove any user-facing CSSIgniter traces.
		define( 'THEME_WHITELABEL', false );
	}

	load_theme_textdomain( 'untold-stories', get_template_directory() . '/languages' );

	/*
	 * Theme supports.
	 */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	add_theme_support( 'post-formats', array(
		'image',
		'gallery',
		'audio',
		'video',
	) );

	add_theme_support( 'custom-header', array(
		'header-text' => false,
		'height'      => 230,
		'flex-height' => true,
		'width'       => 1920,
		'flex-width'  => false,
	) );

	add_theme_support( 'custom-background', array(
		'wp-head-callback' => 'untoldstories_custom_background_cb',
	) );


	/*
	 * Image sizes.
	 */
    add_image_size( 'untoldstories_thumb_post', 600, 0, false);
	add_image_size( 'untoldstories_thumb_masonry', 690 );
	add_image_size( 'untoldstories_thumb_slider', 1050, 550, true );
	add_image_size( 'untoldstories_thumb_slider_small', 720, 459, true );
	add_image_size( 'untoldstories_thumb_wide', 0, 260, false);
	add_image_size( 'untoldstories_thumb_square', 200, 200, true);
	add_image_size( 'untoldstories_thumb_tall', 690, 1000, true);
    add_image_size( 'untoldstories_thumb_recipe', 600, 450, true);
    set_post_thumbnail_size( 600, 0, false );

    /*
     * Navigation menus.
     */
	register_nav_menus( array(
		'main_menu'   => esc_html__( 'Main Menu', 'untold-stories' ),
		'footer_menu' => esc_html__( 'Footer Menu', 'untold-stories' ),
	) );


	// The following is needed for compatibility with Untold Stories v1.0
	// It will be removed on Untold Stories v1.3
	untoldstories_migrate_old_theme_mods_1_1();


	/*
	 * Default hooks
	 */
	// Prints the inline JS scripts that are registered for printing, and removes them from the queue.
	add_action( 'admin_footer', 'untoldstories_print_inline_js' );
	add_action( 'wp_footer', 'untoldstories_print_inline_js' );

	// Handle the dismissible sample content notice.
	add_action( 'admin_notices', 'untoldstories_admin_notice_sample_content' );
	add_action( 'wp_ajax_untoldstories_dismiss_sample_content', 'untoldstories_ajax_dismiss_sample_content' );

	// Wraps post counts in span.untoldstories-count
	// Needed for the default widgets, however more appropriate filters don't exist.
	add_filter( 'get_archives_link', 'untoldstories_wrap_archive_widget_post_counts_in_span', 10, 2 );
	add_filter( 'wp_list_categories', 'untoldstories_wrap_category_widget_post_counts_in_span', 10, 2 );
}
endif;



add_action( 'wp_enqueue_scripts', 'untoldstories_enqueue_scripts' );
function untoldstories_enqueue_scripts() {

	/*
	 * Styles
	 */
	$theme = wp_get_theme();

    wp_register_style( 'untoldstories-webfonts', get_stylesheet_directory_uri() . '/fonts/webfonts/webfonts.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'untoldstories-base', get_template_directory_uri() . '/css/base.css', array(), $theme->get( 'Version' ) );
	wp_register_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', array(), '4.7.0' );
	wp_register_style( 'untoldstories-magnific', get_template_directory_uri() . '/css/magnific.css', array(), '1.0.0' );
	wp_register_style( 'untoldstories-slick', get_template_directory_uri() . '/css/slick.css', array(), '1.5.7' );
	wp_register_style( 'untoldstories-mmenu', get_template_directory_uri() . '/css/mmenu.css', array(), '5.2.0' );
	wp_register_style( 'untoldstories-justifiedGallery', get_template_directory_uri() . '/css/justifiedGallery.min.css', array(), '3.6.0' );

	wp_enqueue_style( 'untoldstories-style', get_template_directory_uri() . '/style.css', array(
        'untoldstories-webfonts',
		'untoldstories-base',
		'untoldstories-common',
		'font-awesome',
		'untoldstories-mmenu',
		'untoldstories-magnific',
		'untoldstories-slick',
		'untoldstories-justifiedGallery',
	), $theme->get( 'Version' ) );

	if( is_child_theme() ) {
		wp_enqueue_style( 'untoldstories-style-child', get_stylesheet_directory_uri() . '/style.css', array(
			'untoldstories-style',
		), $theme->get( 'Version' ) );
	}

	/*
	 * Scripts
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_register_script( 'untoldstories-modernizr', get_template_directory_uri() . '/js/modernizr.js', array(), '2.8.3', false );

	wp_register_script( 'untoldstories-superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '1.7.5', true );
	wp_register_script( 'untoldstories-instagramLite', get_template_directory_uri() . '/js/instagramLite.min.js', array( 'jquery' ), $theme->get( 'Version' ), true );
	wp_register_script( 'untoldstories-slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), '1.5.7', true );
	wp_register_script( 'untoldstories-mmenu', get_template_directory_uri() . '/js/jquery.mmenu.min.all.js', array( 'jquery' ), '5.2.0', true );
	wp_register_script( 'untoldstories-fitVids', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), '1.1', true );
	wp_register_script( 'untoldstories-magnific', get_template_directory_uri() . '/js/jquery.magnific-popup.js', array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'untoldstories-masonry', get_template_directory_uri() . '/js/masonry.min.js', array( 'jquery' ), '3.3.2', true );
	wp_register_script( 'untoldstories-justifiedGallery', get_template_directory_uri() . '/js/jquery.justifiedGallery.min.js', array( 'jquery' ), '3.6.0', true );


	/*
	 * Enqueue
	 */
	wp_enqueue_script( 'untoldstories-modernizr' );
	wp_enqueue_script( 'untoldstories-front-scripts', get_template_directory_uri() . '/js/scripts.js', array(
		'jquery',
		'untoldstories-superfish',
		'untoldstories-mmenu',
		'untoldstories-instagramLite',
		'untoldstories-slick',
		'untoldstories-fitVids',
		'untoldstories-magnific',
		'untoldstories-masonry',
		'untoldstories-justifiedGallery',
	), $theme->get( 'Version' ), true );

}

add_action( 'admin_enqueue_scripts', 'untoldstories_admin_enqueue_scripts' );
function untoldstories_admin_enqueue_scripts( $hook ) {
	$theme = wp_get_theme();

	/*
	 * Styles
	 */


	/*
	 * Scripts
	 */


	/*
	 * Enqueue
	 */
	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'untoldstories-theme-post-meta' );
		wp_enqueue_script( 'untoldstories-theme-post-meta' );
	}

	if ( in_array( $hook, array( 'profile.php', 'user-edit.php', 'edit-tags.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'untoldstories-theme-post-meta' );
		wp_enqueue_script( 'untoldstories-theme-post-meta' );
	}

	if ( in_array( $hook, array( 'widgets.php', 'customize.php' ) ) ) {
		wp_enqueue_media();
		wp_enqueue_style( 'untoldstories-theme-post-meta' );
		wp_enqueue_script( 'untoldstories-theme-post-meta' );
	}

}

add_action( 'customize_controls_print_styles', 'untoldstories_enqueue_customizer_styles' );
function untoldstories_enqueue_customizer_styles() {
	$theme = wp_get_theme();

	wp_register_style( 'untoldstories-customizer-styles', get_template_directory_uri() . '/css/admin/customizer-styles.css', array(), $theme->get( 'Version' ) );
	wp_enqueue_style( 'untoldstories-customizer-styles' );
}


add_action( 'widgets_init', 'untoldstories_widgets_init' );
function untoldstories_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html_x( 'Blog', 'widget area', 'untold-stories' ),
		'id'            => 'untoldstories_blog',
		'description'   => esc_html__( 'This is the main sidebar.', 'untold-stories' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Pages', 'widget area', 'untold-stories' ),
		'id'            => 'untoldstories_page',
		'description'   => esc_html__( 'This sidebar appears on your static pages. If empty, the Blog sidebar will be shown instead.', 'untold-stories' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Homepage Carousel', 'widget area', 'untold-stories' ),
		'id'            => 'untoldstories_carousel',
		'description'   => esc_html__( 'Widgets assigned here will appear next to the homepage carousel. For best results, only assign the WP Instagram widget. The widgets assigned here will only be shown if the carousel is displayed AND the "Show sidebar next to carousel" option is checked (Appearance > Customize > Front Page Carousel).', 'untold-stories' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Inset Sidebar', 'widget area', 'untold-stories' ),
		'id'            => 'untoldstories_inset',
		'description'   => esc_html__( 'Widgets assigned here will appear between the slideshow and the content of your website (for the homepage) or the logo and the main content of your website (for all other pages). You can set a general title of this section in the Customizer > Layout Options.', 'untold-stories' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html_x( 'Footer Sidebar', 'widget area', 'untold-stories' ),
		'id'            => 'untoldstories_footer_widgets',
		'description'   => esc_html__( 'Special site-wide sidebar for the WP Instagram Widget plugin.', 'untold-stories' ),
		'before_widget' => '<aside id="%1$s" class="widget group %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'untoldstories_load_widgets' );
function untoldstories_load_widgets() {
	require get_template_directory() . '/inc/widgets/untoldstories-about-me.php';
    require get_template_directory() . '/inc/widgets/untoldstories-about-me-mod.php';
	require get_template_directory() . '/inc/widgets/untoldstories-latest-posts.php';
	require get_template_directory() . '/inc/widgets/untoldstories-socials.php';
	require get_template_directory() . '/inc/widgets/untoldstories-newsletter.php';
	require get_template_directory() . '/inc/widgets/untoldstories-callout.php';

	if ( untoldstories_term_meta_supported() ) {
		require get_template_directory() . '/inc/widgets/untoldstories-category-image.php';
	}
}

add_filter( 'excerpt_length', 'untoldstories_excerpt_length' );
function untoldstories_excerpt_length( $length ) {
	return get_theme_mod( 'excerpt_length', 55 );
}


add_filter( 'previous_posts_link_attributes', 'untoldstories_previous_posts_link_attributes' );
function untoldstories_previous_posts_link_attributes( $attrs ) {
	$attrs .= ' class="paging-standard paging-older"';
	return $attrs;
}
add_filter( 'next_posts_link_attributes', 'untoldstories_next_posts_link_attributes' );
function untoldstories_next_posts_link_attributes( $attrs ) {
	$attrs .= ' class="paging-standard paging-newer"';
	return $attrs;
}

add_filter( 'wp_page_menu', 'untoldstories_wp_page_menu', 10, 2 );
function untoldstories_wp_page_menu( $menu, $args ) {
	preg_match( '#^<div class="(.*?)">(?:.*?)</div>$#', $menu, $matches );
	$menu = preg_replace( '#^<div class=".*?">#', '', $menu, 1 );
	$menu = preg_replace( '#</div>$#', '', $menu, 1 );
	$menu = preg_replace( '#^<ul>#', '<ul class="' . esc_attr( $args['menu_class'] ) . '">', $menu, 1 );
	return $menu;
}


add_filter( 'the_content', 'untoldstories_lightbox_rel', 12 );
add_filter( 'get_comment_text', 'untoldstories_lightbox_rel' );
add_filter( 'wp_get_attachment_link', 'untoldstories_lightbox_rel' );
if ( ! function_exists( 'untoldstories_lightbox_rel' ) ):
function untoldstories_lightbox_rel( $content ) {
	global $post;
	$pattern     = "/<a(.*?)href=('|\")([^>]*).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>(.*?)<\/a>/i";
	$replacement = '<a$1href=$2$3.$4$5 data-lightbox="gal[' . $post->ID . ']"$6>$7</a>';
	$content     = preg_replace( $pattern, $replacement, $content );

	return $content;
}
endif;


add_filter( 'wp_link_pages_args', 'untoldstories_wp_link_pages_args' );
function untoldstories_wp_link_pages_args( $params ) {
	$params = array_merge( $params, array(
		'before' => '<p class="link-pages">' . esc_html__( 'Pages:', 'untold-stories' ),
		'after'  => '</p>',
	) );

	return $params;
}

//
// Inject valid GET parameters as theme_mod values
//
add_filter( 'theme_mod_layout_blog', 'untoldstories_handle_url_theme_mod_layout_blog' );
function untoldstories_handle_url_theme_mod_layout_blog( $value ) {

	if( ! empty( $_GET['layout_blog'] ) ) {
		$value = untoldstories_sanitize_blog_terms_layout( $_GET['layout_blog'] );
	}
	return $value;
}
add_filter( 'theme_mod_layout_terms', 'untoldstories_handle_url_theme_mod_layout_terms' );
function untoldstories_handle_url_theme_mod_layout_terms( $value ) {

	if( ! empty( $_GET['layout_terms'] ) ) {
		$value = untoldstories_sanitize_blog_terms_layout( $_GET['layout_terms'] );
	}
	return $value;
}
add_filter( 'theme_mod_layout_other', 'untoldstories_handle_url_theme_mod_layout_other' );
function untoldstories_handle_url_theme_mod_layout_other( $value ) {

	if( ! empty( $_GET['layout_other'] ) ) {
		$value = untoldstories_sanitize_other_layout( $_GET['layout_other'] );
	}
	return $value;
}
add_filter( 'theme_mod_carousel_sidebar', 'untoldstories_handle_url_theme_mod_carousel_sidebar' );
function untoldstories_handle_url_theme_mod_carousel_sidebar( $value ) {

	if ( ! empty( $_GET['carousel_sidebar'] ) && $_GET['carousel_sidebar'] == 1 ) {
		if ( is_active_sidebar( 'untoldstories_carousel' ) ) {
			$value = 1;
		}
	}
	return $value;
}
add_filter( 'theme_mod_carousel_fullwidth', 'untoldstories_handle_url_theme_mod_carousel_fullwidth' );
function untoldstories_handle_url_theme_mod_carousel_fullwidth( $value ) {

	if ( ! empty( $_GET['carousel_fullwidth'] ) && $_GET['carousel_fullwidth'] == 1 ) {
		$value = 1;
	}
	return $value;
}

// Check if gravatar exicsts
// https://codex.wordpress.org/Using_Gravatars#Checking_for_the_Existence_of_a_Gravatar
if ( ! function_exists( 'untoldstories_validate_gravatar' ) ) {
	function untoldstories_validate_gravatar( $email ) {
		// Craft a potential url and test its headers
		$hash    = md5( strtolower( trim( $email ) ) );
		$uri     = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
		$headers = @get_headers( $uri );
		if ( ! preg_match( "|200|", $headers[0] ) ) {
			$has_valid_avatar = false;
		} else {
			$has_valid_avatar = true;
		}

		return $has_valid_avatar;
	}
}


function untoldstories_migrate_old_theme_mods_1_1() {
	// The following are needed for compatibility with Untold Stories v1.0
	// They will be removed on Untold Stories v1.3

	// This migrates the old 'untoldstories_*' theme mods to similarly named without the prefix as it's not needed.
	$prefix = 'untoldstories_';
	$mods = get_theme_mods();
	$mods = is_array( $mods ) ? $mods : array();
	foreach( $mods as $key => $value ) {

		if( untoldstories_substr_left( $key, strlen( $prefix ) ) == $prefix ) {
			set_theme_mod( str_replace( $prefix, '', $key ), get_theme_mod( $key ) );
			remove_theme_mod( $key );
		}
	}

	// This migrates the old 'untoldstories_site_bg_color' (now 'site_bg_color') option to the native 'custom-background' feature.
	if ( get_theme_mod( 'site_bg_color' ) !== false ) {
		set_theme_mod( 'background_color', untoldstories_sanitize_hex_color( get_theme_mod( 'site_bg_color' ), false ) );
		remove_theme_mod( 'site_bg_color' );
	}

}

add_filter( 'dynamic_sidebar_params', 'untoldstories_inset_sidebar_params' );
function untoldstories_inset_sidebar_params( $params ) {
	$sidebar_id = $params[0]['id'];

	if ( $sidebar_id == 'untoldstories_inset' ) {

		$total_widgets      = wp_get_sidebars_widgets();
		$sidebar_widgets_no = count( $total_widgets[ $sidebar_id ] );
		$class = '';

		if ( $sidebar_widgets_no === 1 ) {
			$class = 'col-xs-12';
		} elseif ( $sidebar_widgets_no%2 === 0 && $sidebar_widgets_no < 3 ) {
			$class = 'col-md-6';
		} else {
			$class = 'col-md-4';
		}

		$params[0]['before_widget'] = str_replace( 'class="', 'class="' . $class . ' ', $params[0]['before_widget'] );
	}

	return $params;
}



function untoldstories_get_repeat_choices() {
	return array(
		'no-repeat' => esc_html_x( 'No Repeat', 'background repeat', 'untold-stories' ),
		'repeat'    => esc_html_x( 'Repeat', 'background repeat', 'untold-stories' ),
		'repeat-x'  => esc_html_x( 'Repeat Horizontally', 'background repeat', 'untold-stories' ),
		'repeat-y'  => esc_html_x( 'Repeat Vertically', 'background repeat', 'untold-stories' ),

	);
}

function untoldstories_sanitize_repeat_choices( $value ) {
	$choices = untoldstories_get_repeat_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return 'no-repeat';
}

function untoldstories_get_bg_position_x_choices() {
	return array(
		'left'   => esc_html_x( 'Left', 'horizontal position', 'untold-stories' ),
		'center' => esc_html_x( 'Center', 'horizontal position', 'untold-stories' ),
		'right'  => esc_html_x( 'Right', 'horizontal position', 'untold-stories' ),
	);
}

function untoldstories_sanitize_bg_position_x( $value ) {
	$choices = untoldstories_get_bg_position_x_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return 'left';
}

function untoldstories_get_bg_position_y_choices() {
	return array(
		'top'    => esc_html_x( 'Top', 'vertical position', 'untold-stories' ),
		'center' => esc_html_x( 'Center', 'vertical position', 'untold-stories' ),
		'bottom' => esc_html_x( 'Bottom', 'vertical position', 'untold-stories' ),
	);
}

function untoldstories_sanitize_bg_position_y( $value ) {
	$choices = untoldstories_get_bg_position_y_choices();
	if ( array_key_exists( $value, $choices ) ) {
		return $value;
	}

	return 'top';
}

function untoldstories_get_default_footer_text() {
	if ( ! defined( 'THEME_WHITELABEL' ) || ! THEME_WHITELABEL ) {
		$text = sprintf( '<a href="%s">Untold Stories WordPress theme</a> by <a href="%s">CSSIgniter.com</a>',
			esc_url( 'http://themeforest.net/item/untold-stories-the-wordpress-blog-theme/12897880' ),
			esc_url( 'http://www.cssigniter.com' )
		);
	} else {
		$text = sprintf( '<a href="%1$s">%2$s</a> &ndash; Powered by <a href="%3$s">WordPress</a>',
			esc_url( home_url( '/' ) ),
			get_bloginfo( 'name' ),
			esc_url( 'https://wordpress.org/' )
		);
	}

	return $text;
}

if ( ! function_exists( 'untoldstories_sanitize_blog_terms_layout' ) ):
function untoldstories_sanitize_blog_terms_layout( $layout ) {
	$layouts = array(
		'classic_side',
		'classic_full',
		'small_side',
		'small_full',
		'2cols_side',
		'2cols_full',
		'2cols_narrow',
		'2cols_masonry',
		'3cols_full',
		'3cols_masonry',
	);
	if ( in_array( $layout, $layouts ) ) {
		return $layout;
	}

	return 'classic_side';
}
endif;

if ( ! function_exists( 'untoldstories_sanitize_other_layout' ) ):
function untoldstories_sanitize_other_layout( $layout ) {
	$layouts = array(
		'side',
		'full',
	);
	if ( in_array( $layout, $layouts ) ) {
		return $layout;
	}

	return 'side';
}
endif;


function untoldstories_sanitize_footer_text( $text ) {
	$allowed_html = array(
		'a'      => array(
			'href'  => array(),
			'class' => array(),
		),
		'img'    => array(
			'src'   => array(),
			'class' => array(),
		),
		'span'   => array(
			'class' => array(),
		),
		'i'      => array(
			'class' => array(),
		),
		'b'      => array(),
		'em'     => array(),
		'strong' => array(),
	);

	return wp_kses( $text, $allowed_html );
}

// TODO: Remove this and all occurences when WP v4.6 is released.
function untoldstories_term_meta_supported() {
	if ( get_option( 'db_version' ) < 34370 || ! function_exists( 'get_term_meta' ) ) {
		return false;
	}

	return true;
}

if ( ! function_exists( 'untoldstories_get_social_networks') ) {
	function untoldstories_get_social_networks() {
		return array(
			array(
				'name'  => 'facebook',
				'label' => esc_html__( 'Facebook', 'untold-stories' ),
				'icon'  => 'fa-facebook',
			),
			array(
				'name'  => 'twitter',
				'label' => esc_html__( 'Twitter', 'untold-stories' ),
				'icon'  => 'fa-twitter',
			),
			array(
				'name'  => 'pinterest',
				'label' => esc_html__( 'Pinterest', 'untold-stories' ),
				'icon'  => 'fa-pinterest',
			),
			array(
				'name'  => 'instagram',
				'label' => esc_html__( 'Instagram', 'untold-stories' ),
				'icon'  => 'fa-instagram',
			),
			array(
				'name'  => 'linkedin',
				'label' => esc_html__( 'LinkedIn', 'untold-stories' ),
				'icon'  => 'fa-linkedin',
			),
			array(
				'name'  => 'tumblr',
				'label' => esc_html__( 'Tumblr', 'untold-stories' ),
				'icon'  => 'fa-tumblr',
			),
			array(
				'name'  => 'flickr',
				'label' => esc_html__( 'Flickr', 'untold-stories' ),
				'icon'  => 'fa-flickr',
			),
			array(
				'name'  => 'bloglovin',
				'label' => esc_html__( 'Bloglovin', 'untold-stories' ),
				'icon'  => 'fa-heart',
			),
			array(
				'name'  => 'youtube',
				'label' => esc_html__( 'YouTube', 'untold-stories' ),
				'icon'  => 'fa-youtube',
			),
			array(
				'name'  => 'vimeo',
				'label' => esc_html__( 'Vimeo', 'untold-stories' ),
				'icon'  => 'fa-vimeo',
			),
			array(
				'name'  => 'dribbble',
				'label' => esc_html__( 'Dribbble', 'untold-stories' ),
				'icon'  => 'fa-dribbble',
			),
			array(
				'name'  => 'wordpress',
				'label' => esc_html__( 'WordPress', 'untold-stories' ),
				'icon'  => 'fa-wordpress',
			),
			array(
				'name'  => '500px',
				'label' => esc_html__( '500px', 'untold-stories' ),
				'icon'  => 'fa-500px',
			),
			array(
				'name'  => 'soundcloud',
				'label' => esc_html__( 'Soundcloud', 'untold-stories' ),
				'icon'  => 'fa-soundcloud',
			),
			array(
				'name'  => 'spotify',
				'label' => esc_html__( 'Spotify', 'untold-stories' ),
				'icon'  => 'fa-spotify',
			),
			array(
				'name'  => 'vine',
				'label' => esc_html__( 'Vine', 'untold-stories' ),
				'icon'  => 'fa-vine',
			),
			array(
				'name'  => 'snapchat',
				'label' => esc_html__( 'Snapchat', 'untold-stories' ),
				'icon'  => 'fa-snapchat-ghost',
			),
			array(
				'name'  => 'tripadvisor',
				'label' => esc_html__( 'Trip Advisor', 'untold-stories' ),
				'icon'  => 'fa-tripadvisor',
			),
			array(
				'name'  => 'telegram',
				'label' => esc_html__( 'Telegram', 'untold-stories' ),
				'icon'  => 'fa-telegram',
			),
		);
	}
}

if ( ! function_exists( 'untoldstories_get_layout_classes' ) ) {
	function untoldstories_get_layout_classes( $setting ) {
		$layout      = get_theme_mod( $setting, 'classic_side' );
		$content_col = '';
		$sidebar_col = '';
		$main_class  = 'entries-classic';
		$post_class  = '';
		$post_col    = '';
		$masonry     = false;

		switch ( $layout ) {
			case 'classic_side':
				$content_col = 'col-md-8';
				$sidebar_col = 'col-md-4';
				break;
			case 'classic_full' :
				$content_col = 'col-md-8 col-md-offset-2';
				break;
			case 'small_side' :
				$content_col = 'col-md-8';
				$sidebar_col = 'col-md-4';
				$main_class  = 'entries-list';
				$post_class  = 'entry-list';
				break;
			case 'small_full' :
				$content_col = 'col-md-8 col-md-offset-2';
				$main_class  = 'entries-list';
				$post_class  = 'entry-list';
				break;
			case '2cols_side' :
				$content_col = 'col-md-8';
				$sidebar_col = 'col-md-4';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6';
				break;
			case '2cols_full' :
				$content_col = 'col-md-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6';
				break;
			case '2cols_narrow' :
				$content_col = 'col-md-8 col-md-offset-2';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6';
				break;
			case '2cols_masonry' :
				$content_col = 'col-md-8';
				$sidebar_col = 'col-md-4';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-sm-6';
				$masonry     = true;
				break;
			case '3cols_full' :
				$content_col = 'col-md-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-md-4 col-sm-6';
				break;
			case '3cols_masonry' :
				$content_col = 'col-md-12';
				$main_class  = 'entries-grid';
				$post_class  = 'entry-grid';
				$post_col    = 'col-md-4 col-sm-6';
				$masonry     = true;
				break;
		}

		return array(
			'layout'      => $layout,
			'content_col' => $content_col,
			'sidebar_col' => $sidebar_col,
			'main_class'  => $main_class,
			'post_class'  => $post_class,
			'post_col'    => $post_col,
			'masonry'     => $masonry
		);
	}
}

/**
 * WooCommerce integration.
 */
require_once get_template_directory() . '/inc/woocommerce.php';

require_once get_template_directory() . '/inc/onboarding.php';

add_action( 'init', 'untoldstories_migrate_custom_css_to_customizer' );
function untoldstories_migrate_custom_css_to_customizer() {
	if ( ! is_admin() || wp_doing_ajax() || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) ) {
		return;
	}

	$migrated = get_theme_mod( 'custom_css_migrated', false );

	if ( $migrated || ! function_exists( 'wp_update_custom_css_post' ) ) {
		return;
	}

	// Migrate any existing theme CSS to the core option added in WordPress 4.7.
	$css = get_theme_mod( 'custom_css', '' );
	if ( $css ) {
		// Preserve any CSS already added to the core option.
		$core_css = wp_get_custom_css();

		$return = wp_update_custom_css_post( $core_css .
			PHP_EOL . PHP_EOL .
			"/* Migrated CSS from the theme's old custom CSS setting. */" .
			PHP_EOL .
			html_entity_decode( $css )
		);

		if ( ! is_wp_error( $return ) ) {
			// Remove the old option, so that the CSS is stored in only one place moving forward.
			set_theme_mod( 'custom_css', '' );
			set_theme_mod( 'custom_css_migrated', true );
		}
	}
}

/**
 * Set default options when inserting images into posts.
 * This is mainly used to get higher quality thumbnails and link
 * directly to the image file (for lightboxes).
 */
add_action( 'admin_head-post.php', 'untoldstories_set_default_image_insert_options' );
add_action( 'admin_head-post-new.php', 'untoldstories_set_default_image_insert_options' );
function untoldstories_set_default_image_insert_options() {
    ?>
    <script>
        if ( typeof setUserSetting !== 'undefined' ) {
            setUserSetting( 'align', 'none' ); // none || left || center || right
            setUserSetting( 'imgsize', 'medium' ); // thumbnail || medium || large || full
            setUserSetting( 'urlbutton', 'file' ); // none || file || post
        }
    </script>
    <?php
}

/**
 *  WordPress core functionality overrides.
 */
require_once get_theme_file_path( '/common/core-tweaks.php' );

/**
 *  Common theme features.
 */
require_once get_theme_file_path( '/common/common.php' );
