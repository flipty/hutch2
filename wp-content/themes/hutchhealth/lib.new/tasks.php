<?php
/**
 * tasks.php - Child theme task runner
 * Built just for Vivid Image Needs.
 *
 * @since 03/26/2014
 * @author Tyler Steinhaus
 */

if( FALSE === ( $tasks = get_option( 'vi-tasks' ) ) ) {
	$tasks = array();
}

// Create Sitemap page if it doesn't exist
if( $tasks['sitemap'] != TRUE ) {
	if( get_postid_by_slug( 'sitemap' ) === FALSE ) {
		wp_insert_post( array(
			'post_title'		=> 'Sitemap',
			'post_name'			=> 'sitemap',
			'post_type'			=> 'page',
			'post_status'		=> 'publish'
		) );
	}
	$tasks['sitemap'] = TRUE;
}


// Create Privacy Policy Page if it doesn't exist
if( $tasks['privacy-policy'] != TRUE ) {
	if( get_postid_by_slug( 'privacy-policy' ) === FALSE ) {
		wp_insert_post( array(
			'post_title'		=> 'Privacy Policy',
			'post_name'			=> 'privacy-policy',
			'post_type'			=> 'page',
			'post_status'		=> 'publish'
		) );
	}
	$tasks['privacy-policy'] = TRUE;
}

// Create Post With Everything In It
if( $tasks['pweii'] != TRUE ) {
	if( get_postid_by_slug( 'pweii' ) === FALSE ) {
		$pweii_text = fopen( get_stylesheet_directory().'/lib/extras/pweii.txt', 'rb' );
		$pweii_content = fread( $pweii_text, filesize( get_stylesheet_directory().'/lib/extras/pweii.txt' ) );
		$pweii_content = wp_kses( $pweii_content, wp_kses_allowed_html( 'post' ) );
		fclose( $pweii_text );

		$post_id = wp_insert_post( array(
			'post_title'		=> 'Post With Everything In It',
			'post_name'			=> 'pweii',
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'post_content'		=> $pweii_content
		) );
		
	}
	$tasks['pweii'] = TRUE;
}

// Update Wordpress Settings upon activation
if( $tasks['wordpress-setup'] != TRUE ) {
	update_option( 'blogdescription', '' ); // Blog Description/Tagline
	update_option( 'admin_email', 'wp@vimm.com' ); // Admin Email Address
	update_option( 'timezone_string', 'America/Chicago' ); // Timezone
	update_option( 'start_of_week', '0' ); // Which day the week starts on (Sunday)
	update_option( 'blog_public', '0' ); //Discourage search engines
	update_option( 'permalink_structure', '/%postname%/' ); // Permalink Structure
	flush_rewrite_rules(); // Rewrite Permalinks after updating the option

	$tasks['wordpress-setup'] = TRUE;
}

// Check to see if Gravity Forms exists, if does create a test form
if( $tasks['gravity-forms'] != TRUE ) {
	if( is_admin() && is_plugin_active( 'gravityforms/gravityforms.php' ) ) {
		$form_object = unserialize( 'a:20:{s:5:"title";s:9:"Test Form";s:11:"description";s:0:"";s:14:"labelPlacement";s:9:"top_label";s:20:"descriptionPlacement";s:5:"below";s:6:"button";a:3:{s:4:"type";s:4:"text";s:4:"text";s:6:"Submit";s:8:"imageUrl";s:0:"";}s:6:"fields";a:2:{i:0;a:11:{s:2:"id";i:1;s:5:"label";s:8:"Untitled";s:10:"adminLabel";s:0:"";s:4:"type";s:4:"text";s:10:"isRequired";b:0;s:4:"size";s:6:"medium";s:12:"errorMessage";s:0:"";s:6:"inputs";N;s:6:"formId";i:1;s:10:"pageNumber";i:1;s:20:"descriptionPlacement";s:5:"below";}i:1;a:22:{s:2:"id";i:2;s:5:"label";s:8:"Untitled";s:10:"adminLabel";s:0:"";s:4:"type";s:6:"select";s:10:"isRequired";b:0;s:4:"size";s:6:"medium";s:12:"errorMessage";s:0:"";s:6:"inputs";N;s:7:"choices";a:3:{i:0;a:4:{s:4:"text";s:12:"First Choice";s:5:"value";s:12:"First Choice";s:10:"isSelected";b:0;s:5:"price";s:0:"";}i:1;a:4:{s:4:"text";s:13:"Second Choice";s:5:"value";s:13:"Second Choice";s:10:"isSelected";b:0;s:5:"price";s:0:"";}i:2;a:4:{s:4:"text";s:12:"Third Choice";s:5:"value";s:12:"Third Choice";s:10:"isSelected";b:0;s:5:"price";s:0:"";}}s:13:"multipleFiles";b:0;s:8:"maxFiles";s:0:"";s:18:"calculationFormula";s:0:"";s:19:"calculationRounding";s:0:"";s:17:"enableCalculation";s:0:"";s:15:"disableQuantity";b:0;s:20:"displayAllCategories";b:0;s:9:"inputMask";b:0;s:14:"inputMaskValue";s:0:"";s:17:"allowsPrepopulate";b:0;s:6:"formId";i:1;s:10:"pageNumber";i:1;s:20:"descriptionPlacement";s:5:"below";}}s:2:"id";i:1;s:22:"useCurrentUserAsAuthor";b:1;s:26:"postContentTemplateEnabled";b:0;s:24:"postTitleTemplateEnabled";b:0;s:17:"postTitleTemplate";s:0:"";s:19:"postContentTemplate";s:0:"";s:14:"lastPageButton";N;s:10:"pagination";N;s:17:"firstPageCssClass";N;s:13:"notifications";a:1:{s:13:"547ce01096c82";a:7:{s:2:"id";s:13:"547ce01096c82";s:2:"to";s:13:"{admin_email}";s:4:"name";s:18:"Admin Notification";s:5:"event";s:15:"form_submission";s:6:"toType";s:5:"email";s:7:"subject";s:32:"New submission from {form_title}";s:7:"message";s:12:"{all_fields}";}}s:13:"confirmations";a:1:{s:13:"547ce0109cfb9";a:8:{s:2:"id";s:13:"547ce0109cfb9";s:4:"name";s:20:"Default Confirmation";s:9:"isDefault";b:1;s:4:"type";s:7:"message";s:7:"message";s:64:"Thanks for contacting us! We will get in touch with you shortly.";s:3:"url";s:0:"";s:6:"pageId";s:0:"";s:11:"queryString";s:0:"";}}s:9:"is_active";s:1:"1";s:12:"date_created";s:19:"2014-12-01 21:39:28";s:8:"is_trash";s:1:"0";}' );
		GFAPI::add_form( (array) $form_object );

		$tasks['gravity-forms'] = TRUE;
	}
}

update_option( 'vi-tasks', $tasks ); 