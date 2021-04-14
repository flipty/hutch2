<?php

/**
 * This will create a new page under Genesis labeled VI SEO.
 * This will include easy to use functions that our SEO Expert (Steve Slater)
 * can use and make his life easier
 *
 *
 * @since 11/19/2014
 * @author Tyler Steinhaus
 */

// Setup Theme Settings
//include_once( get_template_directory() . '/lib/admin/child-theme-settings.php');

class vi_child_theme_seo_settings extends Genesis_Admin_Boxes {

	/**
	 * Create an admin menu item and settings page
	 *
	 * Constructor
	 *
	 * @since 10/21/2014
	 * @author Tyler Steinhaus
	 */
	function __construct() {

		$page_id = 'vivid-image-seo';
		$menu_ops = array(
			'submenu' => array(
				'parent_slug'	=>	'genesis',
				'page_title'	=>	'Vivid Image SEO Settings',
				'menu_title'	=>	'VI SEO'
			)
		);
		$page_ops = NULL;
		$settings_field = 'vi-seo';
		$default_settings = array(
			'canonical-tags'	=>	''
		);

		$this->create( $page_id, $menu_ops, array(), $settings_field, $default_settings );

		// Add add to sanitize setting fields
		//add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitization_filters' ) );

		// Enqueue script for vi_child_theme_settings
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
define( 'ASSETS', get_stylesheet_directory().'/lib.new/assets/' );
		// Include Excel Classes for Import
		include( ASSETS.'classes/PHPExcel.php' );
	}

	/**
	 * Use this as the settings admin callback to create an admin page with sortable metaboxes.
	 * Create a 'settings_boxes' method to add metaboxes.
	 *
	 * @since 1.8.0
	 */
	public function admin() {

		?>
		<div class="wrap genesis-metaboxes">
		<form method="post" action="options.php" enctype="multipart/form-data">

			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			<?php settings_fields( $this->settings_field ); ?>

			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<p class="top-buttons">
				<?php
				submit_button( $this->page_ops['save_button_text'], 'primary', 'submit', false, array( 'id' => '' ) );
				submit_button( $this->page_ops['reset_button_text'], 'secondary genesis-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) );
				?>
			</p>

			<?php do_action( "{$this->pagehook}_settings_page_boxes", $this->pagehook ); ?>

			<div class="bottom-buttons">
				<?php
				submit_button( $this->page_ops['save_button_text'], 'primary', 'submit', false, array( 'id' => '' ) );
				submit_button( $this->page_ops['reset_button_text'], 'secondary genesis-js-confirm-reset', $this->get_field_name( 'reset' ), false, array( 'id' => '' ) );
				?>
			</div>
		</form>
		</div>
		<script type="text/javascript">
			//<![CDATA[
			jQuery(document).ready( function ($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $this->pagehook; ?>');
			});
			//]]>
		</script>
		<?php

	}

	/**
	 * Modify our save so we can properly save our canonical tag array
	 *
	 * @since 11/19/2014
	 * @author Tyler Steinhaus
	 */
	function save( $newvalue, $oldvalue ) {

		// Canonical Tags
		$canonical_tags = array();
		for( $i = 0; $i <= count( $newvalue['canonical_cat'] ); $i++ ) {
			if( !empty( $newvalue['canonical_url'][$i] ) ) {
				$canonical_tags[$i]['cat'] = $newvalue['canonical_cat'][$i];
				$canonical_tags[$i]['url'] = $newvalue['canonical_url'][$i];
			}
		}

		unset( $newvalue['canonical_cat'] );
		unset( $newvalue['canonical_url'] );

		$newvalue['canonical-tags'] = $canonical_tags;

		// 301 Redirects
		$data = $newvalue['301_redirects'];
		$redirects = array();

		for($i = 0; $i < sizeof($data['request']); ++$i) {
			$request = trim($data['request'][$i]);
			$destination = trim($data['destination'][$i]);

			if ($request == '' && $destination == '') { continue; }
			else { $redirects[$request] = $destination; }
		}
		unset( $newvalue['301_redirects'] );

		// Check to see if a spreadsheet was uploaded, if so run through it and create the redirects
		if( $_FILES['fileupload']['tmp_name'] != '' ) {
			$spreadsheet = PHPExcel_IOFactory::load( $_FILES['fileupload']['tmp_name'] );

			$sheetData = $spreadsheet->getActiveSheet()->toArray(null,true,true,true);

			/**
			 * Correct Formating for the Uploaded Spreadsheet needs to look like.
			 * Column A: Old URL
			 * Column B: New URL
			 */

			// Run through each row on the table and sort out columns by Alphabet
			foreach( $sheetData as $column ) {
				$data['request'][] = $column['A'];
				$data['destination'][] = $column['B'];
			}

			for($i = 0; $i < sizeof($data['request']); ++$i) {
				$request = trim($data['request'][$i]);
				$destination = trim($data['destination'][$i]);

				if ($request == '' && $destination == '') { continue; }
				else { $redirects[$request] = $destination; }
			}
		}

		$newvalue['301_redirects'] = $redirects;

		unset( $_FILES['fileupload'] );

		return $newvalue;

	}

	/**
	 * Enqueue the scripts for this page
	 *
	 * @since 10/29/2014
	 * @author Tyler Steinhaus
	 */
	function enqueue_scripts( $hook ) {
		if( $hook == 'genesis_page_vivid-image-seo' ) {
			wp_enqueue_script( 'vi_child_theme_seo_settings', JS_ASSETS.'/seo_page.js', array( 'jquery' ) );
			wp_enqueue_style( 'vi_child_theme_seo_settings-style', CSS_ASSETS.'/seo_page.css' );
		}
	}

	/**
	 * Register metaboxes for our VI Theme Settings page
	 *
	 * @since 10/21/2014
	 * @author Tyler Steinhaus
	 */
	function metaboxes() {
		add_meta_box( 'seo-canonical', 'Canonical Tags', array( $this, 'canonical' ), $this->pagehook, 'main', 'high' );
		add_meta_box( 'seo-redirects', '310 Redirects', array( $this, 'redirects' ), $this->pagehook, 'main', 'high' );
	}

	/**
	 * We will create our metabox specifically for adding canonical tags to specific post types/categories
	 *
	 * @since 11/19/2014
	 * @author Tyler Steinhaus
	 */
	function canonical() {
		?>
		<p>
			<button id="add_canonical">Add Canonical</button>
			<ul class="canonical-list">
				<li class="rows title">
					<ul class="columns">
						<li class="remove"></li>
						<li class="category">Category</li>
						<li class="url">URL</li>
					</ul>
				</li>
				<?php
				$canonical_tag =  $this->get_field_value( 'canonical-tags' );

				if( !empty( $canonical_tag ) ) {
					foreach( $canonical_tag as $can_tag ) {
						?>
						<li class="rows">
							<ul class="columns">
								<li class="remove"><button class="remove_row">Remove</button></li>
								<li class="category"><?php wp_dropdown_categories( 'class=widefat&hide_empty=0&hierarchical=1&name='.$this->get_field_name( 'canonical_cat' ).'[]&selected='.$can_tag['cat'] ); ?></li>
								<li class="url"><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'canonical_url' ); ?>[]" class="" value="<?php echo $can_tag['url']; ?>" /></li>
							</ul>
						</li>
						<?php
					}
				}
				?>
				<li class="rows hide">
					<ul class="columns">
						<li class="remove"><button class="remove_row">Remove</button></li>
						<li class="category"><?php wp_dropdown_categories( 'class=widefat&hide_empty=0&hierarchical=1&name='.$this->get_field_name( 'canonical_cat' ).'[]' ); ?></li>
						<li class="url"><input type="text" class="widefat" name="<?php echo $this->get_field_name( 'canonical_url' ); ?>[]" class="" value="" /></li>
					</ul>
				</li>
			</ul>
		</p>
		<?php
	}

