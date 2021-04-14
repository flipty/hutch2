<?php
/**
 * bootstrap.php - Starter file for Vivid Image Child Theme
 * Built just for Vivid Image Needs.
 * Any thing that may be used more than once
 * should go here.
 *
 * @since 03/26/2014
 * @author Tyler Steinhaus
 */

// Asset Defines
define( 'CSS_ASSETS', get_stylesheet_directory_uri().'/lib/assets/css' );
define( 'IMAGE_ASSETS', get_stylesheet_directory_uri().'/lib/assets/images' );
define( 'JS_ASSETS', get_stylesheet_directory_uri().'/lib/assets/js' );

// Theme Defines
define( 'THEME_DIR', get_stylesheet_directory_uri().'/' );
define( 'THEME_DIR2', get_stylesheet_directory().'/' );
define( 'THEME_MOBILE', get_stylesheet_directory_uri().'/mobile/' );
define( 'THEME_JS', get_stylesheet_directory_uri().'/js/' );
define( 'THEME_IMAGES', get_stylesheet_directory_uri().'/images/' );

include( 'framework.php' );
include( 'theme-supports.php' );
include( 'functions.php' );
include( 'shortcodes.class.php');
