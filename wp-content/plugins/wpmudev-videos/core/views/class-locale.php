<?php
/**
 * The locale view class of the plugin.
 *
 * This class will handle all the strings required in Vue files.
 *
 * @link    http://premium.wpmudev.org
 * @since   1.8.0
 *
 * @author  Joel James <joel@incsub.com>
 * @package WPMUDEV_Videos\Core\Views
 */

namespace WPMUDEV_Videos\Core\Views;

// If this file is called directly, abort.
defined( 'WPINC' ) || die;

use WPMUDEV_Videos\Core\Abstracts\Base;

/**
 * Class Locale
 *
 * @package WPMUDEV_Videos\Core\Views
 */
class Locale extends Base {

	/**
	 * Get the common vars available to all files.
	 *
	 * This data will be available in all scripts.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function common() {
		return array(
			'dialogs' => array(
				'close'    => __( 'Close this dialog.', 'wpmudev_vids' ),
				'go_back'  => __( 'Go back to previous slide.', 'wpmudev_vids' ),
				'continue' => __( 'Continue', 'wpmudev_vids' ),
				'cancel'   => __( 'Cancel', 'wpmudev_vids' ),
			),
			'notices' => array(
				'dismiss'            => __( 'Dismiss this notice', 'wpmudev_vids' ),
				'shortcode_copied'   => __( 'Shortcode has been copied successfully.', 'wpmudev_vids' ),
				'membership_expired' => __( 'WPMU DEV Videos are locked. To continue displaying WPMU DEV\'s white label tutorial videos to your customers, renew your membership today.', 'wpmudev_vids' ),
				'get_access'         => __( 'WPMU DEV Videos are locked due to your current membership status. You can unlock WPMU DEV white-labeled video tutorials by activating a full membership. Click the button below for more information on the WPMU DEV pricing structure.', 'wpmudev_vids' ),
				'install_dash'       => __( 'WPMU DEV videos are locked and you only have access to custom videos in Video Tutorials page. Install and log into the plugin to start setting up your video tutorials.', 'wpmudev_vids' ),
				'activate_dash'      => __( 'WPMU DEV videos are locked and you only have access to custom videos in Video Tutorials page. Activate and log into the plugin to start setting up your video tutorials.', 'wpmudev_vids' ),
				'login_dash'         => __( 'WPMU DEV videos are locked and you only have access to custom videos in Video Tutorials page. Log into the plugin to begin setting up your video tutorials.', 'wpmudev_vids' ),
			),
			'header'  => array(
				'doc' => __( 'View Documentation', 'wpmudev_vids' ),
			),
			'footer'  => array(
				'hub'       => __( 'The Hub', 'wpmudev_vids' ),
				'plugins'   => __( 'Plugins', 'wpmudev_vids' ),
				'roadmap'   => __( 'Roadmap', 'wpmudev_vids' ),
				'support'   => __( 'Support', 'wpmudev_vids' ),
				'docs'      => __( 'Docs', 'wpmudev_vids' ),
				'community' => __( 'Community', 'wpmudev_vids' ),
				'academy'   => __( 'Academy', 'wpmudev_vids' ),
				'tos'       => __( 'Terms of Service', 'wpmudev_vids' ),
				'privacy'   => __( 'Privacy Policy', 'wpmudev_vids' ),
				'facebook'  => __( 'Facebook', 'wpmudev_vids' ),
				'twitter'   => __( 'Twitter', 'wpmudev_vids' ),
				'instagram' => __( 'Instagram', 'wpmudev_vids' ),
			),
			'labels'  => array(
				'dismiss'          => __( 'Dismiss', 'wpmudev_vids' ),
				'plugin_name'      => __( 'WPMU DEV Videos', 'wpmudev_vids' ),
				'add_custom_video' => __( 'Add Custom Video', 'wpmudev_vids' ),
				'upload_thumb'     => __( 'Upload thumbnail', 'wpmudev_vids' ),
				'select_item'      => __( 'Select item', 'wpmudev_vids' ),
				'remove_file'      => __( 'Remove file', 'wpmudev_vids' ),
				'administrator'    => __( 'Administrator', 'wpmudev_vids' ),
				'super_admin'      => __( 'Super Admin', 'wpmudev_vids' ),
				'go_to_top'        => __( 'Go to top', 'wpmudev_vids' ),
			),
			'buttons' => array(
				'clear'            => __( 'Clear', 'wpmudev_vids' ),
				'cancel'           => __( 'Cancel', 'wpmudev_vids' ),
				'upload_image'     => __( 'Upload image', 'wpmudev_vids' ),
				'set_as_thumbnail' => __( 'Set as thumbnail', 'wpmudev_vids' ),
				'delete'           => __( 'Delete', 'wpmudev_vids' ),
				'deleting'         => __( 'Deleting', 'wpmudev_vids' ),
				'edit'             => __( 'Edit', 'wpmudev_vids' ),
				'apply'            => __( 'Apply', 'wpmudev_vids' ),
				'renew_membership' => __( 'Renew Membership', 'wpmudev_vids' ),
				'get_access'       => __( 'Get Full Membership', 'wpmudev_vids' ),
				'install_dash'     => __( 'Install Plugin', 'wpmudev_vids' ),
				'login_dash'       => __( 'Login', 'wpmudev_vids' ),
				'activate_dash'    => __( 'Activate Plugin', 'wpmudev_vids' ),
				'save_changes'     => __( 'Save Changes', 'wpmudev_vids' ),
				'saving_changes'   => __( 'Saving Changes', 'wpmudev_vids' ),
				'remove'           => __( 'Remove', 'wpmudev_vids' ),
				'add'              => __( 'Add', 'wpmudev_vids' ),
				'added'            => __( 'Added', 'wpmudev_vids' ),
				'close_video'      => __( 'Close video', 'wpmudev_vids' ),
				'click_to_open'    => __( 'Click to open', 'wpmudev_vids' ),
				'processing'       => __( 'Processing', 'wpmudev_vids' ),
				'close_region'     => __( 'Close this region', 'wpmudev_vids' ),
				'search'           => __( 'Search', 'wpmudev_vids' ),
				'searching'        => __( 'Searching', 'wpmudev_vids' ),
				'clear_search'     => __( 'Clear search', 'wpmudev_vids' ),
				'back'             => __( 'Back', 'wpmudev_vids' ),
			),
		);
	}

	/**
	 * Get the localization vars for the dashboard page.
	 *
	 * This data will be only available in dashboard scripts.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function dashboard() {
		return array(
			'titles'       => array(
				'dashboard'     => __( 'Dashboard', 'wpmudev_vids' ),
				'videos'        => __( 'Videos', 'wpmudev_vids' ),
				'playlists'     => __( 'Playlists', 'wpmudev_vids' ),
				'activate_dash' => __( 'Login to WPMU DEV Dashboard', 'wpmudev_vids' ),
				'install_dash'  => __( 'Install WPMU DEV Dashboard', 'wpmudev_vids' ),
				'highlights'    => __( 'New! Playlist Reordering', 'wpmudev_vids' ),
			),
			'labels'       => array(
				'install_dash'              => __( 'Install WPMU DEV Dashboard', 'wpmudev_vids' ),
				'login_dash'                => __( 'Login to WPMU DEV Dashboard', 'wpmudev_vids' ),
				'activate_dash'             => __( 'Activate WPMU DEV Dashboard', 'wpmudev_vids' ),
				'expired_account'           => __( 'Membership Expired', 'wpmudev_vids' ),
				'get_access'                => __( 'Get Integrated Video Tutorial Access', 'wpmudev_vids' ),
				'never'                     => __( 'Never', 'wpmudev_vids' ),
				'total_videos'              => __( 'Total videos', 'wpmudev_vids' ),
				'last_uploaded'             => __( 'Last uploaded video', 'wpmudev_vids' ),
				'recently_updated'          => __( 'Recently updated video', 'wpmudev_vids' ),
				'recently_added_videos'     => __( 'Recently added videos', 'wpmudev_vids' ),
				'recently_added_playlists'  => __( 'Recently added playlists', 'wpmudev_vids' ),
				'recently_created_custom'   => __( 'Recently created custom video', 'wpmudev_vids' ),
				'recently_created_playlist' => __( 'Recently created playlist', 'wpmudev_vids' ),
				'actions'                   => __( 'Actions', 'wpmudev_vids' ),
				'videos_options_menu'       => __( 'Video options menu', 'wpmudev_vids' ),
				'playlists_options_menu'    => __( 'Playlist options menu', 'wpmudev_vids' ),
				'playlist_feature'          => __( 'Create Video Playlists', 'wpmudev_vids' ),
				'visibility_config'         => __( 'Control Visibility', 'wpmudev_vids' ),
			),
			'buttons'      => array(
				'install_dash'        => __( 'Install Plugin', 'wpmudev_vids' ),
				'login_dash'          => __( 'Login', 'wpmudev_vids' ),
				'activate_dash'       => __( 'Activate Plugin', 'wpmudev_vids' ),
				'expired_account'     => __( 'Renew Membership', 'wpmudev_vids' ),
				'get_access'          => __( 'Get Full Membership', 'wpmudev_vids' ),
				'view_all'            => __( 'View All', 'wpmudev_vids' ),
				'add_custom_videos'   => __( 'Add Custom Video', 'wpmudev_vids' ),
				'add_playlist'        => __( 'Add Playlist', 'wpmudev_vids' ),
				'refresh_status'      => __( 'Refresh Status', 'wpmudev_vids' ),
				'refreshing_status'   => __( 'Refreshing Status', 'wpmudev_vids' ),
				'edit_title'          => __( 'Edit title', 'wpmudev_vids' ),
				'edit_video'          => __( 'Edit video', 'wpmudev_vids' ),
				'copy_shortcode'      => __( 'Copy Shortcode', 'wpmudev_vids' ),
				'add_to_playlist'     => __( 'Add to Playlist', 'wpmudev_vids' ),
				'visibility_settings' => __( 'Visibility settings', 'wpmudev_vids' ),
				'add_videos'          => __( 'Add videos', 'wpmudev_vids' ),
				'got_it'              => __( 'Got it', 'wpmudev_vids' ),
			),
			'notices'      => array(),
			'descriptions' => array(
				/* translators: %s: Name of the current user. */
				'install_dash'         => __( '%s, welcome to Integrated Video Tutorials - the best tutorials plugin for WordPress. It looks like you don\'t have the WPMU DEV Dashboard plugin installed, which you\'ll need to access the videos API. Install and log into the plugin to start setting up your video tutorials.', 'wpmudev_vids' ),
				/* translators: %s: Name of the current user. */
				'login_dash'           => __( '%s, welcome to Integrated Video Tutorials - the best tutorials plugin for WordPress. It looks like you haven\'t logged into the WPMU DEV Dashboard plugin, which you\'ll need to do to access the videos API. Log into the plugin to begin setting up your video tutorials.', 'wpmudev_vids' ),
				/* translators: %s: Name of the current user. */
				'activate_dash'        => __( 'Great, %s! The WPMU DEV Dashboard plugin is installed, but not activated yet. You\'ll need to activate it to access our videos API and set up your video tutorials.', 'wpmudev_vids' ),
				/* translators: %s: Name of the current user. */
				'expired_account'      => __( '%s, welcome to Integrated Video Tutorials - the best video tutorials plugin for WordPress. It looks like your WPMU DEV subscription has expired. To continue displaying WPMU DEV\'s white label tutorial videos to your users, renew your membership today.', 'wpmudev_vids' ),
				/* translators: %s: Name of the current user. */
				'get_access'           => __( 'Hey %s, it looks like you don\'t have access to the WPMU DEV white-labeled video tutorials due to your current membership status. You can gain access by activating a full membership. Click the button below for more information on the WPMU DEV pricing structure.', 'wpmudev_vids' ),
				'banner_install_dash'  => __( 'You don\'t have the WPMU DEV Dashboard plugin, which you\'ll need to access the videos API. WPMU DEV videos are locked, and you only have access to custom videos on the Video Tutorials page. Install and log in to the dashboard to unlock the complete library of WPMU DEV video tutorials.', 'wpmudev_vids' ),
				'banner_login_dash'    => __( 'You haven\'t logged into the WPMU DEV Dashboard plugin installed, which you\'ll need to access the videos API. WPMU DEV videos are locked, and you only have access to custom videos on the Video Tutorials page. Log into the WPMU DEV dashboard to unlock the complete library of WPMU DEV video tutorials.', 'wpmudev_vids' ),
				'banner_activate_dash' => __( 'The WPMU DEV Dashboard plugin is installed but not activated. Activate the plugin to unlock the complete library of WPMU DEV video tutorials.', 'wpmudev_vids' ),
				'videos'               => __( 'View all default video tutorials and upload your own custom videos in the Videos area.', 'wpmudev_vids' ),
				'playlists'            => __( 'Create playlists of videos and display them around your WordPress Admin area to help your clients get to know WordPress.', 'wpmudev_vids' ),
				'highlights'           => __( 'You can now reorder playlists using a simple drag-and-drop feature. If you have ever been tired of always scrolling down to the bottom of the page to find your favorite videos, this new feature will save you a lot of time and energy.', 'wpmudev_vids' ),
				'playlist_feature'     => __( 'You can now add videos to custom groups and then display those groups in different places around your website. This allows you to display specific video tutorials to your clients where they need it most.', 'wpmudev_vids' ),
				'visibility_config'    => __( "We've given you greater control over where your videos appear, but also who can see them too. Specify different sets of videos to display to different user roles – a complete custom set up tailored to your needs!", 'wpmudev_vids' ),
			),
		);
	}

	/**
	 * Get the localization vars for the videos page.
	 *
	 * This data will be only available in videos scripts.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function videos() {
		return array(
			'titles'       => array(
				'videos'           => __( 'Videos', 'wpmudev_vids' ),
				'available_videos' => __( 'Available Videos', 'wpmudev_vids' ),
			),
			'labels'       => array(
				'recently_updated'    => __( 'Recently updated video', 'wpmudev_vids' ),
				'recent_host'         => __( 'Recent video host', 'wpmudev_vids' ),
				'recent_custom_video' => __( 'Recent custom video', 'wpmudev_vids' ),
				'never'               => __( 'Never', 'wpmudev_vids' ),
				'video_title'         => __( 'Video title', 'wpmudev_vids' ),
				'duration'            => __( 'Duration', 'wpmudev_vids' ),
				'delete_video'        => __( 'Delete video', 'wpmudev_vids' ),
				'edit_video'          => __( 'Edit video', 'wpmudev_vids' ),
				'video_actions'       => __( 'Video actions', 'wpmudev_vids' ),
				'add_to_playlist'     => __( 'Add to playlist', 'wpmudev_vids' ),
				'video_url'           => __( 'Video URL', 'wpmudev_vids' ),
				/* translators: %s: Duration of the video. */
				'video_duration'      => __( 'Duration %s', 'wpmudev_vids' ),
				'end_at'              => __( 'End at:', 'wpmudev_vids' ),
				'start_at'            => __( 'Start at:', 'wpmudev_vids' ),
				'settings'            => __( 'Settings', 'wpmudev_vids' ),
				'thumbnail_image'     => __( 'Thumbnail image', 'wpmudev_vids' ),
				'add_custom_video'    => __( 'Add Custom Video', 'wpmudev_vids' ),
				'choose_playlist'     => __( 'Choose playlist', 'wpmudev_vids' ),
				'search_videos'       => __( 'Search videos', 'wpmudev_vids' ),
				'empty_search'        => __( 'Empty results', 'wpmudev_vids' ),
				'loading'             => __( 'Loading...', 'wpmudev_vids' ),
				'unknown'             => __( 'Unknown', 'wpmudev_vids' ),
			),
			'buttons'      => array(
				'watch'              => __( 'Watch Videos', 'wpmudev_vids' ),
				'add_playlist'       => __( 'Add Playlist', 'wpmudev_vids' ),
				'add_custom_video'   => __( 'Add Custom Video', 'wpmudev_vids' ),
				'saving_changes'     => __( 'Saving Changes', 'wpmudev_vids' ),
				'edit_title'         => __( 'Edit title', 'wpmudev_vids' ),
				'edit_video'         => __( 'Edit video', 'wpmudev_vids' ),
				'delete_video'       => __( 'Delete', 'wpmudev_vids' ),
				'deleting_video'     => __( 'Deleting', 'wpmudev_vids' ),
				'copy_shortcode'     => __( 'Copy Shortcode', 'wpmudev_vids' ),
				'add_to_playlist'    => __( 'Add to Playlist', 'wpmudev_vids' ),
				'adding_to_playlist' => __( 'Updating playlist', 'wpmudev_vids' ),
				'add_video'          => __( 'Add Video', 'wpmudev_vids' ),
				'adding_video'       => __( 'Adding', 'wpmudev_vids' ),
				'publish'            => __( 'Publish', 'wpmudev_vids' ),
				'publishing'         => __( 'Publishing', 'wpmudev_vids' ),
			),
			'descriptions' => array(
				'videos'              => __( 'Add, edit and view video tutorials all in one handy place.', 'wpmudev_vids' ),
				'change_title'        => __( 'Change the title of the video below.', 'wpmudev_vids' ),
				/* translators: %s: Title of the video. */
				'add_to_playlist'     => __( 'Choose which playlists you want to add the "%s" video to. It will be available for people to watch if they can access the playlist.', 'wpmudev_vids' ),
				'delete_video'        => __( 'Are you sure you want to permanently delete this custom video?', 'wpmudev_vids' ),
				'customize_duration'  => __( 'Customize the duration of the video.', 'wpmudev_vids' ),
				'customize_thumbnail' => __( 'Add a custom thumbnail to your video.', 'wpmudev_vids' ),
				'add_custom_video'    => __( 'Link to custom videos you\'ve found, or uploaded on another video host. Choose from the available hosts below.', 'wpmudev_vids' ),
				'copy_paste_url'      => __( 'Copy and paste the video URL from your browser into the input field below.', 'wpmudev_vids' ),
				'assign_playlist'     => __( 'To finish adding this video, assign it to a playlist.', 'wpmudev_vids' ),
				/* translators: %s: Search term. */
				'empty_search'        => __( 'We couldn\'t find any videos matching your search <strong>“%s”</strong>. Please try again', 'wpmudev_vids' ),
				'import_confirm'      => __( 'Below are configurations and data found in the selected file', 'wpmudev_vids' ),
			),
			'notices'      => array(
				'shortcode_copied'            => __( 'Shortcode has been copied successfully.', 'wpmudev_vids' ),
				/* translators: %s: Title of the video. */
				'video_playlist_updated'      => __( 'Playlists of "%s" was successfully updated.', 'wpmudev_vids' ),
				/* translators: %s: Title of the video. */
				'video_title_updated'         => __( 'Video title is changed to “%s”.', 'wpmudev_vids' ),
				'video_title_update_failed'   => __( 'Sorry. Could not update the video title.', 'wpmudev_vids' ),
				'invalid_url_attached'        => __( 'The URL you have attached is invalid. Try again by copying the URL from your browser and pasting it into the input field below.', 'wpmudev_vids' ),
				'error_publishing'            => __( 'There was an error publishing the video. Please try again.', 'wpmudev_vids' ),
				/* translators: %s: Title of the video. */
				'video_updated'               => __( '“%s” updated successfully.', 'wpmudev_vids' ),
				/* translators: %s: Title of the video. */
				'video_update_failed'         => __( 'Updating “%s” failed.', 'wpmudev_vids' ),
				/* translators: %s: Title of the video. */
				'video_published'             => __( 'Custom video added successfully. You can <a href="%s">view the video</a> on the Video Tutorials page.', 'wpmudev_vids' ),
				'video_published_wo_playlist' => __( 'Custom video added successfully. Assign it to a playlist so the video becomes available on the Video Tutorials page.', 'wpmudev_vids' ),
				'video_deleted'               => __( 'Video deleted successfully.', 'wpmudev_vids' ),
				/* translators: %s: No. of videos found in search. */
				'search_results'              => __( 'We found %s videos for your search.', 'wpmudev_vids' ),
				'search_cleared'              => __( 'Search cleared successfully.', 'wpmudev_vids' ),
				'select_one_playlist'         => __( 'Note: We recommend adding your custom video to an existing playlist so it\'s available on the Video Tutorials page.', 'wpmudev_vids' ),
			),
		);
	}

	/**
	 * Get the localization vars for the playlists page.
	 *
	 * This data will be only available in playlists scripts.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function playlists() {
		return array(
			'titles'       => array(
				'playlists'           => __( 'Playlists', 'wpmudev_vids' ),
				'available_videos'    => __( 'Available Videos', 'wpmudev_vids' ),
				'visibility_settings' => __( 'Visibility settings', 'wpmudev_vids' ),
				'add_videos'          => __( 'Add videos', 'wpmudev_vids' ),
			),
			'labels'       => array(
				'recently_created'     => __( 'Recently created playlist', 'wpmudev_vids' ),
				'recently_updated'     => __( 'Recently updated playlist', 'wpmudev_vids' ),
				'never'                => __( 'Never', 'wpmudev_vids' ),
				'video_title'          => __( 'Video title', 'wpmudev_vids' ),
				'date_added'           => __( 'Date added', 'wpmudev_vids' ),
				'bulk_actions'         => __( 'Bulk actions', 'wpmudev_vids' ),
				'delete_playlist'      => __( 'Delete playlist', 'wpmudev_vids' ),
				'permissions'          => __( 'Permissions', 'wpmudev_vids' ),
				'location'             => __( 'Location', 'wpmudev_vids' ),
				'choose_location'      => __( 'Choose WP Admin pages', 'wpmudev_vids' ),
				'edit_playlist'        => __( 'Edit Playlist', 'wpmudev_vids' ),
				'playlist_name'        => __( 'Playlist name', 'wpmudev_vids' ),
				'playlist_desc'        => __( 'Playlist description', 'wpmudev_vids' ),
				'playlist_thumbnail'   => __( 'Playlist thumbnail image', 'wpmudev_vids' ),
				'placeholder_name'     => __( 'E.g. New playlist', 'wpmudev_vids' ),
				'create_playlist'      => __( 'Create a new playlist', 'wpmudev_vids' ),
				'search_videos'        => __( 'Search videos', 'wpmudev_vids' ),
				'videos'               => __( 'Videos', 'wpmudev_vids' ),
				/* translators: %s: Count of videos. */
				'videos_selected'      => __( '%s videos selected', 'wpmudev_vids' ),
				'row_actions'          => __( 'Row actions', 'wpmudev_vids' ),
				'loading'              => __( 'Loading...', 'wpmudev_vids' ),
				'remove_from_playlist' => __( 'Remove video from playlist', 'wpmudev_vids' ),
			),
			'buttons'      => array(
				'add_playlist'        => __( 'Add Playlist', 'wpmudev_vids' ),
				'create_playlist'     => __( 'Create Playlist', 'wpmudev_vids' ),
				'creating_playlist'   => __( 'Creating Playlist', 'wpmudev_vids' ),
				'playlist_actions'    => __( 'Open playlist actions', 'wpmudev_vids' ),
				'add_videos'          => __( 'Add videos', 'wpmudev_vids' ),
				'visibility_settings' => __( 'Visibility settings', 'wpmudev_vids' ),
				'copy_shortcode'      => __( 'Copy shortcode', 'wpmudev_vids' ),
				'add_video'           => __( 'Add Video', 'wpmudev_vids' ),
				'adding_videos'       => __( 'Adding Videos', 'wpmudev_vids' ),
			),
			'descriptions' => array(
				/* translators: %s: Count of videos. */
				'delete_playlist'     => __( 'This playlist contains %d video(s). These videos will be unassigned from this playlist. Are you sure you want to delete this playlist?', 'wpmudev_vids' ),
				'playlists'           => __( 'Playlists are groups of similar videos you can embed around WordPress for your clients to watch when needed. Add your first playlist by clicking the button below.', 'wpmudev_vids' ),
				'visibility_settings' => __( 'Control which user roles are able to see this playlist, in addition to where it will be displayed as an available WordPress widget', 'wpmudev_vids' ),
				'permissions'         => __( 'Choose which user roles will be able to view this playlist.', 'wpmudev_vids' ),
				'location'            => __( 'Choose which default locations will show this video playlist to the user roles selected above.', 'wpmudev_vids' ),
				'playlist_title'      => __( 'Give a title to your playlist.', 'wpmudev_vids' ),
				'playlist_desc'       => __( 'You can add description to your playlist.', 'wpmudev_vids' ),
				'playlist_thumbnail'  => __( 'Add a custom thumbnail to your playlist, otherwise we\'ll just use the first video\'s thumbnail.', 'wpmudev_vids' ),
				'create_playlist'     => __( 'Choose a title, description and custom thumbnail for your playlist and then start adding videos to it.', 'wpmudev_vids' ),
				'select_videos'       => __( 'Choose which videos you want to assign to this playlist. You can add as many as you like.', 'wpmudev_vids' ),
				'no_videos'           => __( 'No videos assigned.', 'wpmudev_vids' ),
			),
			'notices'      => array(
				'playlist_created'                => __( 'Playlist created successfully.', 'wpmudev_vids' ),
				'playlist_create_failed'          => __( 'Could not create the playlist. Please try again.', 'wpmudev_vids' ),
				/* translators: %s: Playlist title. */
				'playlist_updated'                => __( 'Playlist “%s” updated successfully.', 'wpmudev_vids' ),
				/* translators: %s: Playlist title. */
				'playlist_update_failed'          => __( 'Updating playlist “%s” failed..', 'wpmudev_vids' ),
				'playlist_deleted'                => __( 'Playlist deleted successfully.', 'wpmudev_vids' ),
				'playlist_settings_updated'       => __( 'Playlist settings updated successfully.', 'wpmudev_vids' ),
				'playlist_settings_update_failed' => __( 'Playlist settings update failed.', 'wpmudev_vids' ),
				/* translators: %s: Link to the videos page. */
				'default_videos_not_available'    => __( 'You don\'t have any custom videos available to add to this playlist. To unlock WPMU DEV tutorial videos you\'ll need to renew your membership. Note: You can still <a href="%s">create and add custom videos</a> to this playlist.', 'wpmudev_vids' ),
				'get_access'                      => __( 'You don\'t have any custom videos available to add to this playlist. You can unlock WPMU DEV white-labeled video tutorials by activating a full membership. Click the button below for more information on the WPMU DEV pricing structure.', 'wpmudev_vids' ),
				'install_plugin'                  => __( 'WPMU DEV videos are locked, and you only have access to custom videos because the WPMU DEV Dashboard plugin is not installed. Install and log into the WPMU DEV dashboard plugin to unlock the complete library of WPMU DEV video tutorials.', 'wpmudev_vids' ),
				'login_plugin'                    => __( 'WPMU DEV videos are locked, and you only have access to custom videos because you haven\'t logged into the WPMU DEV Dashboard plugin. Log into the WPMU DEV dashboard plugin to unlock the complete library of WPMU DEV video tutorials.', 'wpmudev_vids' ),
				'activate_plugin'                 => __( 'WPMU DEV videos are locked, and you only have access to custom videos because the WPMU DEV Dashboard plugin is not active. Activate the WPMU DEV dashboard plugin to unlock the complete library of WPMU DEV video tutorials.', 'wpmudev_vids' ),
				'playlist_videos_updated'         => __( 'Playlist videos updated successfully.', 'wpmudev_vids' ),
				/* translators: %s: Link to the videos page. */
				'create_custom_videos'            => __( '<strong>Note:</strong> You can still <a href="%s">create and add custom videos</a> to this playlist.', 'wpmudev_vids' ),
				'playlist_videos_update_failed'   => __( 'Could not update the playlist videos. Please try again.', 'wpmudev_vids' ),
				/* translators: %s: Link to the settings page. */
				'enable_contextual_help'          => __( 'To configure locations for this playlist, please enable the <a href="%s">Add Videos to Contextual Help</a> feature on the Settings page.', 'wpmudev_vids' ),
			),
		);
	}

	/**
	 * Get the localization vars for the settings page.
	 *
	 * This data will be only available in settings scripts.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function settings() {
		return array(
			'titles'       => array(
				'settings'         => __( 'Settings', 'wpmudev_vids' ),
				'display_settings' => __( 'Display Settings', 'wpmudev_vids' ),
				'permissions'      => __( 'Permissions', 'wpmudev_vids' ),
				'import_export'    => __( 'Import / Export', 'wpmudev_vids' ),
				'data'             => __( 'Data', 'wpmudev_vids' ),
				'import'           => __( 'Import', 'wpmudev_vids' ),
				'reset_plugin'     => __( 'Reset Plugin', 'wpmudev_vids' ),
			),
			'labels'       => array(
				'tutorials'             => __( 'Video Tutorials', 'wpmudev_vids' ),
				'tutorials_tab'         => __( 'Tutorials Tab', 'wpmudev_vids' ),
				'most_viewed'           => __( 'Most viewed playlist', 'wpmudev_vids' ),
				'never'                 => __( 'Never', 'wpmudev_vids' ),
				'contextual_help'       => __( 'Add Videos to Contextual Help', 'wpmudev_vids' ),
				'help_videos'           => __( 'Help Videos', 'wpmudev_vids' ),
				'location'              => __( 'Choose the location of the videos page in the admin menu.', 'wpmudev_vids' ),
				'user_permissions'      => __( 'User Permissions', 'wpmudev_vids' ),
				'user_roles'            => __( 'User Roles', 'wpmudev_vids' ),
				'administrator'         => __( 'Administrator', 'wpmudev_vids' ),
				'network_administrator' => __( 'Network Administrator', 'wpmudev_vids' ),
				'import'                => __( 'Import', 'wpmudev_vids' ),
				'export'                => __( 'Export', 'wpmudev_vids' ),
				'data'                  => __( 'Data', 'wpmudev_vids' ),
				'uninstallation'        => __( 'Uninstallation', 'wpmudev_vids' ),
				'reset_settings'        => __( 'Reset Settings', 'wpmudev_vids' ),
				'preserve'              => __( 'Preserve', 'wpmudev_vids' ),
				'reset'                 => __( 'Reset', 'wpmudev_vids' ),
				'keep'                  => __( 'Keep', 'wpmudev_vids' ),
				'remove'                => __( 'Remove', 'wpmudev_vids' ),
				'import_config'         => __( 'Import Configurations', 'wpmudev_vids' ),
				'export_config'         => __( 'Export Configurations', 'wpmudev_vids' ),
				'choose_export'         => __( 'Choose export options', 'wpmudev_vids' ),
				'export_thumb'          => __( 'Export thumbnails', 'wpmudev_vids' ),
				'include_thumb'         => __( 'Include video and playlist thumbnails in export.', 'wpmudev_vids' ),
				'videos'                => __( 'Videos', 'wpmudev_vids' ),
				'playlists'             => __( 'Playlists', 'wpmudev_vids' ),
				'all'                   => __( 'All', 'wpmudev_vids' ),
				'import_thumb'          => __( 'Import thumbnails', 'wpmudev_vids' ),
				'import_progress'       => __( 'Importing in progress...', 'wpmudev_vids' ),
				'export_options'        => __( 'Choose export options', 'wpmudev_vids' ),
				'import_help'           => __( 'Include video and playlist thumbnails', 'wpmudev_vids' ),
			),
			'buttons'      => array(
				'save'                => __( 'Save Changes', 'wpmudev_vids' ),
				'saving'              => __( 'Saving Changes', 'wpmudev_vids' ),
				'reset'               => __( 'Reset', 'wpmudev_vids' ),
				'resetting'           => __( 'Resetting', 'wpmudev_vids' ),
				'upload_file'         => __( 'Upload file', 'wpmudev_vids' ),
				'remove_file'         => __( 'Remove file', 'wpmudev_vids' ),
				'export'              => __( 'Export', 'wpmudev_vids' ),
				'import'              => __( 'Import', 'wpmudev_vids' ),
				'importing'           => __( 'Importing', 'wpmudev_vids' ),
				'exporting'           => __( 'Exporting', 'wpmudev_vids' ),
				'continue_background' => __( 'Continue in background', 'wpmudev_vids' ),
			),
			'notices'      => array(
				'changes_saved'       => __( 'Changes were saved successfully.', 'wpmudev_vids' ),
				'changes_save_failed' => __( 'Sorry. Could not save the changes. Please try again.', 'wpmudev_vids' ),
				'import_success'      => __( 'Settings successfully imported and configured.', 'wpmudev_vids' ),
				'import_warning'      => __( 'Note: The selected configurations and data above will replace your current settings and data.', 'wpmudev_vids' ),
			),
			'descriptions' => array(
				'tutorials_tab'         => __( 'Customize the default "Video Tutorials" tab title and position in the WordPress Admin menu.', 'wpmudev_vids' ),
				'wp_sidebar'            => __( 'Show the tutorials tab in the WP Admin sidebar', 'wpmudev_vids' ),
				'help_videos'           => __( 'This will add the appropriate video tutorials to the help dropdowns on WordPress admin screens.', 'wpmudev_vids' ),
				'user_permissions'      => __( 'Configure which user roles can access and configure plugin’s settings.', 'wpmudev_vids' ),
				'user_roles'            => __( 'Choose which user roles can have access and configure Integrated Video Tutorials.', 'wpmudev_vids' ),
				'import'                => __( 'Use this tool to import the Integrated Video Tutorial configurations and data from another site.', 'wpmudev_vids' ),
				'export'                => __( 'Use this tool to export the IVT configurations and data to another site.', 'wpmudev_vids' ),
				'data'                  => __( 'Control what to do with your settings and data. Data includes Videos, Playlists, and other pieces of information stored over time.', 'wpmudev_vids' ),
				'uninstallation'        => __( 'When you uninstall this plugin, what do you want to do with your settings and stored data?', 'wpmudev_vids' ),
				'reset_settings'        => __( 'Needing to start fresh? Use this button to roll back to the default settings.', 'wpmudev_vids' ),
				'data_settings'         => __( 'Choose whether to save your settings for next time, or reset them.', 'wpmudev_vids' ),
				'data_data'             => __( 'Choose whether to keep or remove Videos and Playlists data.', 'wpmudev_vids' ),
				'reset_settings_data'   => __( 'Note: This will instantly revert all settings to their default states but will leave your data intact.', 'wpmudev_vids' ),
				'import_config'         => __( 'Import an Integrated Video Tutorial configuration and data file.', 'wpmudev_vids' ),
				'import_config_json'    => __( 'Choose a JSON (.json) file to import the configurations.', 'wpmudev_vids' ),
				'choose_export'         => __( 'Select configurations or data to export or check All to export all settings.', 'wpmudev_vids' ),
				'import_modal'          => __( 'To continue, select the configuration data to import below and click the import button to begin.', 'wpmudev_vids' ),
				'import_modal_progress' => __( 'Your import is in progress. Downloading thumbnails might take a bit longer depending on the file sizes and volume. Feel free to close this modal as your import will continue running in the background.', 'wpmudev_vids' ),
				'reset_plugin'          => __( 'Are you sure you want to reset the plugin to its default state?', 'wpmudev_vids' ),
				'export_options'        => __( 'Select configurations or data to export or check All to export all settings.', 'wpmudev_vids' ),
			),
		);
	}

	/**
	 * Get the localization vars for the video tutorials page.
	 *
	 * This data will be only available in tutorials scripts.
	 *
	 * @since 1.8.0
	 *
	 * @return array
	 */
	public function tutorials() {
		return array(
			'titles'       => array(
				'videos' => __( 'Video Tutorials', 'wpmudev_vids' ),
			),
			'labels'       => array(
				'search' => __( 'Search videos', 'wpmudev_vids' ),
			),
			'notices'      => array(
				/* translators: %s: No. of vidoes found in search. */
				'search_results' => __( 'We found %s videos for your search.', 'wpmudev_vids' ),
				'search_cleared' => __( 'Search cleared successfully.', 'wpmudev_vids' ),
			),
			'descriptions' => array(
				'videos' => __( 'Use these in-depth video tutorials to master all aspects of the WordPress platform.', 'wpmudev_vids' ),
			),
		);
	}
}