	/**
	 * This will create a metabox so we can add 301 redirects
	 *
	 * @since 11/20/2014
	 * @author Tyler Steinhaus
	 */
	function redirects() {
		?>
		<p>
			<div class="uploadform"><strong>Upload Spreadsheet:</strong> <input type="file" name="fileupload" /></div>
			<button id="add_redirect">Add 301 Redirect</button>
			<ul class="redirect-list">
				<li class="rows title">
					<ul class="columns">
						<li class="remove"></li>
						<li class="oldurl">Old URL</li>
						<li class="newurl">New URL</li>
					</ul>
				</li>
				<?php
				$redirects =  $this->get_field_value( '301_redirects' );
				$redirects_wildcard =  $this->get_field_value( '301_redirects_wildcard' );

				if( !empty( $redirects ) ) {
					foreach( $redirects as $request => $destination ) {
						?>
						<li class="rows">
							<ul class="columns">
								<li class="remove"><button class="remove_row">Remove</button></li>
								<li class="oldurl"><input type="text" class="widefat" name="<?php echo $this->get_field_name( '301_redirects' ); ?>[request][]" class="" value="<?php echo $request; ?>" /></li>
								<li class="newurl"><input type="text" class="widefat" name="<?php echo $this->get_field_name( '301_redirects' ); ?>[destination][]" class="" value="<?php echo $destination; ?>" /></li>
							</ul>
						</li>
						<?php
					}
				}
				?>
				<li class="rows hide">
					<ul class="columns">
						<li class="remove"><button class="remove_row">Remove</button></li>
						<li class="oldurl"><input type="text" class="widefat" name="<?php echo $this->get_field_name( '301_redirects' ); ?>[request][]" class="" value="" /></li>
						<li class="newurl"><input type="text" class="widefat" name="<?php echo $this->get_field_name( '301_redirects' ); ?>[destination][]" class="" value="" /></li>
					</ul>
				</li>
			</ul>
		</p>
		<?php
	}
}