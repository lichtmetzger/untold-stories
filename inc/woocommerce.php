<?php
//
// WooCommerce integration
//
add_action( 'after_setup_theme', 'untoldstories_woocommerce_activation' );
function untoldstories_woocommerce_activation() {
	add_theme_support( 'woocommerce', array(
		'thumbnail_image_width'         => 750,
		'single_image_width'            => 750,
		'gallery_thumbnail_image_width' => 200,
	) );

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'wc-product-gallery-lightbox' );
}

add_action( 'init', 'untoldstories_woocommerce_integration' );
function untoldstories_woocommerce_integration() {
	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

	// Change posts_per_page on related products
	add_filter( 'woocommerce_output_related_products_args', 'untoldstories_output_related_products_args' );

	// Change posts_per_page on upsells and cross sells
	add_filter( 'woocommerce_upsells_total', 'untoldstories_woocommerce_upsells_crosssells_total' );
	add_filter( 'woocommerce_cross_sells_total', 'untoldstories_woocommerce_upsells_crosssells_total' );
}

if ( ! function_exists( 'untoldstories_woocommerce_upsells_crosssells_total' ) ) :
	function untoldstories_woocommerce_upsells_crosssells_total( $limit ) {
		$limit = 4;

		return $limit;
	}
endif;

if ( ! function_exists( 'untoldstories_output_related_products_args' ) ) :
	function untoldstories_output_related_products_args( $args ) {
		$args['posts_per_page'] = 4;

		return $args;
	}
endif;

add_filter( 'loop_shop_per_page', 'untoldstories_loop_shop_per_page', 20 );
function untoldstories_loop_shop_per_page( $products ) {
	$products = get_theme_mod( 'theme_products_number', 10 );
	return $products;
}

add_filter( 'loop_shop_columns', 'untoldstories_loop_columns', 20 );
if ( ! function_exists( 'untoldstories_loop_columns' ) ) {
	function untoldstories_loop_columns() {
		return 4;
	}
}


if ( ! function_exists( 'untoldstories_is_wc_page' ) ) :
	function untoldstories_is_wc_page() {
		$wc_page = false;
		if ( class_exists( 'WooCommerce' ) ) {
			if ( is_cart() || is_checkout() || is_account_page() ) {
				$wc_page = true;
			}
		}

		return $wc_page;
	}
endif;
