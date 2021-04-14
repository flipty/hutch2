<?php
/**
 * Admin Page for vimm-cms
 *
 * @since 09/11/2014
 * @author Tyler Steinhaus
 */

if( class_exists( 'vimmcms_admin' ) ) return;

class vimmcms_admin {

	/**
	 * Private $options Has all the options saved in one variable to easily call
	 */
	public $options = array();

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'admin_menu', array( $this, 'createMenuItem' ) );
		add_action( 'load-settings_page_vimm-cms', array( $this, 'helpTab' ) );
		$this->optionFields();
	}

	/**
	 * Add Vimm CMS to Settings Menu
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function createMenuItem() {
		$page_title = 'Vimm CMS';
		$menu_title = 'Vimm CMS';
		$capability = 'manage_options';
		$menu_slug = 'vimm-cms';
		$callback = array( $this, 'vimmCMSAdminPage' );

		add_options_page( $page_title, $menu_title, $capability, $menu_slug, $callback );
	}

	/**
	 * Vimm CMS Option Fields/Default Fields
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function optionFields() {
		$this->options = array (
			array(
				"name" => PLUGIN_TITLE." Options",
    			"type" => "title"
			),

			/** Dashboard Panels - Start **/
			array(
				"name" => "Dashboard Panels",
    			"type" => "section"
			),

			array( "type" => "open"),

			array(
				"name" 		=> "Hide 'Right Now'",
				"desc" 		=> "This will hide the Right Now panel from the dashboard",
				"id" 		=> PLUGIN_DB_NAME."_dashboard_remove_right_now",
				"type" 		=> "radio",
			    "options" 	=> array( "1", "0" ),
    			"std" 		=> 1
			),

			array(
				"name" 		=> "Hide Browser Update Panel",
			    "desc" 		=> "Hides the browser update panel",
			    "id" 		=> PLUGIN_DB_NAME."_dashboard_browser",
			    "type" 		=> "radio",
			    "options" 	=> array("1", "0"),
			    "std" 		=> 1
			),

			array(
				"name" 		=> "Hide Other Dashboard Panels",
    			"desc" 		=> "This will hide all standard dashboard panels except the Right Now panel",
			    "id" 		=> PLUGIN_DB_NAME."_dashboard_remove_widgets",
    			"type" 		=> "radio",
    			"options" 	=> array("1", "0"),
    			"std" 		=> 1
			),

			array(
				"name" 		=> "Show Dashboard To Admin",
			    "desc" 		=> "This will show the dashboard panels to the admin, but editors will not see them.",
			    "id" 		=> PLUGIN_DB_NAME."_dashboard_admin_only",
			    "type" 		=> "radio",
			    "options" 	=> array("1", "0"),
			    "std" 		=> 1
			),

			array(
				"name" 		=> "Hide Nag Update",
			    "desc" 		=> "This will hide the Nag Update for out of date versions of wordpress",
			    "id" 		=> PLUGIN_DB_NAME."_dashboard_remove_nag_update",
			    "type" 		=> "radio",
			    "options" 	=> array("1", "0"),
			    "std" 		=> 1
			),

			array(
				"name" 		=> "Add You Own Welcome Panel?",
			    "desc" 		=> "This will appear on the dashboard.  We recommend providing your contact details and links to the help files you have made for your client.",
			    "id" 		=> PLUGIN_DB_NAME."_show_welcome",
			    "type" 		=> "radio",
			    "options" 	=> array("1", "0"),
			    "std" 		=> 1
			),

			array(
				"name" 		=> "Welcome Panel Settings",
			    "type" 		=> "subsectionvars"
			),

			array(
				"name" 		=> "Title",
			    "desc" 		=> "The title of your dashboard panel.",
			    "id" 		=> PLUGIN_DB_NAME."_welcome_title",
			    "type" 		=> "textlocalvideo",
			    "std" 		=> 'Welcome To '.get_bloginfo( 'name')
			),

			array(
				"name" 		=> "Description",
			    "desc" 		=> "Please add the text in html format here.",
			    "id" 		=> PLUGIN_DB_NAME."_welcome_text",
			    "type" 		=> "textarea",
			    "std" 		=> 'At Vivid Image, we want to help make maintaining your website as easy as possible.<br><br>
			For basic tutorials on how to work with the WordPress Editor, click on Manual at the lower left of the left sidebar.<br><br><br>
			For information on Premium Features & Functionality, use the links below.<br><br>
			For information on Broken Link Checker → <a href="http://training.vimm.com/category/plugins/broken-link-checker/" target="_blank">Click here</a><br><br>
			For information on Events → <a href="http://training.vimm.com/category/plugins/events-calendar/" target="_blank">Click here</a><br><br>
			For information on Feedburner → <a href="http://training.vimm.com/category/social-media/feedburner/" target="_blank">Click here</a><br><br>
			For information on Forms → <a href="http://training.vimm.com/category/plugins/gravity-forms/" target="_blank">Click here</a><br><br>
			For information on Galleries → <a href="http://training.vimm.com/category/plugins/next-gen-gallery/" target="_blank">Click here</a><br><br>
			For information on Genesis SEO Settings → <a href="http://training.vimm.com/category/plugins/genesis-seo-settings/" target="_blank">Click here</a><br><br>
			For information on Google Analytics → <a href="http://training.vimm.com/category/plugins/google-analytics/" target="_blank">Click here</a><br><br>
			For information on Menus → <a href="http://training.vimm.com/category/wordpress/menus/" target="_blank">Click here</a><br><br>
			For information on Shopp → <a href="http://training.vimm.com/category/plugins/shopp/" target="_blank">Click here</a><br><br>
			For information on Slides → <a href="http://training.vimm.com/category/plugins/slide-show/" target="_blank">Click here</a><br><br>
			For information on Videos → <a href="http://training.vimm.com/category/plugins/video-quick-tags/" target="_blank">Click here</a><br><br><br>
			Ideal Image Sizes:<br><BR>
			Home Page Slide Show → 480x224 pixels<br><br>
			Gallery Images → 1025x681 pixels'
			),

			array(
				"type" 		=> "close"
			),
			/** Dashboard Panels - End **/

			/** Modify Menus - Start **/
			array(
				"name" 		=> "Modify Menus",
			    "type" 		=> "section"
			),

			array(
				"type" 		=> "open"
			),

			array(
				"name" 		=> "These changes will only effect people with the user role of <strong>Editor</strong> or below.  You are currently logged is as the admin, so you will not see any changes in the menus until you login with a different user role.",
			    "type" 		=> "message"
			),

			array(
				"name" 		=> "Choose A CMS Profile",
			    "desc" 		=> "Which profile best fits your clients needs?",
			    "id" 		=> PLUGIN_DB_NAME."_hide_profile",
			    "type" 		=> "radioprofile",
			    "options" 	=> array("1", "2","3"),
			    "std" 		=> '1'
			),

			array(
				"name" 		=> "Hide Posts Menu",
			    "desc" 		=> "Hides Posts from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_posts",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide Media Menu",
			    "desc" 		=> "Hides Media from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_media",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide Links Menu",
			    "desc" 		=> "Hides Links from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_links",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide Pages Menu",
			    "desc" 		=> "Hides Pages from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_pages",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide Comments Menu",
			    "desc" 		=> "Hides Comments from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_comments",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide Users / Profile Menu",
			    "desc" 		=> "Hides Users / Profile from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_users",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide Tools Menu",
			    "desc" 		=> "Hides Tools from left menu",
			    "id" 		=> PLUGIN_DB_NAME."_hide_tools",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Hide 2nd Separator",
			    "desc" 		=> "Hides 2nd separator",
			    "id" 		=> PLUGIN_DB_NAME."_hide_separator2",
			    "type" 		=> "checkboxlast",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "The following change will display the Widgets or Menus option in Appearance, Or Genesis Settings to users with the role of <strong>Editor</strong>. Please refer to the help tab to understand the consequences of enabling this option.",
			    "type" 		=> "message2"
			),

			array(
				"name" 		=> "Show Appearance > Customize",
			    "desc" 		=> "Shows the submenu 'Customize' under the Appearance tab.",
			    "id" 		=> PLUGIN_DB_NAME."_show_customize",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Show Appearance > Widgets",
			    "desc" 		=> "Shows the submenu 'Widgets' under the Appearance tab.",
			    "id" 		=> PLUGIN_DB_NAME."_show_widgets",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Show Appearance > Menus",
			    "desc" 		=> "Shows the submenu 'Menus' under the Appearance tab.",
			    "id" 		=> PLUGIN_DB_NAME."_show_appearance",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),

			array(
				"name" 		=> "Show Genesis > Theme Settings",
			    "desc" 		=> "Shows Theme Settings Menu Under Genesis.",
			    "id" 		=> PLUGIN_DB_NAME."_show_genesis_theme_settings",
			    "type" 		=> "checkboxlastv3",
			    "std"		=> 0
			),
			array(
				"type" 		=> "close"
			),
			/** Dashboard Panels - End **/

			/** Modify Menus - Start **/
			array(
				"name" 		=> "Other Options",
			    "type" 		=> "section"
			),	
			array(
				"type" 		=> "open"
			),

			array(
				"name" 		=> "Other options Section.",
			    "type" 		=> "message"
			),
		
			array(
				"name" 		=> "Comment Notification Email",
				"desc"		=> "Send comment notifications to an alternate email other than the admins email. Add a comma tbetween multiple email addresses",
				"id"		=> PLUGIN_DB_NAME."_alternate_comment_email",
				"type"		=> "text"
			),
			array(
				"name" 		=> "Send Site Admin Comment Emails",
			    "desc" 		=> "Check this box to disable the sending of comment moderation emails to the site admin",
			    "id" 		=> PLUGIN_DB_NAME."_admin_comment_email",
			    "type" 		=> "checkbox",
			    "std" 		=> 0
			),
			array(
				"name" 		=> "Is this site ADA Compliant?",
			    "desc" 		=> "Will add a indicator to the admin bar if this site is ADA Compliant",
			    "id" 		=> PLUGIN_DB_NAME."_dashboard_ada_compliant",
			    "type" 		=> "radio",
			    "options" 	=> array("1", "0"),
			    "std" 		=> 1
			),


			array(
				"type" => "close"
			)
			
			/** Modify Menus - End **/
		);
	}

	/**
	 * Vimm CMS Admin Page
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function vimmCMSAdminPage() {
		?>
		<div class="vimm-cms-wrap">
			<?php screen_icon(); ?>
			<h2>Vimm CMS Settings</h2>
			<h4><span style="font-style: italic;">Please Note:</span> Custom logo images should be uploaded to the http://vimm.com/custom-images/ directory.</h4>
			<?php
			$this->saveForm();
			?>
			<form method="post">
				<?php
					$this->formFields();
				?>
				<input type="hidden" name="action" value="save" />
			</form>
			<p>
				<hr>
			</p>
			<form method="post">
				<p class="submit" id="wlcm-reset">
					Click here to reset the plugin:
					<input name="reset" type="submit" value="Reset" />
					<input type="hidden" name="action" value="reset" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Build out form field inputs
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function formFields() {
		foreach( $this->options as $value ) {
			if( $value['type'] == 'open' ) {

			} elseif( $value['type'] == 'close' ) {
					echo '</div>';
				echo '</div>';
				echo '<br />';
			} elseif( $value['type'] == 'text' ) {
				if( $value['id'] == PLUGIN_DB_NAME.'_header_custom_logo' || $value['id'] == PLUGIN_DB_NAME.'_footer_custom_logo' )  {  ?>
					<div style="border:0;" class="wlcms_input wlcms_text">
						<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
						<small><?php echo $value['desc']; ?></small>
						<div class="clearfix"></div>
					</div>
				<?php
				} else {
				?>
				<div class="wlcms_input wlcms_text">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>
			<?php
				}
			} elseif( $value['type'] == 'textlocalvideo' ) {
				?>
				<div class="wlcms_input_local_video wlcms_text">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>
				<?php
			} elseif( $value['type'] == 'message' ) {
				?>
				<div class="wlcms_input_message wlcms_text">
					<div id="icon-users" class="wlcms-icon32"><br></div><?php echo $value['name']; ?>
				</div>
				<?php
			} elseif( $value['type'] == 'message2' ) {
				?>
				<div class="wlcms_input_message wlcms_text">
					<div id="icon-themes" class="wlcms-icon32"><br></div><?php echo $value['name']; ?>
				</div>
				<?php
			} elseif( $value['type'] == 'textarea' ) {
				?>
				<div class="wlcms_input_welcome_last wlcms_textarea">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
					<small><?php echo $value['desc']; ?></small>
					<div class="clearfix"></div>
				</div>

				<?php
			} elseif( $value['type'] == 'select' ) {
				?>
				<div class="wlcms_input wlcms_select">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
					<?php
					foreach ($value['options'] as $option) {
					?>
						<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option>
					<?php
					}
					?>
					</select>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
				<?php
			} elseif( $value['type'] == 'checkboxlast' || $value['type'] == 'checkbox' ) {
				?>
				<div class="<?php if($value['type']  == 'checkbox') { echo 'wlcms_input_local_video'; } else { echo 'wlcms_checkbox_last'; }?> wlcms_checkbox">
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<?php
					if( get_option( $value['id'] ) ) {
						$checked = "checked=\"checked\"";
						$remChecked = 'wlcms_remChecked';
					} else {
						$checked = "";
						$remChecked = '';
					}
					?>
					<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> class="<?php echo $remChecked; ?>" />
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
				<?php
			} elseif( $value['type'] == 'checkboxlastv3' ) {
				// only show if version 3 of WordPress or above
				global $wp_version;
			    if (substr($wp_version,0,3) < 3) {
			        echo '<div class="wlcms_checkbox_last wlcms_checkbox">';
			        echo '<input type="hidden" name="' . $value['id'] . '" id="' . $value['id'] . '" value="" />';
			        echo '<div class="clearfix"></div>';
			        echo '</div>';
			    } else {
					?>
					<div class="<?php if($value['type']  == 'checkbox') { echo 'wlcms_input_local_video'; } else { echo 'wlcms_checkbox_last'; }?> wlcms_checkbox">
						<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
						<?php
						if( get_option( $value['id'] ) ) {
							$checked = "checked=\"checked\"";
							$remChecked = 'wlcms_remChecked';
						} else {
							$checked = "";
							$remChecked = '';
						}
						?>
						<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> class="<?php echo $remChecked; ?>" />
						<small><?php echo $value['desc']; ?></small>
						<div class="clearfix"></div>
					</div>
					<?php
				}
			} elseif( $value['type'] == 'radio' ) {
				?>
				<div class="wlcms_input wlcms_radio" <?php if($value['id'] == PLUGIN_DB_NAME.'_show_welcome') { echo ' id="form-show-welcome" '; }?> >
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<?php
					$counter = 1;
					foreach( $value['options'] as $option ) {
						if( get_option($value['id'] ) ==  $option ) {
							$checked = "checked=\"checked\"";
						} else {
							$checked = "";
						}
					?>
						<label class="radioyesno">
							<?php
							echo $counter == 1 ? 'Yes' : 'No';
							?>
							<input type="radio" name="<?php echo $value['id']; ?>" class="<?php echo $value['id']; ?>" value="<?php echo $option; ?>" <?php echo $checked; ?> />
						</label>
				<?php
					$counter++;
				}
				?>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
				<?php
			} elseif( $value['type'] == 'radioprofile' ) {
				?>
				<div class="wlcms_input_profile" <?php if($value['id'] == PLUGIN_DB_NAME.'_show_welcome') { echo ' id="form-show-welcome" '; }?> >
					<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
					<?php
					$counter = 1;
					foreach( $value['options'] as $option ) { ?>
					        <?php
					            switch ($counter) {
					                case 1:
					                    $profileName = 'Custom';
					                    if(get_option($value['id']) ==  1){ $checked = "checked=\"checked\""; }else{ $checked = ""; }
					                    break;
					                case 2:
					                    $profileName = 'Website';
					                    if(get_option($value['id']) ==  2){ $checked = "checked=\"checked\""; }else{ $checked = ""; }
					                    break;
					                case 3:
					                    $profileName = 'Blog';
					                    if(get_option($value['id']) ==  3){ $checked = "checked=\"checked\""; }else{ $checked = ""; }
					                    break;
					            }
					        ?>
    				<label class="radio<?php echo $profileName;?>">
    					<?php echo $profileName;?>
    					<input type="radio" name="wlcms_o_radio_profiles" class="<?php echo $value['id']; ?>" value="<?php echo $counter; ?>" <?php echo $checked; ?> id="radio<?php echo $profileName; ?>" />
    				</label>
				<?php
					$counter++;
				}
				?>
					<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
				</div>
				<?php
			} elseif( $value['type'] == 'section' ) {
				$i++;
				?>
				<div class="wlcms_section">
					<div class="wlcms_title">
						<h3>
							<img src="<?php bloginfo('wpurl')?>/wp-content/plugins/vimm-cms/assets/images/trans.png" class="inactive" alt="" />
							<?php echo $value['name']; ?>
						</h3>
						<span class="submit">
							<input name="save<?php echo $i; ?>" type="submit" value="Save changes" />
						</span>
					<div class="clearfix"></div>
				</div>
				<div class="wlcms_options" style="display: none;">
				<?php
			} elseif( $value['type'] == 'subsection' ) {
				?>
				<div id="v<?php echo str_replace(" ", "", $value['name']); ?>" class="video-h">
					<h4>
						<?php echo $value['name']; ?>
						<span class="submit">
							<input type="submit" value="clear" onclick="clearvid('v<?php echo str_replace(" ", "", $value['name']); ?>');return false;" />
						</span>
					</h4>
					<div class="clearfix"></div>
				<?php
			} elseif( $value['type'] == 'subsectionvars' ) {
				?>
				<div id="v<?php echo str_replace(" ", "", $value['name']); ?>" class="video-h">
					<h4>
						<?php echo $value['name']; ?>
					</h4>
					<div class="clearfix"></div>
				</div>
				<?php
			}
		}
	}

	/**
	 * Save Vimm CMS Form or Reset
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 **/
	function saveForm() {
		if( !empty( $_GET['page'] ) && $_GET['page'] == 'vimm-cms' ) {
    		if( !empty( $_REQUEST['action'] ) && 'save' == $_REQUEST['action'] ) {
        		foreach( $this->options as $value ) {
        			if( empty( $value['id'] ) ) continue;

            		if( isset( $_REQUEST[ $value['id'] ] ) ) {
            	 		update_option( $value['id'], $_REQUEST[ $value['id'] ]  );
					} else {
				 		delete_option( $value['id'] );
		    		}
        		}
	        	// update editor capabilities
	        	if( !empty( $_REQUEST[PLUGIN_DB_NAME.'_show_appearance'] ) || !empty( $_REQUEST[PLUGIN_DB_NAME.'_show_widgets'] ) || ( $_REQUEST[PLUGIN_DB_NAME.'_show_genesis_theme_settings'] ) ) {
	            	$role = get_role( 'editor' );
	        		#$role->add_cap( 'switch_themes' );
	            	$role->add_cap( 'edit_theme_options' );
	        	} else {
	            	$role = get_role( 'editor' );
	        		#$role->remove_cap( 'switch_themes' );
	            	$role->remove_cap( 'edit_theme_options' );
	        	}
	    		echo '<div id="message" class="updated fade"><p><strong>Vimm CMS settings saved.</strong></p></div>';
			}
			elseif( !empty( $_REQUEST['action'] ) && 'reset' == $_REQUEST['action'] ) {
				foreach( $this->options as $value ) {
	        		delete_option( $value['id'] );
				}
	    		// remove editor capabilities
	    		$role = get_role( 'editor' );
	    		$role->remove_cap( 'switch_themes' );
	   			$role->remove_cap( 'edit_theme_options' );
	   			echo '<div id="message" class="updated fade"><p><strong>Vimm CMS settings reset.</strong></p></div>';
			}
		}
	}

	/**
	 * Help Tab that is displayed in the admin panel on vimm cms settings page
	 *
	 * @since 09/11/2014
	 * @author Tyler Steinhaus
	 */
	function helpTab(){
	    $help = "This plugin was written and developed by Mat Lip and has since been modified by Tyler Steinhaus. If you have any questions please visit http://vimm.com or email Tyler at <a href=\"mailto:tyler@vimm.com\">tyler@vimm.com</a>.";
  		$args = array(
  			'title'   => 'Vimm CMS Help',
  			'id'      => 'vimm-cms-help',
  			'content' => $help
    	);
		get_current_screen()->add_help_tab($args);
	}
}