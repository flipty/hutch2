<?php
function mpfy_batch_add_admin_page() {
	add_submenu_page('mapify.php', 'Batch Upload', 'Batch Upload', 'manage_options', 'mpfy-import', 'mpfy_batch_upload_admin_page');
}
add_action('admin_menu', 'mpfy_batch_add_admin_page');

function mpfy_batch_upload_admin_page() {
	include_once('admin/batch-upload.php');
}

function mpfy_batch_bool_value($value) {
	$true_values = array(1, '1', 'true', 'y', 'yes');
	$value = trim(strtolower($value));
	return (bool) (in_array($value, $true_values));
}

function mpfy_batch_trigger_hook() {
	global $wpdb;

	/*
	0 Title
	1 Description
	2 Map Tag
	3 Enable Pop-up? Y/N
	4 Link location to another page? Y/N
	5 Enter URL
	6 Enable Tooltip? Y/N
	7 Close Tooltip Automatically/Manually
	8 Include Location Information? Y/N
	9 Include Directions? Y/N
	10 Tooltip Content
	11 Include on Selected Map(s) Location  List? Y/N
	12 Short Description (appears in Interactive List)
	13 Pin Image URL (Leave blank to use Map’s Default pin image)
	14 Video Embed code
	15 Gallery Images: Enter the url of the images you’d like to include in the gallery, separated by a comma.
	16 Location Address or GPS Coordinates
	17 Phone Number
	18 Street Address
	19 State
	20 City
	21 Zip
	22 Country
	23 Enable Sharing? Y/N
	*/

	$dictionary = array(
		0=>'title',
		1=>'description',
		2=>'map_tags',
		3=>'enable_popup',
		4=>'link_to_page',
		5=>'link_to_page_url',
		6=>'enable_tooltip',
		7=>'close_tooltip_method',
		8=>'include_location_info',
		9=>'include_directions',
		10=>'tooltip_content',
		11=>'include_in_location_list',
		12=>'short_description',
		13=>'pin_image_url',
		14=>'video_embed_code',
		15=>'gallery_images',
		16=>'location_address_or_geo',
		17=>'phone',
		18=>'address',
		19=>'state',
		20=>'city',
		21=>'zip',
		22=>'country',
		23=>'enable_sharing',
	);

	$raw = array_map('trim', $_POST['row']);
	$r = array();
	foreach ($raw as $i => $value) {
		$r[$dictionary[$i]] = trim($value);
	}
	$action = 'add';

	$already_existing = get_page_by_title($r['title'], OBJECT, 'map-location');
	if ($already_existing) {
		$action = 'update';
		$new_post_id = $already_existing->ID;
		$location = new Mpfy_Map_Location($new_post_id);
		$maps = $location->get_maps();
		$maps[] = intval($_POST['map_id']);
		$maps = array_filter(array_unique($maps));
		update_post_meta($new_post_id, '_map_location_map', implode(',', $maps));
	} else {
		$new_post = array(
			'post_type'=>'map-location',
			'post_status'=>'publish',
			'post_title'=>$r['title'],
			'post_content'=>$r['description'],
		);
		$new_post_id = wp_insert_post($new_post);
		update_post_meta($new_post_id, '_map_location_map', intval($_POST['map_id']));
	}
	mpfy_duplicate_location_map_meta($new_post_id);

	$tooltip_close_method = trim(strtolower($r['close_tooltip_method']));
	$tooltip_close_method = (in_array($tooltip_close_method, array('auto', 'automatically'))) ? 'auto' : 'manual';
	update_post_meta($new_post_id, '_map_location_tooltip_enabled', mpfy_batch_bool_value($r['enable_popup']) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_tooltip_show', mpfy_batch_bool_value($r['enable_tooltip']) ? 'yes' : 'no');
	update_post_meta($new_post_id, '_map_location_tooltip_close', $tooltip_close_method);
	update_post_meta($new_post_id, '_map_location_popup_location_information', mpfy_batch_bool_value($r['include_location_info']) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_popup_directions', mpfy_batch_bool_value($r['include_directions']) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_tooltip', $r['tooltip_content']);
	update_post_meta($new_post_id, '_map_location_mll_include', mpfy_batch_bool_value($r['include_in_location_list']) ? 'y' : 'n' );
	update_post_meta($new_post_id, '_map_location_mll_description', $r['short_description']);
	update_post_meta($new_post_id, '_map_location_video_embed', $r['video_embed_code']);
	update_post_meta($new_post_id, '_map_location_phone', $r['phone']);
	update_post_meta($new_post_id, '_map_location_address', $r['address']);
	update_post_meta($new_post_id, '_map_location_state', $r['state']);
	update_post_meta($new_post_id, '_map_location_city', $r['city']);
	update_post_meta($new_post_id, '_map_location_zip', $r['zip']);
	update_post_meta($new_post_id, '_map_location_country', $r['country']);
	
	update_post_meta($new_post_id, '_map_location_external_url_enable', mpfy_batch_bool_value($r['link_to_page']) ? 'yes' : 'no' );
	update_post_meta($new_post_id, '_map_location_external_url_url', $r['link_to_page_url']);

	if (!empty($r['pin_image_url'])) {
		update_post_meta($new_post_id, '_map_location_pin', $r['pin_image_url']);
	}
	
	if (!empty($r['gallery_images'])) {
		$wpdb->query($wpdb->prepare('
			DELETE
			FROM ' . $wpdb->postmeta . '
			WHERE `post_id` = %d
			AND `meta_key` LIKE "_map_location_gallery_images_-_image_%%"
		', intval($new_post_id)));

		$images = array_map('trim', explode(',', $r['gallery_images']));
		foreach ($images as $i => $img) {
			add_post_meta($new_post_id, '_map_location_gallery_images_-_image_' . $i, $img);
		}
	}

	if (mpfy_batch_bool_value($r['enable_sharing'])) {
		update_post_meta($new_post_id, '_map_location_share', array('facebook','pinterest','twitter','googleplus','email'));
	}

	if (!empty($r['map_tags'])) {
		$map_tags = array_map('trim', explode(',', $r['map_tags']));
		$valid_terms = array();
		foreach ($map_tags as $term_name) {
			$term = get_term_by('name', $term_name, 'location-tag');
			if ($term) {
				$valid_terms[] = $term->term_id;
			}
		}
		if (!empty($valid_terms)) {
			wp_set_object_terms($new_post_id, $valid_terms, 'location-tag');
		}
	}

	$full_address = $r['location_address_or_geo'];
	if (empty($full_address)) {
		$full_address = implode(', ', array_filter(array($r['address'], $r['city'], $r['state'], $r['zip'], $r['country'])));
	}

	$url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($full_address) . '&sensor=false';
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($curl, CURLOPT_HEADER, 0);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	$data = json_decode($response);
	$found_address = false;

	if (isset($data->results) && isset($data->results[0])) {
		$found_address = true;
		$latlng = $data->results[0]->geometry->location->lat . ',' . $data->results[0]->geometry->location->lng;
		update_post_meta($new_post_id, '_map_location_google_location', $latlng);
		update_post_meta($new_post_id, '_map_location_google_location-lat', $data->results[0]->geometry->location->lat);
		update_post_meta($new_post_id, '_map_location_google_location-lng', $data->results[0]->geometry->location->lng);
		update_post_meta($new_post_id, '_map_location_google_location-address', $full_address);
	}

	if ($found_address) {
		echo ($action == 'add' ? 'Added' : 'Updated') . ' <em>' . $r['title'] . ' (' . $r['address'] . ')</em>';
	} else {
		echo ($action == 'add' ? 'Added' : 'Updated') . ' <em>' . $r['title'] . ' (' . $r['address'] . ')</em>. <span style="color: red;">Google Maps failed to retrieve exact location (manual entry is required).</span>';
	}
	exit;
}
add_action('wp_ajax_mpfy_batch_upload', 'mpfy_batch_trigger_hook', 1000);
