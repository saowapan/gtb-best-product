<?php

// display best product section on page and post if it is exist
add_action('plugins_loaded','gtb_load');

function gtb_load() {
    shortcode_enable();
}

function shortcode_enable(){
    if(!function_exists('add_shortcode')) {
                   return;
    }
    add_shortcode('best_product' , 'display_best_product');
}

function display_best_product($atts) {
    $id = $atts['id'];
    $bp_header  =  get_post_meta( get_the_ID(), '_gtb_bp_product_header_' . $id, true);
    $bp_title = get_post_meta( get_the_ID(), '_gtb_bp_product_title_'. $id , true );
	$bp_url = get_post_meta( get_the_ID(), '_gtb_bp_product_url_' . $id, true );
	$bp_amz_url = get_post_meta( get_the_ID(), '_gtb_bp_amz_url_' . $id, true );
    $bp_ebay_url = get_post_meta( get_the_ID(), '_gtb_bp_ebay_url_' . $id , true );
    $meta_bp = 'bp_featured_img_' . $id; 
    $img_value = get_post_meta(get_the_ID(), $meta_bp, true);
    $image_attributes = wp_get_attachment_image_src( $img_value, 'full' );
    $bp_content = get_post_meta(get_the_ID(), '_pb_post_note_' .$id , true); 
    
    if($bp_title) {
        $html = '<div class="best-product-container"><header><h4>'. $bp_header .'</h4></header>';
        $html .=  '<div class="bp-content">';

        if(ISSET($image_attributes[0])) {
            $html .=    '<div class="bp-image">';
            $html .=        '<img src="' . $image_attributes[0] . '"  alt="' .$bp_title . '" /></li>';   
            $html .=    '</div>';
        }
        
        $html .=    '<div class="bp-title"><h5>';
        if(($bp_url))
            $html .=        '<a href="'. $bp_url . '">' . $bp_title . "</a>" ;
        else 
            $html .=         $bp_title ;
        $html .=    '</h5></div>';
        
        if($bp_content) {
            $html .= '<div class="bp-description">';
            $html .=    $bp_content;
            $html .= '</div>';
        }
        
        $html .=    '</h5></div>';

        if($bp_amz_url || $bp_ebay_url) {
            $html .=  '<div class="pb-button">';
            if($bp_amz_url) {
                $html .=    '<div class="amazon">';
                $html .=        '<a href="'.$bp_ebay_url .'">';
                $html .=            '<input type="button" class="button ebay-button affiliate-button" value="Buy on Ebay">';
                $html .=        '</a>';
                $html .=    '</div>';
            }
            if($bp_ebay_url) {
                $html .=    '<div class="ebay">';
                $html .=        '<a href="'.$bp_amz_url .'">';
                $html .=            '<input type="button" class="button amazon-button affiliate-button" value="Buy on Amazon">';
                $html .=        '</a>';
                $html .=    '</div>';
            }
            $html .= '</div>';
        }
        $html .= '</div>';
    }
    return $html;
}