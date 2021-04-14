<?php
/*DB
	Plugin Name: Vimm CMS
	Plugin URI: http://www.vimm.com
	Description:  Vivid Image's Own Flavor of CMS
	Version: 4.8.7
	Author: Mat Lipe
	Author URI: http://www.vimm.com
	GitHub Plugin URI: https://github.com/VividImage/vimm-cms
*/

// Quick and Easy calls
define( 'PLUGIN_TITLE', 'Vimm CMS' );
define( 'PLUGIN_DB_NAME', 'vimm-cms' );
define( 'PLUGIN_VERSION', '4.8.7' );

// Bring in the methods
require plugin_dir_path( __FILE__ ).'/vimmcms.class.php';
$vimmcms = new vimm_cms();

// Bring in the plugins page
require plugin_dir_path( __FILE__ ).'/vimmcms-plugins.class.php';
$vimmcms_plugins = new vimmcms_plugins();

// Bring in Admin Page
require plugin_dir_path( __FILE__ ).'/vimmcms-admin.class.php';
$vimmcms_admin = new vimmcms_admin();

// Bring in Dashbard Class
require plugin_dir_path( __FILE__ ).'/vimmcms-dashboard.class.php';
$vimmcms_dashboard = new vimmcms_dashboard();

// Bring in User Caps class
require plugin_dir_path( __FILE__ ).'/vimmcms-usercaps.class.php';
$vimmcms_usercaps = new vimmcms_usercaps();

// Bring in vimm cms upgrades class
require plugin_dir_path( __FILE__ ).'vimmcms-upgrades.class.php';
$vimmcms_upgrades = new vimmcms_upgrades();
