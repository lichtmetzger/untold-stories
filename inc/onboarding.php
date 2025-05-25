<?php
if ( ! defined( 'UNTOLD_STORIES_WHITELABEL' ) || false === (bool) UNTOLD_STORIES_WHITELABEL ) {
	add_filter( 'ocdi/import_files', 'untoldstories_ocdi_import_files' );
	add_action( 'ocdi/after_import', 'untoldstories_ocdi_after_import_setup' );
	add_filter( 'ocdi/register_plugins', 'untoldstories_ocdi_register_plugins' );
}

function untoldstories_ocdi_import_files( $files ) {
	if ( ! defined( 'UNTOLD_STORIES_NAME' ) ) {
		define( 'UNTOLD_STORIES_NAME', 'untoldstories' );
	}

	$demo_dir_url = untrailingslashit( apply_filters( 'untoldstories_ocdi_demo_dir_url', 'https://www.cssigniter.com/sample_content/' . UNTOLD_STORIES_NAME ) );

	// When having more that one predefined imports, set a preview image, preview URL, and categories for isotope-style filtering.
	$new_files = array(
		array(
			'import_file_name'           => esc_html__( 'Demo Import', 'untold-stories' ),
			'import_file_url'            => $demo_dir_url . '/content.xml',
			'import_widget_file_url'     => $demo_dir_url . '/widgets.wie',
			'import_customizer_file_url' => $demo_dir_url . '/customizer.dat',
		),
	);

	return array_merge( $files, $new_files );
}

function untoldstories_ocdi_after_import_setup() {
	// Set up nav menus.
	$main_menu   = get_term_by( 'name', 'Main', 'nav_menu' );
	$footer_menu = get_term_by( 'name', 'Footer', 'nav_menu' );

	set_theme_mod( 'nav_menu_locations', array(
		'main_menu'   => $main_menu->term_id,
		'footer_menu' => $footer_menu->term_id,
	) );

	update_option( 'show_on_front', 'posts' );

	// WooCommerce
	if ( class_exists( 'WooCommerce' ) ) {
		$wc_pages = array(
			'shop'      => array(
				'page_id'      => wc_get_page_id( 'shop' ),
				'demo_page_id' => 455,
			),
			'cart'      => array(
				'page_id'      => wc_get_page_id( 'cart' ),
				'demo_page_id' => 456,
				'meta_values'  => array(
					'_wp_page_template' => 'template-fullwidth-wide.php',
				),
			),
			'checkout'  => array(
				'page_id'      => wc_get_page_id( 'checkout' ),
				'demo_page_id' => 457,
				'meta_values'  => array(
					'_wp_page_template' => 'template-fullwidth-wide.php',
				),
			),
			'myaccount' => array(
				'page_id'      => wc_get_page_id( 'myaccount' ),
				'demo_page_id' => 458,
				'meta_values'  => array(
					'_wp_page_template' => 'template-fullwidth-wide.php',
				),
			),
		);

		untoldstories_set_woocommerce_pages_custom_fields( $wc_pages );
		untoldstories_replace_woocommerce_nav_menu_items( $wc_pages );
		untoldstories_renew_woocommerce_transient_data();
	}

	$demo_url = untrailingslashit( 'https://www.cssigniter.com/vip/untoldstories/' );
	$this_url = untrailingslashit( get_home_url() );
	untoldstories_replace_custom_nav_menu_items( $demo_url, $this_url );

	// Try to force a term recount.
	// wp_defer_term_counting( false ) doesn't work properly as there are post imported from different AJAX requests.
	$taxonomies = get_taxonomies( array(), 'names' );
	foreach ( $taxonomies as $taxonomy ) {
		$terms             = get_terms( $taxonomy, array( 'hide_empty' => false ) );
		$term_taxonomy_ids = wp_list_pluck( $terms, 'term_taxonomy_id' );

		wp_update_term_count( $term_taxonomy_ids, $taxonomy );
	}

}

/**
 * Sets up the shop pages' custom fields.
 *
 * @since ThemeNewVersion
 *
 * @param array $wc_pages
 */
function untoldstories_set_woocommerce_pages_custom_fields( $wc_pages ) {
	// Setup shop page custom fields.
	foreach ( $wc_pages as $page ) {
		if ( $page['page_id'] ) {
			foreach ( $page['meta_values'] as $key => $value ) {
				update_post_meta( $page['page_id'], $key, $value );
			}
		}
	}
}

/**
 * Sets up the shop pages' in the menus.
 *
 * @since function untoldstories_
 *
 * @param array $wc_pages
 */
function untoldstories_replace_woocommerce_nav_menu_items( $wc_pages ) {
	$menus = wp_get_nav_menus(
		array(
			'hide_empty' => true,
		)
	);

	foreach ( $menus as $menu ) {
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( $menu_items as $menu_item ) {
			if ( 'post_type' === $menu_item->type ) {
				foreach ( $wc_pages as $wc_page ) {
					if ( ! empty( $wc_page['demo_page_id'] ) && (string) $menu_item->object_id === (string) $wc_page['demo_page_id'] ) {
						update_post_meta( $menu_item->ID, '_menu_item_object', 'page' );
						update_post_meta( $menu_item->ID, '_menu_item_object_id', (string) $wc_page['page_id'] );
					}
				}
			}
		}
	}
}

/**
 * Clears/refreshes WooCommerce's transient data.
 *
 * @since ThemeNewVersion
 */
function untoldstories_renew_woocommerce_transient_data() {
	if ( class_exists( 'WC_REST_System_Status_Tools_Controller' ) ) {
		$tools_controller = new WC_REST_System_Status_Tools_Controller();
		$tools_controller->execute_tool( 'clear_transients' );
		$tools_controller->execute_tool( 'clear_template_cache' );
		$tools_controller->execute_tool( 'recount_terms' );
		$tools_controller->execute_tool( 'regenerate_product_lookup_tables' );
	}
}

/**
 * Replaces database values of nav menu items with custom URLs.
 *
 * @since ThemeNewVersion
 *
 * @param string $find_url
 * @param string $replace_url
 */
function untoldstories_replace_custom_nav_menu_items( $find_url, $replace_url ) {
	$menus = wp_get_nav_menus( array(
		'hide_empty' => true,
	) );

	foreach ( $menus as $menu ) {
		$menu_items = wp_get_nav_menu_items( $menu );
		foreach ( $menu_items as $menu_item ) {
			if ( 'custom' === $menu_item->type ) {
				if ( substr( $menu_item->url, 0, strlen( $find_url ) ) === $find_url ) {
					$new_url = str_replace( $find_url, $replace_url, $menu_item->url );
					update_post_meta( $menu_item->ID, '_menu_item_url', $new_url );
				}
			}
		}
	}
}

/**
 * Registers plugins as required with One Click Demo Import.
 *
 * @since ThemeNewVersion
 * @param array $plugins Plugins registered with OCDI.
 */
function untoldstories_ocdi_register_plugins( $plugins ) {
	$theme_plugins = array(
		array(
			'name'     => 'WooCommerce',
			'slug'     => 'woocommerce',
			'required' => true,
		),
		array(
			'name'     => 'Contact Form 7',
			'slug'     => 'contact-form-7',
			'required' => true,
		),
	);

	return array_merge( $plugins, $theme_plugins );
}
