<?php
/*
 Plugin Name: Vivid Image Mesage Bar
 Plugin URI: https://github.com/VividImage/VividImageMessageBar
 Description: A plugin to create a message bar at the top of the window
 Version: 1.5.7
 Author: Tyler Steinhaus
 Author URI: http://vimm.com
 */

define( 'message_bar_plugin_path', plugin_dir_path( __FILE__ ) );
define( 'message_bar_plugin_dir', plugin_dir_url( __FILE__ ) );
define( 'message_bar_plugin_js', message_bar_plugin_dir.'/assets/js/' );
define( 'message_bar_plugin_css', message_bar_plugin_dir.'/assets/css/' );

include message_bar_plugin_path.'/vimmMB-admin.class.php';
include message_bar_plugin_path.'/vimmMB-frontend.php';

if( is_admin() ) {
	new vimmMessageBarAdmin();
} else {
	new vimmMessageBarFrontEnd();
}