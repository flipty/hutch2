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

	echo '<div id="'.$widgetArea.'-container">';
	mvc_dynamic_sidebar( $widget_area, true, true );
	echo '</div>';
}

/** Extra wraps for styling **/
add_theme_support( 'genesis-structural-wraps', array( 'header', 'nav', 'subnav', 'inner', 'footer-widgets', 'footer', 'home-tabs' ) );
