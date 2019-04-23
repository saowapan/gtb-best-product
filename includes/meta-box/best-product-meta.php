<?php
// register meta box

// disable direct file access
if ( ! defined( 'ABSPATH' ) ) {
	
	exit;
	
}
function gtb_bp_add_meta_box() {
	$post_types = array( 'post', 'page' );

	foreach ( $post_types as $post_type ) {
		for($i=1; $i<6; $i++) {
			add_meta_box(
				'gtb_bp_meta_box_' . $i,         // Unique ID of meta box
				'Garden Tool Box Product '. $i,         // Title of meta boxar
				'gtb_bp_display_meta_box', // Callback function
				$post_type,                   // Post type
				'normal', // $context  
				'high' // $priority  
				,array('$i', $i ) // callback arguments 
			);
		}

	}

}
add_action( 'add_meta_boxes', 'gtb_bp_add_meta_box' );

// image uploader
function gtb_bp_image_uploader_field( $name, $value = '' ) {
    $image = ' button">Upload image';
	$image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
	$display = 'none'; // display state ot the "Remove image" button
 
	if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
 
		// $image_attributes[0] - image URL
		// $image_attributes[1] - image width
		// $image_attributes[2] - image height
 
		$image = '"><img class="selected_image" src="' . $image_attributes[0] . '" style="" />';
		$display = 'inline-block';
 
	} 
 
	return '
	<div>
		<label>Product Image: </lable>
		<a href="#" class="gtb_bp_upload_image_button' . $image . '</a>
		<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . $value . '" />
		<a href="#" class="gtb_bp_remove_image_button" style="display:inline-block;display:' . $display . '">Remove image</a>
	</div>';
}

// add admin javascript to image uploader
function gtb_bp_admin_scripts() {
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
	wp_enqueue_style( 'gtb_bp', plugin_dir_url( dirname( __FILE__ ) ) . '../admin/'. 'css/meta-box.css', array(), null, 'screen' );
    wp_enqueue_script( 'gtb_bp-gallery-js', plugin_dir_url( dirname( __FILE__ ) ) . '../admin/'.  'js/meta-box.js', array('jquery'), null, true );
}

add_action( 'admin_enqueue_scripts','gtb_bp_admin_scripts' );

// display meta box
function gtb_bp_display_meta_box( $post, $callback_args ) {
	//for($i=1; $i<6; $i++) {
		$meta_box_index = $callback_args["args"][1];
		$bp_header  =  get_post_meta( $post->ID, '_gtb_bp_product_header_' . $meta_box_index , true);
		$bp_title = get_post_meta( $post->ID, '_gtb_bp_product_title_' . $meta_box_index, true );
		$bp_url = get_post_meta( $post->ID, '_gtb_bp_product_url_' . $meta_box_index, true );
		$bp_amz_url = get_post_meta( $post->ID, '_gtb_bp_amz_url_' . $meta_box_index, true );
		$bp_ebay_url = get_post_meta( $post->ID, '_gtb_bp_ebay_url_' . $meta_box_index, true );
		wp_nonce_field( basename( __FILE__ ), 'gtb_bp_meta_box_nonce' );
		wp_nonce_field( 'save_feat_gallery', 'gtb_bp_feat_gallery_nonce' );
		
		$meta_key = 'bp_featured_img_' . $meta_box_index;
		?>
		<div class="gtb_bp_box">
		<style scoped>
			.gtb_bp_box{
				display: grid;
				grid-row-gap: 10px;
				grid-column-gap: 20px;
			}
			.hcf_field{
				display: contents;
			}
		</style>
			<p>
				<label for="gtb-bp-header-title-<?=$meta_box_index?>">Header Title: </label>
				<input type="text" name="gtb-bp-header-title-<?=$meta_box_index?>" placeholder="Best Product" value="<?=$bp_header?>">
			</p>

			<p>
				<label for="gtb-bp-product-title">Product Title: </label>
				<input type="text" name="gtb-bp-product-title-<?=$meta_box_index?>" value="<?=$bp_title?>">
			</p>

			<p>
				<label for="gtb-bp-product-url">Product URL: </label>
				<input type="url" placeholder="https://example.com" pattern="https://.*" size="30" name="gtb-bp-product-url-<?=$meta_box_index?>" value="<?=$bp_url?>">
			</p>

			<div>
				<?=gtb_bp_image_uploader_field( $meta_key, get_post_meta($post->ID, $meta_key, true) ); ?>
			</div>

			<div>
				<label for="gtb-bp-product-description">Product Description: </label>
				<?php
					// Get saved meta data
					$post_note_meta_content = get_post_meta($post->ID, '_pb_post_note_' . $meta_box_index, TRUE); 
					if (!$post_note_meta_content) $post_note_meta_content = '';
					wp_nonce_field( 'post_note_' . $meta_box_index . '_' .$post->ID, 'post_note_nonce_' . $meta_box_index);
					// Render editor meta box
					wp_editor( $post_note_meta_content, 'post_note_' . $meta_box_index, array('textarea_rows' => '8'));
				?>
			</div>

			<p>
				<label for="gtb-bp-amz-url">Amazon URL: </label>
				<input type="url" placeholder="https://example.com" pattern="https://.*" size="30" name="gtb-bp-amz-url-<?=$meta_box_index?>" class="url_validate" value="<?=$bp_amz_url?>">
			</p>

			<p>
				<label for="gtb-bp-ebay-url">Ebay URL: </label>
				<input type="url" placeholder="https://example.com" pattern="https://.*" size="30" name="gtb-bp-ebay-url-<?=$meta_box_index?>" class="url_validate" value="<?=$bp_ebay_url?>">
			</p>

			<p>
				<label for="gtb-bp-shortcode">Please copy and paste this shortcode into your content: </label>
				<input type="text" disabled value='[best_product id="<?=$meta_box_index?>"]' style="color: black;"/>
			</p>

		</div>

<?php
//	}
}



