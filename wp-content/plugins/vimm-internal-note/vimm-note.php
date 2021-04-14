<?php
/*
* Plugin Name: Vimm Internal Page & Post Notes
* Plugin URI: http://www.vimm.com
* Description: Creates a meta field on pages and posts to store internal notes
* Author: Vivid Image Development Team 
* Version: 1.2
* Author URI: http://www.vimm.com
* GitHub Plugin URI: https://github.com/VividImage/vimm-internal-note
*/


/** Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) exit( 'Cheatin&#8217; uh?' );

class Vimm_Note {
	/*--------------------------------------------*
	 * Attributes
	 *--------------------------------------------*/

	/** Refers to a single instance of this class. */
	private static $instance = null;

	public $field_read_only = 0;

	/**
	 * Creates or returns an instance of this class.
	 *
	 * @return  Vimm_Note A single instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	} // end get_instance;

	/**
	 * Initializes the plugin by setting localization, filters, and administration functions.
	 */
	private function __construct() {
		//if ACF is already installed let's not mess with things
		if( ! class_exists('acf') ) {
			add_filter( 'acf/settings/path', array($this, 'vimm_note_acf_settings_path') );
			add_filter( 'acf/settings/dir', array($this, 'vimm_note_acf_settings_dir') );
			add_filter( 'acf/settings/show_admin', array($this, 'vimm_note_acf_menu') );

			require_once plugin_dir_path( __FILE__ ) .  '/dep/acf/acf.php';
		}
		
		add_action( 'acf/init', array($this, 'user_capability_check'));

		add_action( 'acf/init', array($this, 'vimm_note_acf_add_field_groups') );	

	} // end constructor
 
	/*--------------------------------------------*
	 * Functions
	 *--------------------------------------------*/

	static function vimm_note_deactivate() {

	}

	static function vimm_note_activation() {

	}
	 
	function vimm_note_acf_settings_path( $path ) {
	 
	    // update path
	    $path = dirname(__DIR__) .  'dep/acf/';
	    
	    // return
	    return $path;
	    
	}

	function vimm_note_acf_settings_dir( $dir ) {
	 
	    // update path
	    $dir = plugin_dir_url( __FILE__ ) . '/dep/acf/';
	    
	    // return
	    return $dir;
	    
	}

	function vimm_note_acf_menu() {
		return FALSE;
	}

	function user_capability_check() {
		if ( !current_user_can( 'manage_options' ) ) {
			$this->field_read_only = 1;
		}		
	}

	//Loading our field group
	public function vimm_note_acf_add_field_groups() {
		acf_add_local_field_group(array(
			'key' => 'group_5aa7f2eb73c4f',
			'title' => 'VI Internal Notes',
			'fields' => array(
				array(
					'key' => 'field_5aa7f2faafde5',
					'label' => 'Internal SEO Notes',
					'name' => 'internal_seo_notes',
					'type' => 'textarea',
					'instructions' => 'Keep internal seo notes about this post or page here.',
					'required' => 0,
					'conditional_logic' => 0,
					'readonly' => $this->field_read_only,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'maxlength' => '',
					'rows' => 12,
					'new_lines' => 'wpautop',
				),
			),
			'location' => array(
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'post',
					),
				),
				array(
					array(
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'page',
					),
				),
			),
			'menu_order' => 0,
			'position' => 'normal',
			'style' => 'default',
			'label_placement' => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen' => '',
			'active' => 1,
			'description' => '',
		));
	}

}

register_activation_hook( __FILE__, array( 'Vimm_Note', 'vimm_note_activation' ) );
register_deactivation_hook( __FILE__, array( 'Vimm_Note', 'vimm_note_deactivate' ) );

Vimm_Note::get_instance();
?>