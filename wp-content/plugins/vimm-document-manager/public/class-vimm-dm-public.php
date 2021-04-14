<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/public
 * @author     Your Name <email@example.com>
 */
class Vimm_DM_Public {
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vimm-dm-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vimm-dm-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'plugin_ajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => wp_create_nonce('1nl5U8m5q6WuDtNy'), ) );
	}

	//configure ACF
	public function vimm_dm_acf_settings_path( $path ) {
 	    // update path - looking for a server level path
 	    $path = dirname(__DIR__) . '/dep/acf/';
	    // return
	    return $path;
	}

	public function vimm_dm_acf_settings_dir( $dir ) {
	    // update path - looking for a url based path
	    $dir = plugin_dir_url( dirname(__FILE__) ) . 'dep/acf/';
	    // return
	    return $dir; 
	}

	public function vimm_dm_acf_menu() {
		return FALSE;
	}

	//Loading our field group
	public function vimm_dm_acf_add_field_groups() {
		acf_add_local_field_group(array (
			'key' => 'group_57fcfe949ef12',
			'title' => 'File Uploads',
			'fields' => array (
				array (
					'key' => 'field_57fcff0ed59f5',
					'label' => 'File Upload',
					'name' => 'file_upload',
					'type' => 'file',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'url',
					'library' => 'all',
					'min_size' => '',
					'max_size' => '',
					'mime_types' => '',
				),
				array (
					'key' => 'field_57fd034074a5d',
					'label' => 'Version',
					'name' => 'version',
					'type' => 'number',
					'instructions' => 'You can set a version number for this document to help keep track of updates and revisions.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '1.0',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array (
					'key' => 'field_57fe64feab078',
					'label' => 'Download Count',
					'name' => 'download_count',
					'type' => 'number',
					'instructions' => 'This represents the total number of times this document has been downloaded.',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 0,
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'min' => '0',
					'max' => '',
					'step' => '',
				),
				array (
					'key' => 'field_57fd4486626a9',
					'label' => 'Password Protected',
					'name' => 'password_protected',
					'type' => 'radio',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						0 => 'No',
						1 => 'Yes',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => 0,
					'layout' => 'horizontal',
					'return_format' => 'value',
				),
				array (
					'key' => 'field_57fd4472626a8',
					'label' => 'Document Password',
					'name' => 'document_password',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_57fd4486626a9',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
				array (
					'key' => 'field_57ffb2bf3118d',
					'label' => 'Manually Set Icon',
					'name' => 'manually_set_icon',
					'type' => 'radio',
					'instructions' => 'You can choose to manually set this documents icon. This step is optional.',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						0 => 'No',
						1 => 'Yes',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
					'return_format' => 'value',
				),
				array (
					'key' => 'field_57ffb07ec1b37',
					'label' => 'Choose an Icon',
					'name' => 'icon',
					'type' => 'radio',
					'instructions' => 'You can choose a specific icon to use with his document here.',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_57ffb2bf3118d',
								'operator' => '==',
								'value' => '1',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'choices' => array (
						'pdf' => '',
						'doc' => '',
						'xls' => '',
						'ppt' => '',
						'download' => '',
					),
					'allow_null' => 0,
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'vertical',
					'return_format' => 'value',
				),
				array (
					'key' => 'field_57fd030774a5c',
					'label' => 'Internal Notes',
					'name' => 'internal_notes',
					'type' => 'textarea',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => 'Insert notes about this document here.',
					'maxlength' => '',
					'rows' => '',
					'new_lines' => 'wpautop',
				),
			),
			'location' => array (
				array (
					array (
						'param' => 'post_type',
						'operator' => '==',
						'value' => 'vi-doc',
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

	public function vidoc_shortcode( $args, $content = NULL ) {
		// Set our default arguments if $args is empty
		$args = shortcode_atts( array(
			'id'					=>	'',
			'document_category'		=>	'',
			'orderby'				=>	'',
			'orderdirection'		=>	''
		), $args );

		// Create our output
		$post_args = array(
			'posts_per_page'   => -1,
			'orderby'          => 'date',
			'order'            => 'DESC',
			'post_type'        => 'vi-doc',
			'post_status'      => 'publish'
		);

		//let's see if we have an id set
		if( !empty( $args['id'] ) ) {
			$id = $args['id'];
			$id_args = array(
				'include'		   => $id
			);
			$post_args = array_merge($post_args, $id_args);
		}

		//let's see if we have a category set
		if( !empty( $args['document_category'] ) ) {
			$cat = $args['document_category'];
			$tax_args = array(
				'tax_query' => array(
					array(
						'taxonomy' => 'document_category',
						'field' => 'slug',
						'terms' => $cat
					)
				)
			);
			$post_args = array_merge($post_args, $tax_args);
		}

		if ( (empty($args['id']) && empty($args['document_category'])) || (!empty($args['id']) && !empty($args['document_category'])) ) {
			//well someone dropped the ball when making this shortcode so let's get out or here.
			return;
		}

		//let's see if we have an orderby set
		if( !empty( $args['orderby'] ) ) {
			$orderby = $args['orderby'];
			$orderby_args = array(
				'orderby'		   => strtolower($orderby)
			);
			$post_args = array_merge($post_args, $orderby_args);
		}

		//let's see if we have an order direction set
		if( !empty( $args['orderdirection'] ) ) {
			$orderdir = $args['orderdirection'];
			$orderdir_args = array(
				'order'		   => $orderdir
			);
			$post_args = array_merge($post_args, $orderdir_args);
		}

		$posts_array = get_posts( $post_args );

		//one output to rule them all
		$output = '';
		
		if ( $posts_array ) {
			//loop through our posts
			foreach ( $posts_array as $post ) : setup_postdata( $post );
				//reest our html var for each pass through the loop
				$html = '';
				
				$password_protected = get_field( 'password_protected', $post->ID);
				$file_url 			= get_field( 'file_upload', $post->ID );

				if ( !$file_url )  {
					//looks like there is no file attached to this post lets bail
					if ( current_user_can( 'edit_posts' ) ) {
						$error_message = '<div class="vidoc-container"><p class="error-message">Message for site editors and admins only: The document '. $post->ID .' has no file attached.</p></div>';
					}
					$output .= $error_message;
					continue;
				}

				if ( $password_protected == '1' ) {
					$file_url = '#'.$post->ID;
				}

				$icon_override 	= get_field( 'manually_set_icon', $post->ID );
				$icon_choice 	= get_field( 'icon', $post->ID );

				//check if the user wants to override auto icon detection and has choosen a new icon, if not proceed with auto detection.
				if ( $icon_override == '1' && $icon_choice != '' ) {
					$file_extension = $icon_choice;
				} else {
					$file_extension = get_field( 'file_upload', $post->ID );
					$file_extension = substr($file_extension, (strrpos($file_extension, '.')+1));			
				}

				switch ( $file_extension ) {
					case 'pdf':
						$extension_class = 'pdf';
						break;
					case 'doc':
					case 'docx':
						$extension_class = 'doc';
						break;
					case 'xls':
						$extension_class = 'xls';
						break;
					case 'gif':
						$extension_class = 'gif';
						break;
					case 'jpg':
						$extension_class = 'jpg';
						break;
					case 'mov':
						$extension_class = 'mpv';
						break;
					case 'mp3':
						$extension_class = 'mp3';
						break;
					case 'png':
						$extension_class = 'png';
						break;
					case 'wav':
						$extension_class = 'wav';
						break;
					case 'zip':
						$extension_class = 'zip';
						break;
					case 'ppt':
						$extension_class = 'ppt';
						break;
					case 'download':
						$extension_class = '';
						break;
					default:
						$extension_class = '';
					break;
				}

				$vidoc_elements = array(
					'title' 		=> get_the_title($post->ID),
					'content' 		=> wpautop(get_the_content($post->ID)),
					'fileurl' 		=> $file_url,
					'fileextension' => $extension_class,
					'id' 			=> $post->ID
				);
				$html .= '<div class="vidoc-container">';
					$html .= '<div class="vidoc-wrap">';
						$html .= '<div class="vidoc-element">';
							$html .= '<div class="vidoc-icon '.$vidoc_elements['fileextension'].'">';
								//$html .= '<a id="'.$vidoc_elements['id'].'" target="_blank" href="'.$vidoc_elements['fileurl'].'"></a>';
							$html .= '</div>';
							$html .= '<div class="vidoc-link">';
								$html .= '<a class="'.$vidoc_elements['id'].'" target="_blank" href="'.$vidoc_elements['fileurl'].'"><img src="'.plugin_dir_url( dirname(__FILE__) ) . 'public/images/download.png" alt="Click here to download the '.strtoupper($extension_class).'" /></a>';
							$html .= '</div>';
							$html .= '<div class="vidoc-content-wrapper">';
								$html .= '<div class="vidoc-title">';
									$html .= '<a class="'.$vidoc_elements['id'].'" target="_blank" href="'.$vidoc_elements['fileurl'].'">Download '.$vidoc_elements['title'].' ' . strtoupper($extension_class) . '</a>';
								$html .= '</div>';
								$html .= '<div class="vidoc-content">';
									$html .= $vidoc_elements['content'];
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';
				
				// Create a filter that allows us to modify the output
				$output .= apply_filters( 'vi_doc_template', $html, $vidoc_elements );
			endforeach;
			wp_reset_postdata();
		} else {
			//this post array is empty time to bail
			//looks like there is no file attached to this post lets bail
			if ( current_user_can( 'edit_posts' ) ) {
				$error_message = '<div class="vidoc-container"><p class="error-message">Message for site editors and admins only: The document '. $id .' does not exist.</p></div>';
			}
			return $error_message;			
		}
		return $output;	
	}

	public function password_check ( $data ) {

		// Force the passed id to an integer
		$post_id = intval($_POST['id']);
		$submitted_password = $_POST['password'];
		$post_args = array(
			'posts_per_page'   => -1,
			'post_type'        => 'vi-doc',
			'post_status'      => 'publish',
			'include'		   => $post_id
		);

		$posts_array = get_posts( $post_args );

		foreach ( $posts_array as $post ) : setup_postdata( $post );
			$file_password = get_field('document_password', $post->ID);
			if ( $file_password == $submitted_password ) {
				$file_url = get_field( 'file_upload', $post->ID );
				$post_id = $_POST['id'];
				$download_value = get_post_meta( $post_id, 'download_count', true );
				// Check if the custom field has a value.
				if ( $download_value != '' ) {
				    $download_value = $download_value + 1;
				}
				update_post_meta($post_id, 'download_count', $download_value);
				$response = array( 'fileurl' => $file_url, 'dc' => $download_value );
			} else {
				$response = array( 'fileurl' => 'false' );
			}
		endforeach;
	    wp_send_json( $response );
	}

	public function add_download_count( $data ) {
		$post_id = intval($_POST['id']);
		$download_value = get_post_meta( $post_id, 'download_count', true );
		// Check if the custom field has a value.
		if ( $download_value != '' ) {
		    $download_value = $download_value + 1;
		}
		update_post_meta($post_id, 'download_count', $download_value);
		die();
	}
}