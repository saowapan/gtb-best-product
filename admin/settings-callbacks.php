<?php // gtb_bp - Settings Callbacks



// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}



// callback: login section
function gtb_bp_callback() {
	
	echo '<p>These settings enable you to customize the WP Login screen.</p>';
	
}


// callback: text field
function gtb_bp_callback_field_text( $args ) {
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$value = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	echo '<input id="gtb_bp_options_'. $id .'" name="gtb_bp_options['. $id .']" type="text" size="40" value="'. $value .'"><br />';
	echo '<label for="gtb_bp_options_'. $id .'">'. $label .'</label>';
	
}



// radio field options
function gtb_bp_options_radio() {
	
	return array(
		
		'enable'  => 'Enable custom styles',
		'disable' => 'Disable custom styles'
		
	);
	
}


// callback: radio field
function gtb_bp_callback_field_radio( $args ) {
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	$radio_options = gtb_bp_options_radio();
	
	foreach ( $radio_options as $value => $label ) {
		
		$checked = checked( $selected_option === $value, true, false );
		
		echo '<label><input name="gtb_bp_options['. $id .']" type="radio" value="'. $value .'"'. $checked .'> ';
		echo '<span>'. $label .'</span></label><br />';
		
	}
	
}



// callback: textarea field
function gtb_bp_callback_field_textarea( $args ) {
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$allowed_tags = wp_kses_allowed_html( 'post' );
	
	$value = isset( $options[$id] ) ? wp_kses( stripslashes_deep( $options[$id] ), $allowed_tags ) : '';
	
	echo '<textarea id="gtb_bp_options_'. $id .'" name="gtb_bp_options['. $id .']" rows="5" cols="50">'. $value .'</textarea><br />';
	echo '<label for="gtb_bp_options_'. $id .'">'. $label .'</label>';
	
}



// callback: checkbox field
function gtb_bp_callback_field_checkbox( $args ) {
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$checked = isset( $options[$id] ) ? checked( $options[$id], 1, false ) : '';
	
	echo '<input id="gtb_bp_options_'. $id .'" name="gtb_bp_options['. $id .']" type="checkbox" value="1"'. $checked .'> ';
	echo '<label for="gtb_bp_options_'. $id .'">'. $label .'</label>';
	
}



// callback: select field
function gtb_bp_callback_field_select( $args ) {
	
	$options = get_option( 'gtb_bp_options', gtb_bp_options_default() );
	
	$id    = isset( $args['id'] )    ? $args['id']    : '';
	$label = isset( $args['label'] ) ? $args['label'] : '';
	
	$selected_option = isset( $options[$id] ) ? sanitize_text_field( $options[$id] ) : '';
	
	
	echo '<select id="gtb_bp_options_'. $id .'" name="gtb_bp_options['. $id .']">';
	

	
	echo '</select> <label for="gtb_bp_options_'. $id .'">'. $label .'</label>';
	
}


