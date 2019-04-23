<?php // gtb_bp - Register Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// register plugin settings
function gtb_bp_register_settings() {
	
	/*
	
	register_setting( 
		string   $option_group, 
		string   $option_name, 
		callable $sanitize_callback = ''
	);
	
	*/
	
	register_setting( 
		'gtb_bp_options', 
		'gtb_bp_options', 
		'gtb_bp_callback_validate_options' 
	); 
	
	/*
	
	add_settings_section( 
		string   $id, 
		string   $title, 
		callable $callback, 
		string   $page
	);
	
	*/
	
	add_settings_section( 
		'gtb_bp_section_login', 
		'Customize Best Product Section', 
		'gtb_bp_callback', 
		'gtb_bp'
	);
	
	
	/*
	
	add_settings_field(
    	string   $id, 
		string   $title, 
		callable $callback, 
		string   $page, 
		string   $section = 'default', 
		array    $args = []
	);
	
	*/
	
	add_settings_field(
		'custom_style',
		'Custom Style',
		'gtb_bp_callback_field_radio',
		'gtb_bp', 
		'gtb_bp_section_login', 
		[ 'id' => 'custom_style', 'label' => 'Custom CSS for the Login screen' ]
	);
	
	add_settings_field(
		'custom_message',
		'Custom Message',
		'gtb_bp_callback_field_textarea',
		'gtb_bp', 
		'gtb_bp_section_login', 
		[ 'id' => 'custom_message', 'label' => 'Custom text and/or markup' ]
	);
    
} 
add_action( 'admin_init', 'gtb_bp_register_settings' );


