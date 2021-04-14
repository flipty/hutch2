<?php

if( class_exists( 'vimmcms_dashboard' ) ) return;

class vimmcms_dashboard {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'wp_dashboard_setup', function() {
			$widget_id = 'vimm-cms';
			$widget_name = 'Vivid Image Info';
			$callback = array( 'vimmcms_dashboard', 'vimmWidgetDisplay' );

			wp_add_dashboard_widget( $widget_id, $widget_name, $callback );
		} );

		if( get_option( PLUGIN_DB_NAME.'_show_welcome' ) == 1 ) {
			add_action( 'wp_dashboard_setup', function() {
				$widget_id = 'vimm-cms-help';
				$widget_name = get_option( PLUGIN_DB_NAME.'_welcome_title' );
				$callback = array( 'vimmcms_dashboard', 'vimmDashboardHelp' );

				wp_add_dashboard_widget( $widget_id, $widget_name, $callback );
			} );
		}

		// remove dashboard widgets
		if( get_option( PLUGIN_DB_NAME.'_dashboard_remove_widgets' ) == 1 ) {
			add_action( 'wp_dashboard_setup', array( 'vimmcms_dashboard', 'removeDashboardWidgets' ) );
		}

		// remove browser panel
		if( get_option( PLUGIN_DB_NAME.'_dashboard_browser' ) == 1 ) {
		    add_action( 'wp_dashboard_setup', array( 'vimmcms_dashboard', 'removeDashboardBrowser' ) );
		}

		// remove nag update
		if( get_option( PLUGIN_DB_NAME.'_dashboard_remove_nag_update' ) == 1 ) {
		    add_action( 'admin_init', create_function( '', 'remove_action( \'admin_notices\', \'update_nag\', 3 );' ) );
		}

		// remove right now
		if( get_option( PLUGIN_DB_NAME.'_dashboard_remove_right_now' ) == 1 ) {
		    add_action( 'wp_dashboard_setup', array( 'vimmcms_dashboard', 'removeRightNow' ) );
		}
	}

	/**
	 * Build our custom Vivid Image Wordpress Widget
	 * Display's Vivid Image's Current Buzz (RSS Feed)
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function vimmWidgetDisplay() {
		?>
		<a href="http://www.vimm.com/" target="_blank">
			<img src="<?php echo plugins_url('assets/images/vimm-dashboard-logo.png', __FILE__); ?>" alt="Vivid Image" align="left" />
		</a>
		<h5>Questions regarding your website?</h5>
		<p>Give us a call at <strong>320.587.8974</strong> or email us at <strong><a href="mailto:info@vimm.com">info@vimm.com</a></strong></p>
		<p>Do you have new staff? Has your address changed? Do you need to update your account information?</p>
		<p><a class="gf_dashboard_button button button-primary button-large" target="_blank" href="https://vimm.formstack.com/forms/client_contact_validation">Click here to send us your updated info.</a></p>
		<p>Need support with your website or email?</p>
		<p><a class="gf_dashboard_button button button-primary button-large" target="_blank" href="https://vimm.com/support/support-request-form/">Click here to request support for your website or email.</a></p>
		<hr />
		<h3 class="buzz">Current Buzz At Vivid Image</h3>
		<?php
		// Get RSS Feed(s)
		// $rss = fetch_feed('http://feeds.feedburner.com/vivid-image');
		$rss = fetch_feed('https://vimm.com/rss');

		if( !is_wp_error( $rss ) ) {
    		$maxitems = $rss->get_item_quantity(3);
    		$rss_items = $rss->get_items(0, $maxitems);
		}

		if( $maxitems == 0 ) {
			echo '<li>No items.</li>';
    	} else {
    		foreach( $rss_items as $item ) {
    			?>
	   			<div>
		        	<h4>
		        		<a href="<?php echo $item->get_permalink(); ?>" title="<?php echo 'Posted '.$item->get_date('j F Y | g:i a'); ?>">
		        			<?php echo $item->get_title(); ?>
		        		</a>
		        	</h4>
					<p style="font-weight:normal">
						<?php 
							//echo $item->get_description();
							$content = substr($item->get_description(), 0, 200);
							echo $content . '...';
						?>
		        		<hr />
		        	</p>
				</div>
				<?php
			}
		}
	}

	/**
	 * Custom Dashboard Widget for Quick Help Guides
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function vimmDashboardHelp() {
	    echo stripslashes( get_option( PLUGIN_DB_NAME.'_welcome_text' ) );
	}

	/**
	 * Removes the Right Now Dashboard widget
	 *
	 * @since 09/11/2014
	 */
	function removeRightNow() {
	    if( ( !current_user_can( 'activate_plugins' ) ) || ( get_option( PLUGIN_DB_NAME.'_dashboard_admin_only' ) == 0 ) ) {
	        global $wp_meta_boxes;
	        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
	    }
	}

	/**
	 * Remove Dashboard Widgets that were choosen in Vimm CMS Admin Page
	 *
	 * @since 09/11/2014
	 */
	function removeDashboardWidgets() {
	    if( ( !current_user_can( 'activate_plugins' ) ) || ( get_option( PLUGIN_DB_NAME.'_dashboard_admin_only' ) == 0 ) ) {
	       global $wp_meta_boxes;
	       unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	       unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	       unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
	       unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	       unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	       unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	       unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );
	      }
	}

	/**
	 * Remove Dashboard Browser Widget
	 *
	 * @since 09/11/2014
	 */
	function removeDashboardBrowser() {
	    if( ( !current_user_can( 'activate_plugins' ) ) || ( get_option( PLUGIN_DB_NAME.'_dashboard_admin_only' ) == 0 ) ) {
	        global $wp_meta_boxes;
	        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_browser_nag'] );
	    }
	}
}