// save meta box
function gtb_bp_save_meta_box( $post_id ) {

	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = false;

	if ( isset( $_POST[ 'gtb_bp_meta_box_nonce' ] ) ) {

		if ( wp_verify_nonce( $_POST[ 'gtb_bp_meta_box_nonce' ], basename( __FILE__ ) ) ) {

			$is_valid_nonce = true;

		}

	}

	if ( $is_autosave || $is_revision || !$is_valid_nonce ) return;
	
	for($i=1; $i<6; $i++) {

		if ( array_key_exists( 'gtb-bp-header-title-' . $i, $_POST ) ) {
			update_post_meta(
				$post_id,                                            // Post ID
				'_gtb_bp_product_header_' . $i,                                // Meta key
				sanitize_text_field( $_POST[ 'gtb-bp-header-title-'  . $i ] ) // Meta value
			);
		}

		if ( array_key_exists( 'gtb-bp-product-title-' . $i, $_POST ) ) {
			update_post_meta(
				$post_id,                                            // Post ID
				'_gtb_bp_product_title_' . $i,                                // Meta key
				sanitize_text_field( $_POST[ 'gtb-bp-product-title-' . $i ] ) // Meta value
			);
		}

		if ( array_key_exists( 'gtb-bp-product-url-' . $i, $_POST ) ) {
			update_post_meta(
				$post_id,                                            // Post ID
				'_gtb_bp_product_url_' . $i,                                // Meta key
				sanitize_text_field( $_POST[ 'gtb-bp-product-url-' . $i ] ) // Meta value
			);
		}


		$img_meta_key = 'bp_featured_img_' . $i;
		
		if ( isset( $_POST[ 'bp_featured_img_' . $i ] ) ) {
			update_post_meta( $post_id, $img_meta_key, esc_attr($_POST[$img_meta_key]) );
		} else {
			update_post_meta( $post_id, $img_meta_key, '' );
		}
		
		// if you would like to attach the uploaded image to this post, uncomment the line:
		// wp_update_post( array( 'ID' => $_POST[$meta_key], 'post_parent' => $post_id ) );

		// save product description

		// Bail if we're doing an auto save
		if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		
		// if our nonce isn't there, or we can't verify it, bail
		if( !isset( $_POST['post_note_nonce_' . $i] ) || !wp_verify_nonce( $_POST['post_note_nonce_' . $i], 'post_note_' . $i . '_'.$post_id ) ) return;
		
		// if our current user can't edit this post, bail
		if( !current_user_can( 'edit_post' ) ) return;
		
		
		// Make sure our data is set before trying to save it
		if( isset( $_POST['post_note_' . $i ] ) ) {
			update_post_meta( $post_id, '_pb_post_note_' . $i, $_POST['post_note_' . $i ] );
		}

		// Save amazon url
		if ( array_key_exists( 'gtb-bp-amz-url-' . $i, $_POST ) ) {
			update_post_meta(
				$post_id,                                            // Post ID
				'_gtb_bp_amz_url_' . $i,                                // Meta key
				sanitize_text_field( $_POST[ 'gtb-bp-amz-url-' . $i ] ) // Meta value
			);
		}

		// Save amazon url
		if ( array_key_exists( 'gtb-bp-ebay-url-' . $i, $_POST ) ) {
			update_post_meta(
				$post_id,                                            // Post ID
				'_gtb_bp_ebay_url_' . $i,                                // Meta key
				sanitize_text_field( $_POST[ 'gtb-bp-ebay-url-' . $i ] ) // Meta value
			);
		}
	}
}
add_action( 'save_post', 'gtb_bp_save_meta_box' );