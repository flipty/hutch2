<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Vimm Document Manager
 * Plugin URI:        https://vimm.com/
 * Description:       A simple and elegant way to manage files placed throughout your site.
 * Version:           1.5.10
 * Author:            Vivid Image
 * Author URI:        https://vimm.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       vimm-dm
 * Domain Path:       /languages
 * GitHub Plugin URI: https://github.com/VividImage/vimm-document-manager
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-vimm-dm-activator.php
 */
function activate_vimm_dm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vimm-dm-activator.php';
	Vimm_DM_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-vimm-dm-deactivator.php
 */
function deactivate_vimm_dm() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-vimm-dm-deactivator.php';
	Vimm_DM_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_vimm_dm' );
register_deactivation_hook( __FILE__, 'deactivate_vimm_dm' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-vimm-dm.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_vimm_dm() {

	$plugin = new Vimm_DM();
	$plugin->run();

}
run_vimm_dm();