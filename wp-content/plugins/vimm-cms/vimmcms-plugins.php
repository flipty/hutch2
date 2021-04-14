<?php
/**
 * This will display the plugins in json format so CIS can view what's activate and deactive
 *
 * @since 08/20/2014
 * @author Tyler Steinhaus
 */

class vimmcms_plugins {

	/**
	 * Constructor
	 * Builds everything for vimmcms to deliver the plugins
	 *
	 * @since 08/20/2014
	 * @author Tyler Steinhaus
	 */
	function __construct() {
		add_action( 'init', array( $this, 'rewriteRulesExist' ) );
		add_filter( 'query_vars', array( $this, 'addQueryVars' ) );
		add_filter( 'rewrite_rules_array', array( $this, 'addRewriteRules' ) );
		add_action( 'parse_query', array( $this, 'pluginsListPage' ), 9999 );
	}

	/**
	 * Plugin List Page
	 * This will check to see if the url rewrite values are correct,
	 * if they are it will fire the page and exit before anything else loads
	 *
	 * @since 08/20/2014
	 * @author Tyler Steinhaus
	 */
	function pluginsListPage() {
		global $wp_query;

		// Check if get_plugins() function exists. This is required on the front end of the
		// site, since it is in a file that is normally only loaded in the admin.
		if( $wp_query->query_vars['vividimagecms'] == 'true' && $wp_query->query_vars['token'] = '324434d16981a0074c98cfbbe0872d89' ) {
			if ( ! function_exists( 'get_plugins' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$all_plugins = get_plugins();
			foreach( $all_plugins as $plugin => $value ) {
				if( is_plugin_active( $plugin ) != true ) {
					unset( $all_plugins[$plugin] );
				}
			}

			wp_send_json( $all_plugins );
			exit();
		}
	}

	/**
	 * Add the query vars for getting the plugin list to Wordpress
	 *
	 * @since 08/20/2014
	 * @author Tyler Steinhaus
	 *
	 * @param array $vars returns all query vars
	 *
	 * @return array $vars returns all existing and new query vars
	 */
	function addQueryVars( $vars ) {
		$vars[] = 'token';
		$vars[] = 'vividimagecms';

		return $vars;
	}

	/**
	 * Build a new rewrite rule specifically for us to use to get the plugin list
	 *
	 * @since 08/20/2014
	 * @author Tyler Steinhaus
	 *
	 * @param array $rules all existing rewrite rules
	 *
	 * @return array $rules all new and existing rules
	 */
	function addRewriteRules( $rules ) {
		$new_rules = array( "vividimagecms/(.+)/(.+)/?$" => 'index.php?vividimagecms=$matches[1]&token=$matches[2]' );
		$rules = $new_rules + $rules;

		return $rules;
	}

	/**
	 * Check to see if our rewrite rules exist, if not run generate_rewrite_rules
	 *
	 * @since 08/20/2014
	 * @author Tyler Steinhaus
	 *
	 * @param array $rules all existing rewrite rules
	 */
	function rewriteRulesExist( $rules ) {


	}
}
