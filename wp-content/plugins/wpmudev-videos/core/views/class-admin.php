<?php
/**
 * The admin view functionality class.
 *
 * @link    http://premium.wpmudev.org
 * @since   1.8.0
 *
 * @author  Joel James <joel@incsub.com>
 * @package WPMUDEV_Videos\Core\Modules
 */

namespace WPMUDEV_Videos\Core\Views;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use WPMUDEV_Videos\Core\Helpers;
use WPMUDEV_Videos\Core\Abstracts\Base;
use WPMUDEV_Videos\Core\Controllers\Menu;
use WPMUDEV_Videos\Core\Controllers\Assets;

/**
 * Class Admin
 *
 * @package WPMUDEV_Videos\Core\Views
 */
class Admin extends Base {

	/**
	 * Initialize the admin view.
	 *
	 * @since 1.8.0
	 */
	public function init() {
		// Add SUI class.
		add_filter( 'admin_body_class', array( $this, 'admin_body_classes' ) );

		// Script vars.
		add_filter( 'wpmudev_vids_assets_module_vars_wpmudev-videos-settings', array( $this, 'settings_vars' ) );
		add_filter( 'wpmudev_vids_assets_module_vars_wpmudev-videos-videos', array( $this, 'videos_vars' ) );
		add_filter( 'wpmudev_vids_assets_module_vars_wpmudev-videos-playlists', array( $this, 'playlists_vars' ) );
		add_filter( 'wpmudev_vids_assets_common_vars', array( $this, 'blocks_vars' ) );
		add_filter( 'wpmudev_vids_assets_common_vars', array( $this, 'common_vars' ) );

		// Add plugin action links.
		add_filter(
			'plugin_action_links_' . plugin_basename( WPMUDEV_VIDEOS_FILE ),
			array(
				$this,
				'action_links',
			)
		);

		// Add plugin action links to network admin.
		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( WPMUDEV_VIDEOS_FILE ),
			array(
				$this,
				'action_links',
			)
		);

