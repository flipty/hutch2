<?php

/**
 * We will create a custom theme settings page under Genesis
 * to display theme settings so the programmers don't have to
 * do in the backend.
 *
 * Makes life easier and allows us to work faster as a team
 * if we can do this on our own.
 *
 * @since 10/21/2014
 * @author Tyler Steinhaus
 */

// Setup Theme Settings
//include_once( get_template_directory() . '/lib/admin/child-theme-settings.php');

class vi_child_theme_settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page
	 *
	 * Constructor
	 *
	 * @since 10/21/2014
	 * @author Tyler Steinhaus
	 */
	function __construct() {

		$page_id = 'vivid-image-child';
		$menu_ops = array(
			'submenu' => array(
				'parent_slug'	=>	'genesis',
				'page_title'	=>	'Vivid Image Theme',
				'menu_title'	=>	'VI Theme'
			)
		);
		$page_ops = NULL;
		$settings_field = 'vi-settings';
		$default_settings = array(
			'messagebar_colors'	=>	'',
			'tinymce_colors'	=> ''
		);

		$this->create( $page_id, $menu_ops, array(), $settings_field, $default_settings );

		// Add add to sanitize setting fields
		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

		// Enqueue script for vi_child_theme_settings
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue the scripts for this page
	 *
	 * @since 10/29/2014
	 * @author Tyler Steinhaus
	 */
	function enqueue_scripts( $hook ) {
		if( $hook == 'genesis_page_vivid-image-child' ) {
			wp_enqueue_script( 'vi_child_theme_settings', JS_ASSETS.'/theme_page.js', array( 'jquery' ) );
		}
	}

	/**
	 * Sanitize fields before putting them into the DB
	 *
	 * @since 10/21/2014
	 * @author Tyler Steinhaus
	 */
	function sanitization_filters() {}

	/**
	 * Register metaboxes for our VI Theme Settings page
	 *
	 * @since 10/21/2014
	 * @author Tyler Steinhaus
	 */
	function metaboxes() {
		add_meta_box( 'default-colors', 'Default Colors', array( $this, 'default_colors' ), $this->pagehook, 'main', 'high' );
	}

	/**
	 * Build Default Colors meta box.
	 *
	 * @since 10/21/2014
	 * @author Tyler Steinhaus
	 */
	function default_colors() {
		?>
		<p>
			<strong>TinyMCE Colors:</strong><br />
			<div class="tinymce_colors"></div>
			<?php
			$tinymce_colors =  $this->get_field_value( 'tinymce_colors' );
			if( !empty( $tinymce_colors ) ) {
				foreach( $tinymce_colors as $color ) {
					?>
					<div class="tinymce_colors" style="display: inline-block;margin-right: 10px;">
						<input type="checkbox" style="margin-top: -16px;" name="<?php echo $this->get_field_name( 'tinymce_colors' ); ?>[]" id="<?php echo $this->get_field_id( 'tinymce_colors' ); ?>" value="<?php echo $color; ?>" checked="checked">
						<div style="display: inline-block;width: 25px;height: 25px;background: <?php echo $color ?>"></div>
					</div>
					<?php
				}
			}

			?>
			<br />
			<input type="text" name="add_tinymce_colors" id="add_tinymce_colors" value="" /> <input type="button" name="add_tinymce_colors_button" id="add_tinymce_colors_button" value="Add" onClick="tinyMCEColorAdd()" />
		</p>
		<?php
		if( is_plugin_active( 'VividImageMessageBar/vimmMB.php' ) ) {
			?>
			<p>
				<strong>Message Bar Colors:</strong><br />
				<div class="messagebar_colors"></div>
				<?php
				$messagebar_colors =  $this->get_field_value( 'messagebar_colors' );
				if( !empty( $messagebar_colors ) ) {
					foreach( $messagebar_colors as $color ) {
						?>
						<div class="messagebar_colors" style="display: inline-block;margin-right: 10px;">
							<input type="checkbox" style="margin-top: -16px;" name="<?php echo $this->get_field_name( 'messagebar_colors' ); ?>[]" id="<?php echo $this->get_field_id( 'messagebar_colors' ); ?>" value="<?php echo $color; ?>" checked="checked">
							<div style="display: inline-block;width: 25px;height: 25px;background: <?php echo $color ?>"></div>
						</div>
						<?php
					}
				}

				?>
				<br />
				<input type="text" name="add_messagebar_colors" id="add_messagebar_colors" value="" /> <input type="button" name="add_messagebar_colors_button" id="add_messagebar_colors_button" value="Add" onClick="messagebarColorAdd()" />
			</p>
			<?php
		}
	}
}
