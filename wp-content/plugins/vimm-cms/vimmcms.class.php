<?php

/**
 * The Proper Classes for the Vimm CMS Plugin
 * @since 3.3.14
 * @author Mat Lipe <mat@vimm.com>
 *
 *
 */


class vimm_cms{

	/**
	 * Create the global actions and filters
	 * @since 8/9/12
	 */
	function __construct(){
		register_activation_hook(__FILE__, array( $this, 'vimmCMSActivation' ) );
		register_deactivation_hook( __FILE__, array( $this, 'vimmCMSDeactivation' ) );

		// Actions
		add_action( 'admin_menu', array( $this, 'removeAdminMenus' ) );
		add_action( 'admin_head', array( $this, 'adminCustomLogo' ) );
		add_action( 'admin_head', array( $this, 'hideSwitchTheme' ) );
		//add_action( 'login_head', array( $this, 'customLoginLogo' ) );
		add_filter( 'login_headerurl', array( $this, 'fix_wp_login_url') );
		add_filter( 'login_headertitle', array( $this, 'fix_wp_login_title'));
		add_action( 'admin_init', array( $this, 'enqueueScriptsStyles' ) );
		add_action( 'login_enqueue_scripts', array( $this, 'loginStyle' ) );

		add_action( 'admin_bar_menu', array($this, 'vimm_ada_admin_bar'), 999 );

		// Filters
		//add_filter('admin_footer_text', array( $this, 'removeAdminFooter' ) );
		
		//Calling this at such a high priority because Akismet also calls this function with a priority of 1000
		//This overrides wordpress's default action of sending comment moderation emails to the post author and the site admin
		//and instead only send the emails to an address provided through the Vimm CMS settings panel if one is present.
		add_filter( 'comment_moderation_recipients', array( $this, 'comment_moderation_post_author_only' ), 1010 , 2 );


		// Disable the auto updating of plugins and themes
		add_filter( 'auto_update_plugin', '__return_false' );
		add_filter( 'auto_update_theme', '__return_false' );		
	}

	function vimm_ada_admin_bar( $wp_admin_bar ) {
		if( get_option( PLUGIN_DB_NAME.'_dashboard_ada_compliant' ) == 1 ) {
			$args = array(
				'id'     => 'vimm-ada',     // id of the existing child node (New > Post)
				'title'  => 'ADA Audited', // alter the title of existing node
				'parent' => false,          // set parent to false to make it a top level (parent) node
			);
			$wp_admin_bar->add_node( $args );
		}
	}

	function fix_wp_login_url() {
		return get_bloginfo('url');  // or return any other URL you want
	}

	// Fix login logo title text
	function fix_wp_login_title() {
		return get_bloginfo('name'); // or return any other title you want
	}

	/**
	 * Plugin Activation
	 * These functions run on activation
	 *
	 * @since 08/20/2014
	 * @author Tyler Steinhaus
	 */
	function vimmCMSActivation() {
		$this->setDefaultPermissions();
		flush_rewrite_rules();

		if( !get_option( PLUGIN_DB_NAME.'_version' ) ) {
			add_option( PLUGIN_DB_NAME.'_version', PLUGIN_VERSION );
		}
	}

