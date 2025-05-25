<?php

// Remove Site Health Dashboard Widget
add_action('wp_dashboard_setup', 'remove_site_health_widget' );

function remove_site_health_widget() {
    remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
}

// Remove Site Health Sub Menu Item
add_action( 'admin_menu', 'remove_site_health_menu' );

function remove_site_health_menu(){
    remove_submenu_page( 'tools.php','site-health.php' );
}

// Re-enable infinite scrolling in media library
add_filter( 'media_library_infinite_scrolling', '__return_true' );

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );