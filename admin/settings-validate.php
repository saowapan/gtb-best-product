<?php // gtb_bp - Validate Settings



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// callback: validate options
function gtb_bp_callback_validate_options( $input ) {
	
	
	// custom style
	$radio_options = gtb_bp_options_radio();
	
	if ( ! isset( $input['custom_style'] ) ) {
		
		$input['custom_style'] = null;
		
	}
	if ( ! array_key_exists( $input['custom_style'], $radio_options ) ) {
		
		$input['custom_style'] = null;
		
	}
	
	// custom message
	if ( isset( $input['custom_css'] ) ) {
		
		$input['custom_css'] = wp_kses_post( $input['custom_css'] );
		
	}
	
	return $input;
	
}


