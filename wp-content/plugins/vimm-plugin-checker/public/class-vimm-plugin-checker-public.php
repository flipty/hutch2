<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://vimm.com
 * @since      1.0.0
 *
 * @package    Vimm_Plugin_Checker
 * @subpackage Vimm_Plugin_Checker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vimm_Plugin_Checker
 * @subpackage Vimm_Plugin_Checker/public
 * @author     Justin McGuire <justin@vimm.com>
 */
class Vimm_Plugin_Checker_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vimm_Plugin_Checker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vimm_Plugin_Checker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vimm-plugin-checker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vimm_Plugin_Checker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vimm_Plugin_Checker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vimm-plugin-checker-public.js', array( 'jquery' ), $this->version, false );

	}

	public function get_plugin_list() {
		// Check if get_plugins() function exists. This is required on the front end of the
		// site, since it is in a file that is normally only loaded in the admin.

		//Get today's date and appendd it to our verification code as an MD5 Hash
		//this will cause the verification code to change everyday
		$today = date("Ymd");
		$verificationCode = 'rn4XKqEY8SSFDyXxLcDB8SxzYy5T4bymURYRZA3vXVdP3ZYv7dRNDj68vGc5BTPNR5A5DvEnLwa6zYB32jbNaQtAMT3fWkrWE67YQRefkgLxr9v7a87agQuRFkfWSetRw93Axkc2ExtuAKnCM3L6cSaJwjKx4veHMtMQmHDwK3trZYqm4vgFGj4kbgALJ6FWcZTMv56yckFkUTZK6UB6JY4wXHNjDUwxqLyjaBZTCRHRHm43x7VXQ34H2SeZp4tw'.md5($today);

		if ( isset($_GET['randomlongvividimagevariableforcheckingplugins']) && $_GET['randomlongvividimagevariableforcheckingplugins'] == $verificationCode ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}
			//Get all the plugin data
			$all_plugins = get_plugins();
			//Prep our array for sending the a JSON encoded data back
			$JSONArray = array();
			//Loop through each plugin's data
			$i = 0;
			foreach ( $all_plugins as $plugin) {
				foreach ( $plugin as $key => $value ) {
					//We onl care about the plugin name and version so only add those 2 data poitns to
					//our JSON array
					if ( $key == 'Name' ) {
						$pluginName = $value;
					}
					if ( $key == 'Version' ) {
						$JSONArray[$i][$pluginName] = $value;
					}
				}
				$i++;
			}
			//JSON Encode our array
			$JSON = json_encode($JSONArray);
			//Set the Header type and echo our our JSON encoded data
			header('Content-Type: application/json');
			echo $JSON;
			exit;
		}
	}
}
