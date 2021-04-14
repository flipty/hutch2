<?php
/**
 * bootstrap.php - Starter file for Vivid Image Child Theme
 * Built just for Vivid Image Needs.
 * Any thing that may be used more than once
 * should go here..
 *
 * @version 1.2
 *
 * @since 03/26/2014
 * @author Tyler Steinhaus
 */

// Asset Defines
define( 'ASSETS', get_stylesheet_directory().'/lib/assets/' );
define( 'CSS_ASSETS', get_stylesheet_directory_uri().'/lib/assets/css' );
define( 'IMAGE_ASSETS', get_stylesheet_directory_uri().'/lib/assets/images' );
define( 'JS_ASSETS', get_stylesheet_directory_uri().'/lib/assets/js' );

// Theme Defines
define( 'THEME_DIR', get_stylesheet_directory_uri().'/' );
define( 'THEME_MOBILE', get_stylesheet_directory_uri().'/mobile/' );
define( 'THEME_JS', get_stylesheet_directory_uri().'/js/' );
define( 'THEME_IMAGES', get_stylesheet_directory_uri().'/images/' );

include 'framework.php';
include 'shortcodes.class.php';
include 'theme-supports.class.php';
include 'functions.php';
include 'seo.class.php'; // Main SEO Class
include 'theme-settings/theme-settings.class.php';
include 'theme-settings/seo.class.php';
include 'tasks.php';

/**
 * Deregister Widgets we never use.
 *
 * @since  12/08/2014
 * @author  Tyler Steinhaus
 */
add_action( 'widgets_init', 'unregister_default_widgets' );
function unregister_default_widgets() {
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Widget_Meta' );
	unregister_widget( 'WP_Widget_Recent_Comments' );
	unregister_widget( 'WP_Widget_RSS' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'Genesis_User_Profile_Widget' );
}

/**
 * Add our theme settings page
 *
 * @since 10/21/2014
 * @author Tyler Steinhaus
 */
function add_vi_theme_settings() {
	global $_vi_child_settings;

	new vi_child_theme_settings();
	new vi_child_theme_seo_settings();
}
add_action( 'genesis_admin_menu', 'add_vi_theme_settings' );

// All Theme setup stuff goes below here
add_action( 'after_theme_setup', 'theme_setup' );
function theme_setup() {
	add_editor_style( get_stylesheet_directory_uri().'/style.css' );
}



/**
 * Wordpress doesn't allow you to modify post-type single pages by slug name like you can 
 * with posts and pages. This function allows you to do that with custom post types.
 *
 * @since 11/29/2014
 * @author Tyler Steinhaus
 */
add_filter( 'single_template', 'posttype_single_page' );
function posttype_single_page( $single_template ) {
	global $post;

	if( $post->post_type != 'post' || $post->post_type != 'page' ) {
		if( file_exists( get_stylesheet_directory()."/{$post->post_type}-{$post->post_name}.php" ) ) {
			$single_template = get_stylesheet_directory()."/{$post->post_type}-{$post->post_name}.php";
		}

		if( file_exists( get_stylesheet_directory()."/{$post->post_type}-{$post->ID}.php" ) ) {
			$single_template = get_stylesheet_directory()."/{$post->post_type}-{$post->ID}.php";
		}
	}

	return $single_template;
}