	/**
	 * Plugin Deactivation
	 * Clean Up Wordpress
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function vimmCMSDeactivation() {
    	// Delete our options
    	delete_option( PLUGIN_DB_NAME.'_version' );
	    delete_option( PLUGIN_DB_NAME.'_dashboard_remove_right_now' );
	    delete_option( PLUGIN_DB_NAME.'_dashboard_browser' );
	    delete_option( PLUGIN_DB_NAME.'_dashboard_remove_widgets' );
	    delete_option( PLUGIN_DB_NAME.'_dashboard_admin_only' );
	    delete_option( PLUGIN_DB_NAME.'_dashboard_remove_nag_update' );
	    delete_option( PLUGIN_DB_NAME.'_header_logo_link' );
	    delete_option( PLUGIN_DB_NAME.'_header_height' );
	    delete_option( PLUGIN_DB_NAME.'_header_custom_logo' );
	    delete_option( PLUGIN_DB_NAME.'_header_custom_logo_width' );
	    delete_option( PLUGIN_DB_NAME.'_footer_custom_logo' );
	    delete_option( PLUGIN_DB_NAME.'_footer_custom_logo_width' );
	    delete_option( PLUGIN_DB_NAME.'_developer_url' );
	    delete_option( PLUGIN_DB_NAME.'_developer_name' );
	    delete_option( PLUGIN_DB_NAME.'_login_custom_logo' );
	    delete_option( PLUGIN_DB_NAME.'_login_bg' );
	    delete_option( PLUGIN_DB_NAME.'_login_lost' );
	    delete_option( PLUGIN_DB_NAME.'_show_welcome' );
	    delete_option( PLUGIN_DB_NAME.'_welcome_title' );
	    delete_option( PLUGIN_DB_NAME.'_welcome_text' );
	    delete_option( PLUGIN_DB_NAME.'_hide_profile' );
	    delete_option( PLUGIN_DB_NAME.'_hide_posts' );
	    delete_option( PLUGIN_DB_NAME.'_hide_media' );
	    delete_option( PLUGIN_DB_NAME.'_hide_links' );
	    delete_option( PLUGIN_DB_NAME.'_hide_pages' );
	    delete_option( PLUGIN_DB_NAME.'_hide_comments' );
	    delete_option( PLUGIN_DB_NAME.'_hide_users' );
	    delete_option( PLUGIN_DB_NAME.'_hide_tools' );
	    delete_option( PLUGIN_DB_NAME.'_hide_separator2' );
	    delete_option( PLUGIN_DB_NAME.'_show_widgets' );
	    delete_option( PLUGIN_DB_NAME.'_show_appearance' );
		delete_option( PLUGIN_DB_NAME.'_alternate_comment_email' );
		delete_option( PLUGIN_DB_NAME.'_admin_comment_email' );
		
	}

	/**
	 * Comment Moderation Eemails
	 * 
	 * @since 10/14/2014
	 * @author Justin McGuire
	 */

	function comment_moderation_post_author_only($emails, $comment_id) {
		
		if( get_option( PLUGIN_DB_NAME.'_alternate_comment_email' ) ) {
			//Usnet the site admins email addresss from the list of emails if the option was checked
			if( get_option( PLUGIN_DB_NAME.'_admin_comment_email' ) ) {
				unset($emails[0]);
			}
			
			$emailList = get_option( PLUGIN_DB_NAME.'_alternate_comment_email' );
			if ( substr($emailList) >= 0  ) {
				$newEmails = explode(',',$emailList);
				foreach ( $newEmails as $value ) {
					$emails[] = $value;
				}
			} else {
				$emails[] = get_option( PLUGIN_DB_NAME.'_alternate_comment_email' );
			}
			
			return $emails;
		}  else {
			return $emails;
		}

	}
 
 
    /**
     * Give Editor Access to Necessary Stuff based on the plugins we are using
     *
     * @since 2.3
     */
    function setDefaultPermissions(){
            $role = get_role( 'editor' );
            $role->add_cap( 'NextGEN Change options' );
            $role->add_cap( 'NextGEN Gallery overview' );
            $role->add_cap( 'NextGEN Manage tags' );
            $role->add_cap( 'NextGEN Change style' );
            $role->add_cap( 'NextGEN Manage gallery' );
            $role->add_cap( 'NextGEN Upload images' );
            $role->add_cap( 'NextGEN Edit album' );
            $role->add_cap( 'NextGEN Manage others gallery' );
            $role->add_cap( 'NextGEN Use TinyMCE' );
            $role->add_cap( 'gravityforms_addon_browser' );
            $role->add_cap( 'gravityforms_create_form' );
            $role->add_cap( 'gravityforms_edit_entries' );
            $role->add_cap( 'gravityforms_edit_settings' );
            $role->add_cap( 'gravityforms_view_entries' );
            $role->add_cap( 'gravityforms_view_updates' );
            $role->add_cap( 'gravityforms_delete_entries' );
            $role->add_cap( 'gravityforms_edit_entry_notes' );
            $role->add_cap( 'gravityforms_export_entries' );
            $role->add_cap( 'gravityforms_view_entry_notes' );
            $role->add_cap( 'gravityforms_delete_forms' );
            $role->add_cap( 'gravityforms_edit_forms' );
            $role->add_cap( 'gravityforms_uninstall' );
            $role->add_cap( 'gravityforms_view_settings' );
            $role->add_cap( 'meteorslides_delete_slide' );
            $role->add_cap( 'meteorslides_edit_slides' );
            $role->add_cap( 'meteorslides_publish_slides' );
            $role->add_cap( 'meteorslides_edit_others_slides' );
            $role->add_cap( 'meteorslides_manage_options' );
            $role->add_cap( 'meteorslides_read_private_slides' );
            $role->add_cap( 'meteorslides_edit_slide' );
            $role->add_cap( 'meteorslides_manage_slideshows' );
            $role->add_cap( 'meteorslides_read_slides' );
            $role->add_cap( 'shopp_categories' );
            $role->add_cap( 'shopp_delete_orders' );
            $role->add_cap( 'shopp_financials' );
            $role->add_cap( 'shopp_products' );
            $role->add_cap( 'shopp_settings_checkout' );
            $role->add_cap( 'shopp_settings_shipping' );
            $role->add_cap( 'shopp_settings_update' );
            $role->add_cap( 'shopp_customers' );
            $role->add_cap( 'shopp_export_customers' );
            $role->add_cap( 'shopp_menu' );
            $role->add_cap( 'shopp_promotions' );
            $role->add_cap( 'shopp_settings_payments' );
            $role->add_cap( 'shopp_settings_system' );
            $role->add_cap( 'shopp_delete_customers' );
            $role->add_cap( 'shopp_export_orders' );
            $role->add_cap( 'shopp_orders' );
            $role->add_cap( 'shopp_settings' );
            $role->add_cap( 'shopp_settings_presentation' );
            $role->add_cap( 'shopp_settings_taxes' );
            $role->add_cap( 'create_users' );
    }

