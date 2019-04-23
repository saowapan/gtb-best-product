<?php
/*
Plugin Name: GTB Best Product
Description: Display Best Product on every Post and Page
Plugin URI:  https://codeacademy.asia/gtb-best-product
Author:      May Kongpia
Author URI:  http://codeacademy.asia/
Version:     1.0
License:     GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.txt
*/


// exit if file is called directly
if( !defined( 'ABSPATH')) {
    exit;
}


// include plugin dependencies: admin only
if ( is_admin() ) {
	
	require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callbacks.php';
	require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';
	
}



// include plugin dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/meta-box.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/gtb-bp-shortcode.php';


// default plugin options
function gtb_bp_options_default() {

	return array(
        'custom_style'   => 'enable',
        'custom_css' => '<p class="custom-css">Add custom CSS</p>'
	);

}