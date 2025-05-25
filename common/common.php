<?php
/**
 * Common theme features.
 */

/**
 * Common assets registration
 */
function untoldstories_register_common_assets() {
	$theme = wp_get_theme();
	wp_register_style( 'untoldstories-common', get_template_directory_uri() . '/common/css/global.css', array(), $theme->get( 'Version' ) );
}
add_action( 'init', 'untoldstories_register_common_assets', 8 );
