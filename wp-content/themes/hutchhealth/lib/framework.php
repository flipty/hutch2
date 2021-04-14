<?php
/**
 * framework.php - Default framework functions
 * Built just for Vivid Image Needs.
 * Any thing that may be used more than once
 * should go here.
 *
 * @since 03/26/2014
 * @author Tyler Steinhaus
 */

if( !class_exists( 'vividChild' ) ) {
	class vividChild {

		// Determine how many outabody's to make
		public $outabody = 3; // default is 3

		/**
		 * Start by constructing the class
		 * @since 03/28/2014
		 * @author Tyler Steinhaus
		 */
		function __construct() {

			// Display our outabody's
			add_action( 'genesis_before', array( $this, 'outabodyStart' ) );
			add_action( 'genesis_after', array( $this, 'outabodyEnd' ) );

			// Admin Enqueue Scipts/Styles
			add_action( 'admin_enqueue_scripts', array( $this, 'adminEnqueue' ) );

			// Add Message Bar Colors
			//add_filter( 'message_bar_colors', array( $this, 'message_bar_custom_colors' ) );

			// Register Widgets
			add_action( 'widgets_init', array( $this, 'registerWidgets' ) );
		}

		/**
		 * Create the beginning of our outabody's
		 * @since 03/28/2014
		 * @author Tyler Steinhaus
		 */
		function outabodyStart() {
			for( $i = 1;$i <= $this->outabody;$i++ ) {
				echo '<div class="outabody'.$i.'">';
			}
		}

		/**
		 * Create the closing tags for our outabody's
		 * @since 03/28/2014
		 * @author Tyler Steinhaus
		 */
		function outabodyEnd() {
			for( $i = 1;$i >= $this->outabody;$i++ ) {
				echo '</div>';
			}
		}

		/**
		 * Add's the custom colors for the VIMM Message Bar that the admin adds
		 * to the VI Theme Settings Page
		 *
		 * @since 10/22/2014
		 * @author Tyler Steinhaus
		 */
		function message_bar_custom_colors() {
			$colors = genesis_get_option( 'messagebar_colors', 'vi-settings' );
			if( !empty( $colors ) ) {
				return $colors;
			}
		}

		/**
		 * Checks to see if file exists using CURL for offsite urls
		 * @since 03/24/2014
		 * @author Tyler Steinhaus
		 *
		 * @param string $url url to to file to see if it exists
		 */
		function fileExists( $url ) {
			$url = str_replace( ' ', '%20', $url );
			$ch = curl_init( $url );

			curl_setopt( $ch, CURLOPT_NOBODY, true );
			curl_exec( $ch );
			$return_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
			curl_close( $ch );

			return $return_code == 200 ? true : false;
		}

		/**
		 * Admin Enqueue Scripts/Styles
		 * @since 03/31/2014
		 * @author Tyler Steinhaus
		 */
		function adminEnqueue() {
			wp_enqueue_scripts( 'mediagallery-easy', JS_ASSETS.'/mediagallery.jquery.js', array( 'jquery' ) );
			wp_enqueue_style( 'theme-admin-css', THEME_DIR.'admin.css' );
		}

		/**
		 * VIMM Social Profile Icons
		 * @since 04/07/2014
		 * @author Tyler Steinhaus
		 */
		function registerWidgets() {
			require( 'widgets/vimm-profiles-widget/vimm.profiles.widget.php' );
			register_widget('Vimm_Profiles_Widget');
		}
	}
	$vivid = new vividChild();
}
