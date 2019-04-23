<?php // gtb_bp - Core Functionality



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}







// custom login styles
function gtb_bp_custom_styles() {
	
	$styles = false;
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	if ( isset( $options['custom_style'] ) && ! empty( $options['custom_style'] ) ) {
		
		$styles = sanitize_text_field( $options['custom_style'] );
		
	}
	
	if ( 'enable' === $styles ) {
		
		/*
		
		wp_enqueue_style( 
			string           $handle, 
			string           $src = '', 
			array            $deps = array(), 
			string|bool|null $ver = false, 
			string           $media = 'all' 
		)
		
		wp_enqueue_script( 
			string           $handle, 
			string           $src = '', 
			array            $deps = array(), 
			string|bool|null $ver = false, 
			bool             $in_footer = false 
		)
		
		*/
		
		wp_enqueue_style( 'gtb_bp', plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/gtb-best-product.css', array(), null, 'screen' );
		
		wp_enqueue_script( 'gtb_bp', plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/gtb-best-product.js', array(), null, true );
		
	}
	
}
add_action( 'wp_enqueue_scripts', 'gtb_bp_custom_styles' );



// custom login message
function gtb_bp_custom_login_message( $message ) {
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	if ( isset( $options['custom_message'] ) && ! empty( $options['custom_message'] ) ) {
		
		$message = wp_kses_post( $options['custom_message'] ) . $message;
		
	}
	
	return $message;
	
}
add_filter( 'login_message', 'gtb_bp_custom_login_message' );

