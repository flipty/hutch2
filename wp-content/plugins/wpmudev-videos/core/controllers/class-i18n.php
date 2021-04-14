<?php
/**
 * The internationalization class of the plugin.
 *
 * @link    http://premium.wpmudev.org
 * @since   1.8.0
 *
 * @author  Joel James <joel@incsub.com>
 * @package WPMUDEV_Videos\Core\Controllers
 */

namespace WPMUDEV_Videos\Core\Controllers;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use WPMUDEV_Videos\Core\Views\Locale;
use WPMUDEV_Videos\Core\Abstracts\Base;

/**
 * Class I18n
 *
 * @package WPMUDEV_Videos\Core\Controllers
 */
class I18n extends Base {

	/**
	 * Initialize the class by registering hooks.
	 *
	 * @since 3.2.4
	 *
	 * @return void
	 */
	public function init() {
		// Set text domain.
		add_action( 'init', array( $this, 'setup_locale' ) );
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the I18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since  1.7.0
	 * @since  1.8.0 Moved to own class.
	 * @access public
	 *
	 * @return void
	 */
	public function setup_locale() {
		// Localize the plugin.
		load_plugin_textdomain(
			'wpmudev_vids',
			false,
			WPMUDEV_VIDEOS_DIR . '/languages/'
		);
	}

	/**
	 * Get the locale string to use with JS files.
	 *
	 * @param string $type String type.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function get_strings( $type ) {
		$strings = Locale::get()->common();

		switch ( $type ) {
			case 'wpmudev-videos-settings':
				// Merge with common strings.
				$strings = array_merge(
					$strings,
					array(
						'settings' => Locale::get()->settings(),
					)
				);
				break;
			case 'wpmudev-videos-dashboard':
				// Merge with common strings.
				$strings = array_merge(
					$strings,
					array(
						'dashboard' => Locale::get()->dashboard(),
					)
				);
				break;
			case 'wpmudev-videos-videos':
				// Merge with common strings.
				$strings = array_merge(
					$strings,
					array(
						'videos' => Locale::get()->videos(),
					)
				);
				break;
			case 'wpmudev-videos-playlists':
				// Merge with common strings.
				$strings = array_merge(
					$strings,
					array(
						'playlists' => Locale::get()->playlists(),
					)
				);
				break;
			case 'wpmudev-videos-tutorials':
				// Merge with common strings.
				$strings = array_merge(
					$strings,
					array(
						'tutorials' => Locale::get()->tutorials(),
					)
				);
				break;
		}

		/**
		 * Filter to add more strings to the script specific locale vars.
		 *
		 * @param array  $strings Locale vars.
		 * @param string $type    Locale script type.
		 *
		 * @since 1.8.0
		 */
		return apply_filters( 'wpmudev_vids_i18n_get_locale_scripts', $strings, $type );
	}
}