<?php
/**
 * seo.php - seo class functions
 * Built just for Vivid Image Needs.
 * Any thing that may be used more than once
 * should go here.
 *
 * @since 11/25/2014
 * @author Tyler Steinhaus
 */

if( !class_exists( 'vivid_seo' ) ) {
	class vi_seo {

		/**
		 *	Constructor for SEO 
		 */
		function __construct() {
			// Add Canonical Tag to html head if category has a canonical
			add_action( 'wp_head', array( $this, 'seo_canonical_tags' ) );

			// 301 Redirects
			add_action( 'init', array( $this, 'redirect' ), 1 );
		}

		/**
		 * 301 Redirect for Parked Domains
		 * For Google Analytics doesn't count a user as 2 hits
		 * @since 05/20/2014
		 * @author Tyler Steinhaus
		 *
		 * @param array $domains list domains that are parked
		 */
		function parked_redirect( $domains ) {
			$current_url = parse_url( str_replace( 'www.', '', $_SERVER['HTTP_HOST'] ) );
			if( in_array( $current_url['path'], $domains ) ) {
				ob_start();
				$site_url = home_url();
				header( 'Location: '.$site_url, true, 301 );
				ob_flush();
			}
		}

		/**
		 * Add's canonical tags to the html head if the category has a canonical
		 *
		 * @since 11/19/2014
		 * @author Tyler Steinhaus
		 */
		function seo_canonical_tags() {
			global $post;
			$canonical_tags = genesis_get_option( 'canonical-tags', 'vi-seo' );
			if( !empty( $canonical_tags ) ) {
				foreach( $canonical_tags as $tags ) {
					if( has_term( $tags['cat'], 'category', $post ) && is_single() ) {
						echo '<link rel="canonical" href="'.$tags['url'].'" />';
					}
				}
			}
		}

		/**
		 * redirect function
		 * Read the list of redirects and if the current page
		 * is found in the list, send the visitor on her way
		 *
		 * @added 11/19/2014
		 * @author Scott Nellé
		 */
		function redirect() {
			// this is what the user asked for (strip out home portion, case insensitive)
			$userrequest = str_ireplace(get_option('home'),'',$this->get_address());
			$userrequest = rtrim($userrequest,'/');

			$redirects = genesis_get_option('301_redirects', 'vi-seo');
			if (!empty($redirects)) {

				$wildcard = genesis_get_option('301_redirects_wildcard', 'vi-seo');
				$do_redirect = '';

				// compare user request to each 301 stored in the db
				foreach ($redirects as $storedrequest => $destination) {
					// check if we should use regex search
					if ($wildcard === 'true' && strpos($storedrequest,'*') !== false) {
						// wildcard redirect

						// don't allow people to accidentally lock themselves out of admin
						if ( strpos($userrequest, '/wp-login') !== 0 && strpos($userrequest, '/wp-admin') !== 0 ) {
							// Make sure it gets all the proper decoding and rtrim action
							$storedrequest = str_replace('*','(.*)',$storedrequest);
							$pattern = '/^' . str_replace( '/', '\/', rtrim( $storedrequest, '/' ) ) . '/';
							$destination = str_replace('*','$1',$destination);
							$output = preg_replace($pattern, $destination, $userrequest);
							if ($output !== $userrequest) {
								// pattern matched, perform redirect
								$do_redirect = $output;
							}
						}
					}
					elseif(urldecode($userrequest) == rtrim($storedrequest,'/')) {
						// simple comparison redirect
						$do_redirect = $destination;
					}

					// redirect. the second condition here prevents redirect loops as a result of wildcards.
					if ($do_redirect !== '' && trim($do_redirect,'/') !== trim($userrequest,'/')) {
						// check if destination needs the domain prepended
						if (strpos($do_redirect,'/') === 0){
							$do_redirect = home_url().$do_redirect;
						}
						header ('HTTP/1.1 301 Moved Permanently');
						header ('Location: ' . $do_redirect);
						exit();
					}
					else { unset($redirects); }
				}
			}
		} // end funcion redirect

		/**
		 * getAddress function
		 * utility function to get the full address of the current request
		 * credit: http://www.phpro.org/examples/Get-Full-URL.html
		 * @added 11/19/2014
		 * @author Scott Nellé
		 */
		function get_address() {
			// return the full address
			return $this->get_protocol().'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		} // end function get_address

		function get_protocol() {
			// Set the base protocol to http
			$protocol = 'http';
			// check for https
			if ( isset( $_SERVER["HTTPS"] ) && strtolower( $_SERVER["HTTPS"] ) == "on" ) {
    			$protocol .= "s";
			}

			return $protocol;
		} // end function get_protocol
	}

	$vi_seo = new vi_seo();
}