<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0
 *
 * @package    vimm_dm
 * @subpackage vimm_dm/admin
 */

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    vimm_dm
 * @subpackage vimm_dm/admin
 * @author     Your Name <email@example.com>
 */
class Vimm_DM_CPT {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;


	private $cpt_name = 'VI Doc';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 * @var      string    $plugin_name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function register_custom_post_type() {

		// Uppercase Words
		$title = ucwords( str_replace( '_', '', $this->cpt_name ) ); 

		// Sanitize the title
		$sanitized_title = sanitize_title( $title );

		// Check to see if the title is plural
		$plural_title = $this->pluralTitle( $title );

		// Generate our labels
		$labels = array(
			'name' 					=> $plural_title,
			'singular_name' 		=> $title,
			'menu_name' 			=> $plural_title,
			'all_items' 			=> sprintf( 'All %s', $plural_title ),
			'add_new'				=> sprintf( 'Add New %s', $title ),
			'add_new_item'			=> sprintf( 'Add New %s', $title ),
			'edit_item'				=> sprintf( 'Edit %s', $title ),
			'new_item'				=> sprintf( 'New %s', $title ),
			'view_item'				=> sprintf( 'View %s', $title ),
			'search_items'			=> sprintf( 'Search %s', $plural_title ),
			'not_found'				=> sprintf( 'No %s found', $plural_title ),
			'not_found_in_trash'	=> sprintf( 'No %s found in trash', $plural_title ),
			'parent_item_colon'		=> sprintf( 'Parent %s:', $title )
		);

		// Generate our default args
		$defaults = array(
			'labels'				=> $labels,
			'description'			=> null,
			'public'				=> true,
			'exclude_from_search' 	=> true,
			'publicly_queryable'	=> true,
			'show_ui'				=> true,
			'show_in_nav_menus'		=> false,
			'show_in_menu'			=> true,
			'show_in_admin_bar'		=> true,
			'menu_position'			=> null,
			'menu_icon'				=> 'dashicons-admin-page',
			'capability_type'		=> 'post',
			'capabilities'			=> array(),
			'map_meta_cap'			=> true,
			'hierarchical'			=> false,
			'supports'				=> array( 
										'title', 
										'editor'
									),
			'register_meta_box_cb'	=> null,
			'taxonomies'			=> array(),
			'has_archive'			=> false,
			'rewrite'				=> array(
										'slug' => 'vidoc'
									),
			'can_export'			=> true
		);

		// Let's finally register our post type
		register_post_type( $sanitized_title, $defaults );
	}

	public function register_custom_post_type_taxonomies() {
		$sanitized_title = sanitize_title( $this->cpt_name );
		// Add new taxonomy, make it hierarchical (like categories)
		$labels = array(
			'name'              => _x( 'Document Categories', 'taxonomy general name' ),
			'singular_name'     => _x( 'Document Category', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Document Categories' ),
			'all_items'         => __( 'All Document Categories' ),
			'parent_item'       => __( 'Parent Document Category' ),
			'parent_item_colon' => __( 'Parent Document Category:' ),
			'edit_item'         => __( 'Edit Document Category' ),
			'update_item'       => __( 'Update Document Category' ),
			'add_new_item'      => __( 'Add New Document Category' ),
			'new_item_name'     => __( 'New Document Category Name' ),
			'menu_name'         => __( 'Document Category' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'document_category' ),
		);

		register_taxonomy( 'document_category', array( $sanitized_title ), $args );
	}

	public function pluralTitle( $title ) {
		$end = substr( $title, -1 );
		if( $end == 's' ) {
			$title = $title.'es';
		} elseif( $end == 'y' ) {
			$title = $end.'ies';
		} else {
			$title = $title.'s';
		}

		return $title;
	}

	public function custom_post_type_template( $single ) {
		global $wp_query, $post;

		/* Checks for single template by post type */
		if ( $post->post_type == 'vi-doc' ) {
			if ( file_exists( plugin_dir_path( __FILE__ ) . 'partials/class-vimm-dm-cpt-single.php' ) ) {
				return plugin_dir_path( __FILE__ ) . 'partials/class-vimm-dm-cpt-single.php';
			}
		}

		return $single;
	}

	public function vidoc_cpt_layout() {
		if( 'vi-doc' == get_post_type() ) {
			return 'full-width-content';
		}
	}


}