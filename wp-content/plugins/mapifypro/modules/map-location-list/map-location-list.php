<?php
// Add relevant admin fields
function mpfy_mll_map_location_custom_fields($custom_fields) {

	$custom_fields = mpfy_array_push_key($custom_fields, 'map_location_tooltip', array(
		'map_location_mll_include'=>Carbon_Field::factory('select', 'map_location_mll_include', 'Include on Selected Map(s) Location List?')
			->add_options(array('y'=>'Yes', 'n'=>'No')),
		'map_location_mll_description'=>Carbon_Field::factory('textarea', 'map_location_mll_description', 'Short Description')
			->help_text('Short description of the location that appears in the Interactive List. Note that this is independent of the tooltip and main description area that appears in the pop-up.'),
	));

	return $custom_fields;
}
add_filter('mpfy_map_location_custom_fields', 'mpfy_mll_map_location_custom_fields');

function mpfy_mll_map_custom_fields($custom_fields) {

	$custom_fields = mpfy_array_push_key($custom_fields, 'map_enable_filters_list', array(
		'map_mll_include'=>Carbon_Field::factory('select', 'map_mll_include', 'Enable Interactive List of Locations')
			->add_options(array('n'=>'No', 'y'=>'Yes'))
			->help_text('Adds locations below the map in an organized, interactive list.'),
		'map_mll_number_of_locations'=>Carbon_Field::factory('text', 'map_mll_number_of_locations', 'Number of Locations in List')
			->set_default_value(3)
			->help_text('Specify how many locations appear in list before pagination.'),
	));

	return $custom_fields;
}
add_filter('mpfy_map_custom_fields', 'mpfy_mll_map_custom_fields');

// Enqueue front-end assets
function mpfy_mll_enqueue_assets() {
	if (!defined('MPFY_LOAD_ASSETS')) {
		return;
	}

	// Load popup styles
	wp_enqueue_style('mpfy-map-location-list', plugins_url('modules/map-location-list/style.css', MAPIFY_PLUGIN_FILE), array(), '1.0.0');

	// Load popup behaviors
	wp_enqueue_script('mpfy-map-location-list', plugins_url('modules/map-location-list/functions.js', MAPIFY_PLUGIN_FILE), array('jquery'), '1.0.0', true);
}
add_action('wp_footer', 'mpfy_mll_enqueue_assets');

function mpfy_mll_template_after_map($map_id) {
	$enabled = mpfy_meta_to_bool($map_id, '_map_mll_include', false);
	if (!$enabled) {
		return;
	}

	$map = new Mpfy_Map($map_id);
	$locations = $map->get_locations();
	$number_of_locations = get_post_meta($map_id, '_map_mll_number_of_locations', true);
	$number_of_locations = max(0, abs(intval($number_of_locations)));
	$number_of_locations = $number_of_locations == 0 ? 3 : $number_of_locations;

	include('templates/list.php');
}
add_action('mpfy_template_after_map', 'mpfy_mll_template_after_map');