		// Add links next to network admin plugin details.
		add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
	}

	/**
	 * Add custom admin body class for SUI.
	 *
	 * @param string $classes Admin body class.
	 *
	 * @since 3.2.0
	 *
	 * @return string
	 */
	public function admin_body_classes( $classes ) {
		// Set our custom body class.
		$classes .= ' sui-ivt-admin';

		// Only within our admin page.
		if ( Helpers\General::is_plugin_page() ) {
			// Shared UI.
			$classes .= ' sui-' . str_replace( '.', '-', WPMUDEV_VIDEOS_SUI_VERSION ) . ' ';
		}

		return $classes;
	}

	/**
	 * Admin settings page view.
	 *
	 * Render admin settings page template with all sections.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function video_tutorials() {
		// Video tutorials page.
		echo '<div id="wpmudev-videos-tutorials-app"></div>';

		Assets::get()->enqueue_style( 'wpmudev-videos-tutorials' );
		Assets::get()->enqueue_script( 'wpmudev-videos-tutorials' );
	}

	/**
	 * Admin settings page view.
	 *
	 * Render admin settings page template with all sections.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function dashboard() {
		// Dashboard page.
		echo '<div id="wpmudev-videos-dashboard-app"></div>';

		Assets::get()->enqueue_style( 'wpmudev-videos-dashboard' );
		Assets::get()->enqueue_script( 'wpmudev-videos-dashboard' );
	}

	/**
	 * Admin settings page view.
	 *
	 * Render admin settings page template with all sections.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function videos() {
		// Videos page.
		echo '<div id="wpmudev-videos-videos-app"></div>';

		Assets::get()->enqueue_style( 'wpmudev-videos-videos' );
		Assets::get()->enqueue_script( 'wpmudev-videos-videos' );

		// Setup media libraries.
		wp_enqueue_media();
	}

	/**
	 * Admin settings page view.
	 *
	 * Render admin settings page template with all sections.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function playlists() {
		// Playlist page.
		echo '<div id="wpmudev-videos-playlists-app"></div>';

		Assets::get()->enqueue_style( 'wpmudev-videos-playlists' );
		Assets::get()->enqueue_script( 'wpmudev-videos-playlists' );

		// Setup media libraries.
		wp_enqueue_media();
	}

	/**
	 * Admin settings page view.
	 *
	 * Render admin settings page template with all sections.
	 *
	 * @since 1.8.0
	 *
	 * @return void
	 */
	public function settings() {
		// Settings page.
		echo '<div id="wpmudev-videos-settings-app"></div>';

		Assets::get()->enqueue_style( 'wpmudev-videos-settings' );
		Assets::get()->enqueue_script( 'wpmudev-videos-settings' );
	}

	/**
	 * Set localized script vars for the assets.
	 *
	 * This is the common vars available in all scripts.
	 *
	 * @param array $vars Existing vars.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function common_vars( $vars ) {
		/* translators: %s: heart icon */
		$footer_text  = sprintf( __( 'Made with %s by WPMU DEV', 'wpmudev_vids' ), '<i class="sui-icon-heart"></i>' );
		$custom_image = apply_filters( 'wpmudev_branding_hero_image', '' );
		$whitelabled  = apply_filters( 'wpmudev_branding_hide_branding', false );

		// Settings data.
		$vars['settings']  = Helpers\Settings::get_with_default();
		$vars['user_name'] = Helpers\General::get_user_name();

		// White labelling.
		$vars['whitelabel'] = array(
			'hide_branding' => apply_filters( 'wpmudev_branding_hide_branding', false ),
			'hide_doc_link' => apply_filters( 'wpmudev_branding_hide_doc_link', false ),
			'footer_text'   => apply_filters( 'wpmudev_branding_footer_text', $footer_text ),
			'custom_image'  => $custom_image,
			'is_unbranded'  => empty( $custom_image ) && $whitelabled,
			'is_rebranded'  => ! empty( $custom_image ) && $whitelabled,
		);

		// Rest data.
		$vars['rest'] = array(
			'base'  => rest_url( 'wpmudev-videos/v1/' ),
			'nonce' => wp_create_nonce( 'wp_rest' ),
		);

		// Urls.
		$vars['urls'] = array(
			'base'         => WPMUDEV_VIDEOS_URL,
			'dash_login'   => class_exists( 'WPMUDEV_Dashboard' ) ? \WPMUDEV_Dashboard::$ui->page_urls->dashboard_url : '',
			'dash_install' => 'https://premium.wpmudev.org/project/wpmu-dev-dashboard/',
			'tutorials'    => Helpers\General::url( 'tutorials' ),
			'dashboard'    => Helpers\General::url( 'dashboard' ),
			'videos'       => Helpers\General::url( 'videos' ),
			'playlists'    => Helpers\General::url( 'playlists' ),
			'settings'     => Helpers\General::url( 'settings' ),
			'plugins'      => network_admin_url( 'plugins.php' ),
		);

		// Flags.
		$vars['flags'] = array(
			'network'   => (int) is_network_admin(),
			'multisite' => (int) is_multisite(),
		);

		// Get API key.
		$api_key = Helpers\General::api_key();

		// Membership data.
		$vars['membership'] = array(
			'status'         => Helpers\General::membership_status(),
			'valid'          => (int) Helpers\General::is_valid_member(),
			'dash_active'    => (int) class_exists( 'WPMUDEV_Dashboard' ),
			'dash_connected' => (int) ( class_exists( 'WPMUDEV_Dashboard' ) && ! empty( $api_key ) ),
			'dash_installed' => (int) file_exists( trailingslashit( WP_PLUGIN_DIR ) . 'wpmudev-updates/update-notifications.php' ),
		);

		return $vars;
	}

	/**
	 * Set localized script vars for the settings script.
	 *
	 * @param array $vars Existing vars.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function settings_vars( $vars ) {
		$vars['roles'] = Helpers\Data::get_roles( false );
		// Menu locations.
		$vars['menu_locations'] = array(
			'dashboard' => __( 'Dashboard', 'wpmudev_vids' ),
			'top'       => __( 'Top Level', 'wpmudev_vids' ),
		);

		// Export nonce.
		$vars['export_nonce'] = wp_create_nonce( 'ivt-export' );

		// Include support system.
		if ( function_exists( 'incsub_support' ) ) {
			$vars['menu_locations']['support_system'] = __( 'Support System Plugin', 'wpmudev_vids' );
		}

		return $vars;
	}

	/**
	 * Set localized script vars for the videos script.
	 *
	 * @param array $vars Existing vars.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function videos_vars( $vars ) {
		$vars['hosts'] = Helpers\Data::custom_hosts();

		return $vars;
	}

	/**
	 * Set localized script vars for the playlists script.
	 *
	 * @param array $vars Existing vars.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function playlists_vars( $vars ) {
		$vars['roles']     = Helpers\Data::get_roles( false );
		$vars['locations'] = Helpers\Data::video_pages();

		return $vars;
	}

	/**
	 * Set localized script vars for the playlists script.
	 *
	 * @param array $vars Existing vars.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function blocks_vars( $vars ) {
		$vars['videos_menu_title'] = Menu::get()->videos_menu_title();

		return $vars;
	}

	/**
	 * Action links for plugins listing page.
	 *
	 * Add quick links to plugin settings page, docs page, upgrade page
	 * from the plugins listing page.
	 *
	 * @param array $links Links array.
	 *
	 * @since 3.2.0
	 *
	 * @return array
	 */
	public function action_links( $links ) {
		// Added a fix for weird warning in multisite, "array_unshift() expects parameter 1 to be array, null given".
		$links = empty( $links ) ? array() : $links;

		// Common links.
		$custom = array(
			'settings' => '<a href="' . Helpers\General::url( 'settings' ) . '" aria-label="' . esc_html__( 'Settings', 'wpmudev_vids' ) . '">' . esc_html__( 'Settings', 'wpmudev_vids' ) . '</a>',
			'docs'     => '<a href="https://premium.wpmudev.org/docs/wpmu-dev-plugins/integrated-video-tutorials/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_pluginlist_docs" aria-label="' . esc_html__( 'Documentation', 'wpmudev_vids' ) . '" target="_blank">' . esc_html__( 'Docs', 'wpmudev_vids' ) . '</a>',
		);

		// Get the membership status.
		$status = Helpers\General::membership_status();

		// If expired or membership is free.
		if ( in_array( $status, array( 'expired', 'free' ), true ) ) {
			// Show renew link.
			$custom['renew'] = '<a href="https://premium.wpmudev.org/project/unbranded-video-tutorials/?utm_source=integrated_video_tutorials&utm_medium=plugin&utm_campaign=integrated_video_tutorials_pluginlist_renew" aria-label="' . esc_html__( 'Renew Your Membership', 'wpmudev_vids' ) . '" target="_blank" style="color: #8D00B1;">' . esc_html__( 'Renew Membership', 'wpmudev_vids' ) . '</a>';
		} elseif ( ! Helpers\General::is_valid_member() ) {
			// Show upgrade link.
			$custom['upgrade'] = '<a href="https://premium.wpmudev.org/project/unbranded-video-tutorials/?utm_source=beehive&utm_medium=plugin&utm_campaign=beehive_pluginlist_upgrade" aria-label="' . esc_attr( __( 'Upgrade to Beehive Pro', 'wpmudev_vids' ) ) . '" target="_blank" style="color: #8D00B1;">' . esc_html__( 'Upgrade', 'wpmudev_vids' ) . '</a>';
		}

		// Merge custom links to first.
		$links = array_merge( $custom, $links );

		return $links;
	}

	/**
	 * Add custom links to support and roadmap next to plugin meta.
	 *
	 * @param array  $links Current links.
	 * @param string $file  Plugin base name.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function plugin_row_meta( $links, $file ) {
		// Make sure the links are array.
		$links = empty( $links ) ? array() : $links;

		// Only for our plugin.
		if ( plugin_basename( WPMUDEV_VIDEOS_FILE ) === $file ) {
			// Replace view plugin site link.
			if ( isset( $links[2] ) ) {
				$links[2] = '<a href="https://premium.wpmudev.org/project/unbranded-video-tutorials/" target="_blank">' . esc_html__( 'View Details', 'wpmudev_vids' ) . '</a>';
			}

			$custom = array(
				'support' => '<a href="https://premium.wpmudev.org/get-support/" aria-label="' . esc_html__( 'Get Premium Support', 'wpmudev_vids' ) . '" target="_blank">' . esc_html__( 'Premium Support', 'wpmudev_vids' ) . '</a>',
				'roadmap' => '<a href="https://premium.wpmudev.org/roadmap/" aria-label="' . esc_html__( 'View our Public Roadmap', 'wpmudev_vids' ) . '" target="_blank">' . esc_html__( 'Roadmap', 'wpmudev_vids' ) . '</a>',
			);

			// Add our custom links.
			$links = array_merge( $links, $custom );
		}

		return $links;
	}

	/**
	 * Get plugin menu icon data.
	 *
	 * Get svg image instead of an image url.
	 *
	 * @since 1.8.0
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		ob_start();
		?>
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
			<defs>
				<style>
					.cls-1 {
						fill: #fff;
					}
				</style>
			</defs>
			<title>IVT</title>
			<g id="Layer_2" data-name="Layer 2">
				<g id="Balls_01" data-name="Balls 01">
					<path class="cls-1" d="M31.6,19.55A16.1,16.1,0,0,0,32,16,15.9,15.9,0,0,0,27.39,4.77,16.38,16.38,0,0,0,24.1,2.2a16,16,0,0,0-16.2,0,15.36,15.36,0,0,0-1.51,1L29.55,17.67A7,7,0,0,1,31.6,19.55Z"/>
					<path class="cls-1" d="M16,32a16,16,0,0,0,11.83-5.23,15.71,15.71,0,0,0,2-2.67,3.49,3.49,0,0,0,.3-1.56,3.4,3.4,0,0,0-1.86-2.78l-4.3-2.68-1.15.72-4,2.49C15,22.68,10.36,25.62,8.25,26.94A6.86,6.86,0,0,1,5.42,28a16.5,16.5,0,0,0,3.26,2.23A15.85,15.85,0,0,0,16,32Z"/>
					<path class="cls-1" d="M9.67,21.56V8.17L4.47,4.92,4.4,5A16,16,0,0,0,2.34,24.34h0a3.44,3.44,0,0,0,1.28,1,3.43,3.43,0,0,0,3.31-.46l2.73-1.71Z"/>
					<path class="cls-1" d="M12.13,9.87V21.56l5.36-3.35c1.55-1,3-1.87,4-2.51Z"/>
				</g>
			</g>
		</svg>
		<?php
		$svg = ob_get_clean();

		// phpcs:ignore
		return 'data:image/svg+xml;base64,' . base64_encode( $svg );
	}
}