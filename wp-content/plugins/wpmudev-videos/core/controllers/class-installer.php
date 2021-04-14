<?php
/**
 * The install/update functionality class.
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

use WPMUDEV_Videos\Core\Abstracts\Base;
use WPMUDEV_Videos\Core\Helpers\General;
use WPMUDEV_Videos\Core\Helpers\Settings;
use WPMUDEV_Videos\Core\Modules\Playlists;
use WPMUDEV_Videos\Core\Modules\Videos\Models\Video;

/**
 * Class Compatibility
 *
 * @package WPMUDEV_Videos\Core\Controllers
 */
class Installer extends Base {

	/**
	 * Initialize installer.
	 *
	 * @since 1.8.0
	 */
	public function init() {
		// Process upgrade.
		add_action( 'init', array( $this, 'upgrade' ), 999 );
	}

	/**
	 * Run plugin activation scripts.
	 *
	 * If plugin is activated for the first time, setup the
	 * version details, and other flags.
	 *
	 * @since 1.8.0
	 */
	public function activate() {
		// Current plugin version.
		$version = get_site_option( 'wpmudev_videos_version', WPMUDEV_VIDEOS_VERSION );

		// Set default settings.
		$this->setup_default_settings();

		/**
		 * Action hook to execute after activation.
		 *
		 * @param int Old version.
		 * @param int New version.
		 *
		 * @since 1.8.0
		 */
		do_action( 'wpmudev_vids_after_activate', $version, WPMUDEV_VIDEOS_VERSION );
	}

	/**
	 * Upgrade if we are updating from old version.
	 *
	 * This method will only update the version number if the
	 * installation is new.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function upgrade() {
		// Current plugin version.
		$version = get_site_option( 'wpmudev_videos_version', '1.0.0' );

		// Upgrade to 1.8.0.
		if ( version_compare( $version, '1.8.0', '<' ) ) {
			$this->upgrade_1_8_0();
		}

		// Upgrade to 1.8.4.
		if ( version_compare( $version, '1.8.4', '<' ) ) {
			$this->upgrade_1_8_4();
		}

		// If new installation or older versions.
		if ( WPMUDEV_VIDEOS_VERSION !== $version ) {
			// Mark the plugin version.
			update_site_option( 'wpmudev_videos_version', WPMUDEV_VIDEOS_VERSION );

			/**
			 * Action hook to execute after upgrade.
			 *
			 * @param int Old version.
			 * @param int New version.
			 *
			 * @since 1.8.0
			 */
			do_action( 'wpmudev_vids_after_upgrade', $version, WPMUDEV_VIDEOS_VERSION );
		}
	}

	/**
	 * Set default settings for the first time.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function setup_default_settings() {
		$settings = Settings::get();

		// Settings already exist.
		if ( ! empty( $settings ) ) {
			return;
		}

		$settings = Settings::get_default();

		// Set menu title.
		$settings['menu_title'] = __( 'Video Tutorials', 'wpmudev_vids' );

		// Update default.
		Settings::update( $settings );
	}

	/**
	 * Upgrade to 1.8.0 version.
	 *
	 * Added new option to show welcome modal.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	private function upgrade_1_8_0() {
		$settings = Settings::get();

		// Upgrade is not required because old settings does not exist.
		if ( empty( $settings ) ) {
			return;
		}

		// Migrate show menu option.
		if ( isset( $settings['menu_location'] ) && 'none' === $settings['menu_location'] ) {
			Settings::update( false, 'show_menu' );
			Settings::update( 'dashboard', 'menu_location' );
		} elseif ( ! empty( $settings['menu_location'] ) ) {
			// Should show menu.
			Settings::update( true, 'show_menu' );
		}

		// Show upgrade notice.
		Settings::update( false, 'dismiss_welcome_notice' );

		// Upgrade the post meta.
		$this->upgrade_1_8_0_posts();
	}

	/**
	 * Upgrade to 1.8.4 version.
	 *
	 * Show welcome modal to tell about new features.
	 *
	 * @since 1.8.3
	 *
	 * @return void
	 */
	private function upgrade_1_8_4() {
		$settings = Settings::get();

		// Upgrade is not required because old settings does not exist.
		if ( empty( $settings ) ) {
			return;
		}

		// Show upgrade notice.
		Settings::update( false, 'dismiss_welcome_notice' );

		// Update playlist order.
		$this->upgrade_1_8_4_playlists();
	}

	/**
	 * Upgrade the old video meta to new structure.
	 *
	 * In old version, custom video options where saved in a single
	 * meta field. We have changed that to individual meta fields
	 * in 1.8.0
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	private function upgrade_1_8_0_posts() {
		// Switch site.
		General::switch_site();

		// Post query.
		$query = new \WP_Query(
			array(
				'post_type'      => Video::POST_TYPE,
				'posts_per_page' => - 1,
				'fields'         => 'ids',
			)
		);

		// If we have custom videos.
		if ( $query->have_posts() ) {
			// phpcs:ignore
			foreach ( $query->posts as $post ) {
				// Get custom data.
				$meta = get_post_meta( $post, 'video_data', true );
				// If not valid, skip.
				if ( empty( $meta ) || ! is_array( $meta ) ) {
					continue;
				}

				// Prepare the post data.
				$post_data = array(
					'ID'         => $post,
					'meta_input' => array(
						'video_type'       => 'custom',
						'video_duration'   => '',
						'video_host'       => empty( $meta['video_host'] ) ? 'youtube' : $meta['video_host'],
						'video_url'        => empty( $meta['video_url'] ) ? '' : $meta['video_url'],
						'video_start'      => empty( $meta['video_start'] ) ? 0 : 1,
						'video_end'        => empty( $meta['video_end'] ) ? 0 : 1,
						'video_start_time' => empty( $meta['video_start_time'] ) ? '' : $meta['video_start_time'],
						'video_end_time'   => empty( $meta['video_end_time'] ) ? '' : $meta['video_end_time'],
					),
				);

				// Update the post.
				wp_update_post( $post_data );
			}
		}

		// Switch back to original site.
		General::restore_site();
	}

	/**
	 * Upgrade the old playlist to add order.
	 *
	 * In old version, we don't have order meta value set.
	 * Set the order value based on the playlist ids.
	 *
	 * @since 1.8.4
	 *
	 * @return void
	 */
	private function upgrade_1_8_4_playlists() {
		// Switch site.
		General::switch_site();

		// Get all available playlist ids.
		$playlists = Playlists\Models\Query::get()->playlists(
			array(
				'show_all' => true,
				'orderby'  => 'term_id',
				// phpcs:ignore
				'meta_key' => '',
			)
		);

		// If playlists found.
		if ( ! empty( $playlists ) ) {
			// Starting order.
			$order = 0;

			// For each playlists.
			foreach ( $playlists as $playlist ) {
				// Set the order.
				update_term_meta( $playlist, 'playlist_order', $order );

				// Increase the order.
				$order ++;
			}
		}

		// Switch back to original site.
		General::restore_site();
	}
}