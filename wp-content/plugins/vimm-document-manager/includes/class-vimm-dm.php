<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Vimm_DM
 * @subpackage Vimm_DM/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Vimm_DM
 * @subpackage Vimm_DM/includes
 * @author     Your Name <email@example.com>
 */
class Vimm_DM {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Vimm_DM_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'vimm-dm';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_cpt_hooks();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Plugin_Name_Loader. Orchestrates the hooks of the plugin.
	 * - Plugin_Name_i18n. Defines internationalization functionality.
	 * - Plugin_Name_Admin. Defines all hooks for the admin area.
	 * - Plugin_Name_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vimm-dm-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-vimm-dm-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-vimm-dm-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-vimm-dm-public.php';

		
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'cpt/class-vimm-dm-cpt.php';

		//check to see if ACT is alredy installed on this site if so don't hide the menu
		if( class_exists('acf') ) {
			$this->ACF_exists = TRUE;
		} else {
			$this->ACF_exists = FALSE;
			//Include ACF
			require_once plugin_dir_path( dirname( __FILE__ ) ) .  'dep/acf/acf.php';
		}		

		$this->loader = new Vimm_DM_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Vimm_DM_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Vimm_DM_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		
		//tinyMCE buttons
		$this->loader->add_filter( 'mce_buttons', $plugin_admin, 'tinymce_buttons_vidoc');
		$this->loader->add_filter( 'mce_external_plugins', $plugin_admin, 'tinymce_plugin_vidoc');

		$this->loader->add_action( 'wp_ajax_tinymcepopup', $plugin_admin, 'tinymce_popup' );

		//making our meta filed "internal notes" searchable from the dashboard
		//$this->loader->add_filter( 'pre_get_posts', $plugin_admin, 'vi_dm_search_query');

        /** CUSTOM FILTERING SECTION **/

            $this->loader->add_action('restrict_manage_posts', $plugin_admin, 'vi_filter_post_type_by_taxonomy' );
            $this->loader->add_filter('parse_query', $plugin_admin, 'vi_convert_id_to_term_in_query' );

        /** CUSTOM COLUMNS SECTION **/
            // NOTE the action and filter calls have the CPT name in them. this is so these calls only access this custom post type and not standard posts / pages
            //Adds custom columns to the admin panel as w ell as remove default columns
            $this->loader->add_filter( 'manage_vi-doc_posts_columns', $plugin_admin, 'vi_custom_columns_head' );
            //make our custom columns sortable if we want
            $this->loader->add_filter( 'manage_edit-vi-doc_sortable_columns', $plugin_admin, 'vi_custom_sortable_columns_head' );
            //add the content for our custom columns
            $this->loader->add_action( 'manage_vi-doc_posts_custom_column', $plugin_admin, 'vi_custom_columns_content', 10, 2);        
            //if our custom column is sortable we need to run this action to actually filter the page 
            $this->loader->add_action( 'pre_get_posts', $plugin_admin, 'vi_custom_column_orderby' );
	}

	/**
	 * Register all of the hooks related to the custom post type
	 * of the plugin.
	 *
	 * @since    1.0
	 * @access   private
	 */
	private function define_cpt_hooks() {

		$plugin_cpt = new Vimm_DM_CPT( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'init', $plugin_cpt, 'register_custom_post_type');
		$this->loader->add_action( 'init', $plugin_cpt, 'register_custom_post_type_taxonomies' );

		$this->loader->add_filter( 'single_template', $plugin_cpt, 'custom_post_type_template');

		//Force a full width layout for our CPT view
		$this->loader->add_filter( 'genesis_site_layout', $plugin_cpt, 'vidoc_cpt_layout' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Vimm_DM_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		
		//if ACF is already installed let's not mess with things
		if ( $this->ACF_exists == FALSE ) {
			//add ACF
			$this->loader->add_filter( 'acf/settings/path', $plugin_public, 'vimm_dm_acf_settings_path');
			$this->loader->add_filter( 'acf/settings/dir', $plugin_public, 'vimm_dm_acf_settings_dir');

			$this->loader->add_filter( 'acf/settings/show_admin', $plugin_public, 'vimm_dm_acf_menu');
		}

		$this->loader->add_action( 'acf/init', $plugin_public, 'vimm_dm_acf_add_field_groups');
		//END add ACF

		//handle shortcodes for CPT
		$this->loader->add_shortcode( 'vidoc',	$plugin_public, 'vidoc_shortcode' );

		$this->loader->add_action( 'wp_ajax_passwordcheck',  $plugin_public, 'password_check' );
		$this->loader->add_action( 'wp_ajax_nopriv_passwordcheck',  $plugin_public, 'password_check' );

		$this->loader->add_action( 'wp_ajax_addcount', $plugin_public, 'add_download_count' );
		$this->loader->add_action( 'wp_ajax_nopriv_addcount',  $plugin_public, 'add_download_count' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Plugin_Name_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
