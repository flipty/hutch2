<?php
/*
* Plugin Name: Vimm Accessibility
* Plugin URI: http://www.vimm.com
* Description: Creates the shortcode [get-accessibility-statement] to load the accessibility page content remotely
* Author: Vivid Image Development Team 
* Version: 1.0
* Author URI: http://www.vimm.com
* GitHub Plugin URI: https://github.com/VividImage/vimm-internal-note
*/


/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

class Vimm_Accessibility {
	/*--------------------------------------------*
	 * Attributes
	 *--------------------------------------------*/

	/** Refers to a single instance of this class. */
	private static $instance = null;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return  Vimm_Accessibility A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	} // end get_instance;

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	private function __construct() {
		add_shortcode( 'get-accessibility-statement', array( $this, 'vi_accessibility_callback' ) );

	} // end constructor
 
	/*--------------------------------------------*
	 * Functions
	 *--------------------------------------------*/

	static function vimm_accessibility_deactivate() {

	}

	static function vimm_accessibility_activation() {

	}

	public function vi_accessibility_callback() {
		$response = wp_remote_get( 'http://training.vimm.com/wp-content/uploads/accessibility.txt' );

		if ( is_array( $response ) ) {
			// Get the content for our accessibility statement
			$body = $response['body']; // use the content
			// Update our local option to use as a cache 
			update_option( 'accessibility_statement_cache', $body );
		} else {
			// Our request failed so use our cached backup version
			$body = get_option( 'accessibility_statement_cache' );
		}
		return $body;
	}

}

register_activation_hook( __FILE__, array( 'Vimm_Accessibility', 'vimm_accessibility_activation' ) );
register_deactivation_hook( __FILE__, array( 'Vimm_Accessibility', 'vimm_accessibility_deactivate' ) );

Vimm_Accessibility::get_instance();
?>