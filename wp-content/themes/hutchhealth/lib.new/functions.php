<?php

/**
 * Vivid Image Dynamic Sidebar
 * @since 04/03/2014
 * @author Tyler Steinhaus
 *
 * @param string $widget_area Widget area you would like to display with a wrap around it
 */
function vimm_dynamic_sidebar( $widget_area ) {

	$widgetArea = strtolower( $widget_area );
	$widgetArea = str_replace( ' ', '-', $widgetArea );
	$widgetArea = str_replace( '/', '', $widgetArea );
	$widgetArea = str_replace( '.', '', $widgetArea );

	$html = '<div id="'.$widgetArea.'-container">';
	$html .= mvc_dynamic_sidebar( $widget_area, false, true );
	$html .= '</div>';
	
	$html = apply_filters( 'vimm_dynamic_sidebar', $html, $widget_area, $widgetArea );
	
	return $html;
}

/**
 * Get the post id by slug
 *
 * @since 11/26/2014
 * @author Tyler Steinhaus
 */
function get_postid_by_slug( $slug ) {
	global $wpdb;

	// Check the posts table to see if slug exists
	$slug = $wpdb->get_results( "SELECT `ID` FROM {$wpdb->posts} WHERE `post_name`='{$slug}'" );

	if(  $slug[0]->ID != 0 ) {
		return  $slug[0]->ID;
	}

	return FALSE;
}

/**
 * Get the post by post_name (post slug)
 *
 * @since 11/29/2014
 * @author Tyler Steinhaus
 */
function get_post_by_slug( $slug ) {

	$post_id = get_postid_by_slug( $slug );

	return get_post( $post_id, OBJECT );
}