	/**
	 * Remove Unnessary Menus from the Admin Panel
	 *
	 * @since 09/11/2014
	 */
	function removeAdminMenus() {
    	global $menu, $submenu;

    	$restrict_user[0] = '';

	    if( get_option( PLUGIN_DB_NAME.'_hide_posts' ) ) { array_push( $restrict_user, __( 'Posts', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_media' ) ) { array_push( $restrict_user, __( 'Media', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_links' ) )  { array_push( $restrict_user, __( 'Links', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_pages' ) ) { array_push( $restrict_user, __( 'Pages', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_comments' ) ) { array_push( $restrict_user, __( 'Comments', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_tools' ) ) { array_push( $restrict_user, __( 'Tools', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_users' ) ) { array_push( $restrict_user, __( 'Profile', 'default' ) ); }
	    if( get_option( PLUGIN_DB_NAME.'_hide_separator2' ) ) { $hideSeparator2 = true; } else { $hideSeparator2 = false; };

    	unset($restrict_user[0]);

	    if( sizeof( $restrict_user ) > 0 ) {
	        // WP localization
	        $f = create_function( '$v,$i', '$v = __($v);' );

	        if( !current_user_can( 'edit_theme_options' ) ) {
	            array_walk( $restrict_user, $f );

	            // remove menus
	            end( $menu );
	            while( prev( $menu ) ) {
	                $k = key( $menu );
	                $v = explode( ' ', $menu[$k][0] );
	                $s = explode( ' ', $menu[$k][2] );

	                if( ( $hideSeparator2 ) && ( $s[0] == 'separator2' ) ) {
	                    unset( $menu[$k] );
	                }
	                if( in_array( is_null( $v[0] ) ? '' : $v[0] , $restrict_user ) ) unset( $menu[$k] );
	            }
	        }
	    }
	    if( !current_user_can( 'edit_theme_options' ) ) {

            // hide themes
            unset( $submenu['themes.php'][5] );

			// hide menus
            if( !get_option( PLUGIN_DB_NAME.'_show_appearance' ) ) {

                unset( $submenu['themes.php'][10] );
            }

			// hide widgets
            if( !get_option( PLUGIN_DB_NAME.'_show_widgets' ) ) {
                unset( $submenu['themes.php'][7] );
            }

			// hide customizer
			if( !get_option( PLUGIN_DB_NAME.'_show_customize' ) ) {
				unset( $submenu['themes.php'][6] );
			}

			// hide genesis
            if( !get_option( PLUGIN_DB_NAME.'_show_genesis_theme_settings' ) ) {
                foreach( $menu as $k => $v ) {
                    if( $v[0] == 'Genesis' ) {
                        unset( $menu[$k] );
                    }
                }
            }
        }
	}

	/**
	 * Custom Logo in the admin panel
	 *
	 * @since 09/11/2014
	 */
	function adminCustomLogo() {
    	global $wp_version;
		echo '<style type="text/css">';
			echo '#header-logo { background-image: url(https://vimm.com/custom-images/vi-logo_sm-top.png) !important; ';
			$css_width = get_option( PLUGIN_DB_NAME.'_header_custom_logo_width' );
			if( css_width != '' ) {
        		echo 'width: ' . get_option( PLUGIN_DB_NAME.'_header_custom_logo_width' ).';';
    		} else {
        		if( ( version_compare( $wp_version, '3.2', '>=' ) ) && ( get_option( 'PLUGIN_DB_NAME.header_height' ) == 1 ) ) {
            		echo 'width: 32px;';
        		}
    		}
    		echo '}';
    		if( ( version_compare( $wp_version, '3.2', '>=' ) ) && ( get_option( 'PLUGIN_DB_NAME.header_height' ) == 1 ) ) {
		        echo '#wphead { height: 48px; }
		                   #wphead h1 { font-size: 22px; padding: 10px 8px 5px; }
		                   #header-logo { height: 32px; }
		                   #user_info { padding-top: 8px }
		                   #user_info_arrow { margin-top: 8px; }
		                   #user_info_links { top: 8px; }
		                   #footer p { padding-top: 15px; }
		                   #wlcms-footer-container {    padding-top: 10px;  line-height: 30px;}
		                 ';
    		}
    		if( ( version_compare( $wp_version, '3.2', '<' ) ) && ( get_option( 'PLUGIN_DB_NAME.header_height' ) == 0 ) ) {
        		echo '#wlcms-footer-container {     padding-top: 10px;  line-height: 30px; }';
    		}
   			if( get_option( 'PLUGIN_DB_NAME.header_logo_link' ) == 1 ) {
        		echo '#site-heading { display: none; } ';
    		}
	    echo '</style>';

	    if( get_option( 'PLUGIN_DB_NAME.header_logo_link' ) == 1 ) {
	        echo '<script type="text/javascript">';
	        echo "jQuery(function($){ $('#header-logo').wrap('<a href=\"".site_url()."\" alt=\"".get_bloginfo( 'name' )."\" title=\"".get_bloginfo( 'name' )."\">'); });";
	        echo '</script>';
	    }
	}

	/**
	 * Modify Login Screen
	 * Replaces Logo link from Wordpress to site default url and Powered by Wordpress to Your Site Name
	 *
	 * @since 09/11/2014
	 */
	function customLoginLogo() {
		echo '
	    <script type="text/javascript">
	        function loginalt() {
	            var changeLink = document.getElementById(\'login\').innerHTML;
	            changeLink = changeLink.replace("http://wordpress.org/", "'.site_url().'");
	            changeLink = changeLink.replace("Powered by WordPress", "'.get_bloginfo('name').'");
	            document.getElementById(\'login\').innerHTML = changeLink;
	        }
	        window.onload=loginalt;
	    </script>
	    ';
	}

	/**
	 * Enqueue Vimm CMS Scripts & Styles
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function enqueueScriptsStyles() {
		wp_enqueue_style( 'vimm-cms', plugins_url( 'vimm-cms/assets/css/style.css' ), false, '1.0', 'all' );
		wp_enqueue_script( "vimm-cms", plugins_url( 'vimm-cms/assets/scripts/jscript.js' ), false, "1.0" );
	}

	/**
	 * Enqueue's Vimm CMS Style on login screen
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function loginStyle() {
		wp_enqueue_style( 'vimm-cms', plugins_url( 'vimm-cms/assets/css/style.css' ) );
	}

	/**
	 * Remove Admin Footer
	 *
	 * @since 09/11/2014
	 */
	function removeAdminFooter() {
		echo '<div id="wlcms-footer-container">';
        	echo '<img style="width:' . get_option( PLUGIN_DB_NAME.'_footer_custom_logo_width') . ';" src="https://vimm.com/custom-images/vi-logo_sm.png" id="wlcms-footer-logo"> ' . get_option('PLUGIN_DB_NAME.developer_name');
    	echo '</div>';
	}

	/**
	 * Hide Switch Theme on the Dashboard from Right Now for Editors
	 *
	 * @since 09/11/2014
	 */
	function hideSwitchTheme() {
		if( !current_user_can( 'manage_options' ) ) {
			echo '
			<style type="text/css">
				#dashboard_right_now .versions p, #dashboard_right_now .versions #wp-version-message  { display: none; }
			</style>
			';
		}
	}
}