<?php
// add top-level administrative menu

// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}

function gtb_bp_add_toplevel_menu() {
	
	/* 
		add_menu_page(
			string   $page_title, 
			string   $menu_title, 
			string   $capability, 
			string   $menu_slug, 
			callable $function = '', 
			string   $icon_url = '', 
			int      $position = null 
		)
	*/
	
	add_menu_page(
		'GTB Best Product Settings',
		'GTB Best Product',
		'manage_options',
		'gtb_best_product',
		'gtb_bp_display_settings_page', // callable
		'dashicons-admin-generic', // icon url
		null
	);
	
}
add_action( 'admin_menu', 'gtb_bp_add_toplevel_menu' );