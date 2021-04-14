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

if( !class_exists( 'vivid_child_theme' ) ) {
	class vi_child_theme {

		/**
		 * Start by constructing the class
		 * @since 03/28/2014
		 * @author Tyler Steinhaus
		 */
		public function __construct() {

			// Include the Social Media Widget
			require( 'widgets/social-media-icons/social-media-icons.widget.php' );

			// Admin Enqueue Scipts/Styles
			add_action( 'admin_enqueue_scripts', array( $this, 'backendScripts' ) );

			// Enqueue Default Scripts
			add_action( 'wp_enqueue_scripts', array( $this, 'frontendScripts' ) );

            // Remove Text Color from TinyMCE
            add_filter('tiny_mce_before_init', array( $this, 'change_tinymce_text_color' ) );

			// Pass theme url to javascript
			add_action( 'wp_enqueue_scripts', function() {
				wp_localize_script( 'themeURL', 'vi', array( 'themeURL' => THEME_DIR ) );
			} );

			// Change Default Text Colors
			add_filter( 'tinymce_custom_colors', array( $this, 'tinymce_custom_colors') );

			// Add Message Bar Colors
			//add_filter( 'message_bar_colors', array( $this, 'message_bar_custom_colors' ) );

			// Custom Shortcodes
			add_shortcode( 'vimm_link', array( $this, 'vimm_link' ) ); // Vivid Image Link Shortcode
			add_shortcode( 'vimm_pp_link', array( $this, 'vimm_pp_link' ) ); // Privacy Policy Link Shortcode
			add_shortcode( 'vimm_sitemap_link', array( $this, 'vimm_sitemap_link' ) ); // Sitemap Link Shortcode

			// Gravity Forms - Honeypot always enabled
			add_filter( 'gform_pre_form_settings_save', array( $this, 'gravityforms_enable_honeypot' ) );

			// Add Message Bar Colors
		}

		/**
		 * Enqueue helper.js
		 * @since 04/14/2014
		 * @author Tyler Steinhaus
		 */
		public function frontendScripts() {
			wp_enqueue_script( 'helper-js', JS_ASSETS.'/helpers.js', array( 'jquery' ), null, false );
		}

		/**
		 * Admin Enqueue Scripts/Styles
		 * @since 03/31/2014
		 * @author Tyler Steinhaus
		 */
		function backendScripts() {
			// Register scripts for use later
			wp_register_script( 'mediagallery-easy', JS_ASSETS.'/mediagallery.jquery.js', array( 'jquery' ) );
			wp_register_script( 'helper-js', JS_ASSETS.'/helpers.js', array( 'jquery' ), null, false );

			// Dequeue MVC Admin stylesheet and include the child themes
			wp_deregister_style( 'mvc-admin-styles' );
			wp_enqueue_style( 'theme-admin-css', THEME_DIR.'admin.css' );
		}

		/**
		 * Checks to see if file exists using CURL for offsite urls
		 * @since 03/24/2014
		 * @author Tyler Steinhaus
		 *
		 * @param string $url url to to file to see if it exists
		 */
		function check_file_exists( $url ) {
			$url = str_replace( ' ', '%20', $url );
			$ch = curl_init( $url );

			curl_setopt( $ch, CURLOPT_NOBODY, true );
			curl_exec( $ch );
			$return_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
			curl_close( $ch );

			return $return_code == 200 ? true : false;
		}

        /**
		 * Change TinyMCE Text Colors to Theme Defaults
		 * @since 04/29/2014 - Original
		 * @author Tyler Steinhaus
		 *
	   	 * @since 05/02/2014
	     * Checks to see whether we are using 3.9 and above, if so we use the new format otherwise us old.
	     *
		 * @uses Gives you the ability to change the default colors of the TinyMCE Text Color Selector
		 * @uses add to functions.php: add_filter( 'tiny_mce_plugins', array( $vivid, 'removeTextColorTinyMCE' ), 10, 1 );
		 *
		 * @param array $init initial TinyMCE settings
		 */
		function change_tinymce_text_color( $init ) {
			/**
			 * This will allow you to customize the TinyMCE Text Colors
			 * @uses array( 'HEX COLOR' => 'COLOR TITLE' );
			 */
			$custom_colors = apply_filters( 'tinymce_custom_colors', NULL );
			if( empty( $custom_colors ) ) $custom_colors = array();
			$colors = '';
			if( isset( $custom_colors ) ) {
				foreach( $custom_colors as $color => $title ) {
					$colors .= '"'.$color.'", "'.$title.'", ';
				}
				$custom_colors = substr( $colors, 0, -2 );

				$init['textcolor_map'] = '['.$custom_colors.']';
				$init['textcolor_rows'] = 6;
			}
			return $init;
		}

		/**
		 * Add's the custom colors for the TinyMCE that the admin adds
		 * to the VI Theme Settings Page
		 *
		 * @since 10/22/2014
		 * @author Tyler Steinhaus
		 */
		function tinymce_custom_colors() {
			$colors = genesis_get_option( 'tinymce_colors', 'vi-settings' );
			if( !empty( $colors ) ) {
				$custom_colors = array();
				foreach( $colors as $color ) {
					$color = str_replace( '#', '', $color );
					$custom_colors[$color] = $color;
				}

				return $custom_colors;
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
		 * Custom Shortcode to add link for Vivid Image to the footer
		 *
		 * @since 11/26/2014
		 * @author Tyler Steinhaus
		 */
		function vimm_link() {
			return '<a href="http://www.vimm.com" class="vivid-image" target="_blank">Vivid Image, Inc</a>';
		}

		/**
		 * Custom Shortcode to add link for Site Map
		 *
		 * @since 11/26/2014
		 * @author Tyler Steinhaus
		 */
		function vimm_sitemap_link() {
			$post_id = get_postid_by_slug( 'sitemap' );
			return '<a href="'.get_the_permalink( $post_id ).'" class="vivid-image-sitemap">Sitemap</a>';
		}

		/**
		 * Custom Shortcode to add link for Privacy Policy to the footer
		 *
		 * @since 11/26/2014
		 * @author Tyler Steinhaus
		 */
		function vimm_pp_link() {
			$post_id = get_postid_by_slug( 'privacy-policy' );
			return '<a href="'.get_the_permalink( $post_id ).'" class="vivid-image-pp">Privacy Policy</a>';
		}

		/**
		 * Make sure that honeypot is always enabled on a gravity form
		 *
		 * @since  12/03/2014
		 * @author  Tyler Steinhaus
		 */
		function gravityforms_enable_honeypot( $updated_form ) {
			$updated_form['enableHoneypot'] = 1;

			return $updated_form;
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
	}

	$vivid = new vi_child_theme();
}
