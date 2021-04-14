<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 * @author     Your Name <email@example.com>
 */
class Vimm_DM_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vimm-dm-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vimm-dm-admin.js', array( 'jquery' ), $this->version, false );
	}

	public function tinymce_buttons_vidoc( $buttons ) {
		array_push( $buttons, 'viDocmanager_button' );
		return $buttons;
	}

	public function tinymce_plugin_vidoc( $plugin_array ) {
	   $plugin_array['viDocmanager'] = plugins_url( '/js/vimm-dm-shortcodes.js', __FILE__ );
	   return $plugin_array;
	}

	public function tinymce_popup() {
		?>
			<html>
				<head>
					<title>Add a Document</title>
					<script type="text/javascript" src="/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
					<script type="text/javascript" src="/wp-admin/load-scripts.php?c=1&amp;load%5B%5D=jquery-core,jquery-migrate,utils,plupload,json2i&amp;ver=3.9.2"></script>
					<script src="http://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
					<link type="text/css" rel="stylesheet" href="/wp-includes/js/tinymce/skins/wordpress/wp-content.css?ver=4.0.1">
					<link type="text/css" rel="stylesheet" href="/wp-includes/js/tinymce/skins/lightgray/content.min.css">
					<link type="text/css" rel="stylesheet" href="/wp-includes/css/editor.min.css?ver=4.0.1" id="editor-buttons-css" media="all">
					<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans">
					<script>
						jQuery(document).ready(function ( $) {
							$('.insertDocButton').on('click', function(event) {
								$('#tabs-1 input[type=checkbox]').each(function () {
									if (this.checked) {
										var id = $(this).attr('id');
										var buildDocShortcode = '[vidoc ';
										if ( id != '' ) {
											buildDocShortcode += 'id="'+id+'"';
										}
										buildDocShortcode += ']';
										window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, buildDocShortcode );
									}
								});
								tinyMCEPopup.close();
							});

							$('.insertCatButton').on('click', function(event) {
								event.preventDefault();
								/* Act on the event */
								var id = $(this).attr('id');
								var id = $('input[name=viDocCat]:checked').val()
								var orderby = $('#orderby').val();
								var orderdir = $('#orderdir').val();
								var buildDocShortcode = '[vidoc ';
								if ( id != '' ) {
									buildDocShortcode += 'document_category="'+id+'"';
								}
								if ( orderby != 'Date' ) {
									buildDocShortcode += ' orderby="'+orderby+'"';
								}
								if ( orderdir != 'DESC' ) {
									buildDocShortcode += ' orderdirection="'+orderdir+'"';
								}

								buildDocShortcode += ']';

								window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, buildDocShortcode );
								tinyMCEPopup.close();
							});

							$('.tablink').on('click', function(event) {
								event.preventDefault();
								var activeTab = $(this).attr('href');
								$('.tablink-container li').each(function(index) {
									$(this).removeClass('active');
								});
								$('.tabpane').each(function(index) {
									$(this).hide();
								});
								$(this).parent().addClass('active');
								$(activeTab).show();
								/* Act on the event */
							});

							$('#document-search').on('keyup', function(event) {
								var search_term = $(this).val().toLowerCase();
								search_term = search_term.replace(/\s+/g, '');
								$( '#vi-document-container li' ).each(function(index, el) {
									var current_id = $(this).attr('id');
									if ( ! current_id.includes( search_term ) ) {
										$(this).addClass('hide');
									} else {
										$(this).removeClass('hide');
									}
								});
							});
						});
					</script>
					<style type="text/css">
						#vi-doc-manager-form-single ul,
						#vi-doc-manager-form-category ul {
							padding: 0;
							margin: 10px 0;
						}

						#vi-doc-manager-form-single ul li,
						#vi-doc-manager-form-category ul li,
						#vi-doc-manager-form-single ul li label,
						#vi-doc-manager-form-category ul li label {
							list-style-type: none;
							padding: 3px 0;
							margin: 0;
							cursor: pointer;
							padding-left: 0px;
							font-size: 16px;
							color: #4a4a4a;
							font-family: 'Open Sans', sans-serif;
							font-weight: normal;
						}
						#vi-doc-manager-form-single ul li.hide {
							display: none;
						}
						#tabs-2 {
							display: none;
						}
						.tablink-container {
							list-style-type: none;
							margin: 0;
							padding: 0;
						}
						.tablink-container li {
							display: inline-block;
							    padding: 9px 15px 9px 15px;
							background-color: #e9eaea;
						}
						.tabpane button {
							display: inline-block;
							background: #275f8e;
							border-color: #275f8e;
							border-radius: 5px;
							border: solid 2px #204d74;
							color: #fff;
							text-decoration: none;
							text-shadow: 0 -1px 1px #006799,1px 0 1px #006799,0 1px 1px #006799,-1px 0 1px #006799;
							padding: 6px 10px;
							font-size: 14px;
							line-height: 20px;
							cursor: pointer;
							margin-top: 20px;
						}
						.tablink-container li a,
						.tablink-container li a:hover {
							text-decoration: none;
							color: #7e7e7e;
							font-size: 16px;
							font-family: 'Open Sans', sans-serif;
							font-weight: 600;
						}
						.tablink-container li.active {
							    margin-bottom: 6px;
							    padding: 9px 15px 15px 15px;
							background-color: #fff;
							border-top: solid 2px #e2e2e2;
							border-left: solid 2px #e2e2e2;
							border-right: solid 2px #e2e2e2;
						}
						.tabpane label {
							margin-bottom: 20px;
							color: #333333;
							font-size: 18px;
							font-family: 'Open Sans', sans-serif;
							font-weight: 600;
						}
						.mce-container {
							margin: 0;
						}
						.tabpane > .mce-container-body {
							border: solid 2px #e2e2e2;
							padding: 20px;
							margin-top: -8px;
						}
						.tabpane .sort {
							margin-top: 13px;
						}
						.tabpane select {
						    background: #f7f7f7;
						    text-decoration: none;
						    line-height: 26px;
						    height: 28px;
						    margin: 0;
						    cursor: pointer;
						    border: 1px solid #ccc;
						    -webkit-appearance: none;
						    -webkit-border-radius: 3px;
						    border-radius: 3px;
						    white-space: nowrap;
						    -webkit-box-shadow: 0 1px 0 #ccc;
						    box-shadow: 0 1px 0 #ccc;
						    padding: 4px 13px;
						    font-size: 14px;
						    line-height: 20px;
						    cursor: pointer;
						    color: #333;
						    text-align: center;
						    overflow: visible;
						    -webkit-appearance: none;
						}
					</style>
				</head>
				<body>
				<div id="tabs">
					<ul class="tablink-container">
						<li class="active"><a class="tablink" href="#tabs-1">Document List</a></li>
						<li><a class="tablink" href="#tabs-2">Category List</a></li>
					</ul>
					<div class="tabpane" id="tabs-1">
						<div class="mce-container-body mce-abs-layout" id="vi-doc-manager-form-single">
							<div class="mce-container mce-form mce-first mce-last mce-abs-layout-item">
								<div class="mce-container-body mce-abs-layout">
									<div class="content mce-container mce-abs-layout-item mce-formitem" style="margin-top:10px;">
										<div class="mce-container-body mce-abs-layout">
											<label class="mce-widget mce-label mce-first mce-abs-layout-item">Search Documents:</label>
											<br />
											<input type="search" id="document-search" placeholder="search documents here..." />
											<br /><br />
											<label class="mce-widget mce-label mce-first mce-abs-layout-item">Select Documents:</label>
											<ul id="vi-document-container">
											<?php
												$args = array(
													'posts_per_page'   => -1,
													'orderby'          => 'date',
													'order'            => 'DESC',
													'post_type'        => 'vi-doc',
													'post_status'      => 'publish'
												);
												$myposts = get_posts( $args );
												foreach ( $myposts as $post ) : setup_postdata( $post );?>
													<?php
														$id = str_replace( ' ', '', strtolower(get_the_title( $post->ID )) );
														$id = preg_replace('/[^A-Za-z0-9\-]/', '', $id);

													?>

													<li id="<?php echo $id; ?>" class="singleDoc" id="<?php echo $post->ID ?>">
														<input type="checkbox"  id="<?php echo $post->ID ?>" />
														<label for="<?php echo $post->ID ?>"><?php echo get_the_title($post->ID); ?></label>
													</li>
												<?php endforeach; 
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<button class="insertDocButton" type="button">Insert into post</button>
					</div>
					<div class="tabpane" id="tabs-2">
						<div class="mce-container-body mce-abs-layout" id="vi-doc-manager-form-category">
							<div class="mce-container mce-form mce-first mce-last mce-abs-layout-item">
								<div class="mce-container-body mce-abs-layout">
									<div class="content mce-container mce-abs-layout-item mce-formitem" style="margin-top:10px;">
										<label class="mce-widget mce-label mce-first mce-abs-layout-item">Select a Document Category:</label>
										<div class="mce-container-body mce-abs-layout sort">
											<label class="mce-widget mce-label mce-first mce-abs-layout-item" style="line-height: 19px; height: 19px; font-size:14px;">Sort By:</label>
											<select id="orderby">
												<option>Date</topion>
												<option>Title</option>
											</select>
										</div>
										<div class="mce-container-body mce-abs-layout sort">
											<label class="mce-widget mce-label mce-first mce-abs-layout-item" style="line-height: 19px; height: 19px; font-size:14px;">Sort Direction:</label>
											<select id="orderdir">
												<option value="DESC">Z to A</topion>
												<option value="ASC">A to Z</option>
											</select>
										</div>
										<div class="mce-container-body mce-abs-layout">
											<?php
												$terms = get_terms( 'document_category' );
												if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
												    echo '<ul>';
												    foreach ( $terms as $term ) {
												    	echo '<li class="docCategory">';
												    		echo '<input type="radio" id="'.$term->slug.'" name="viDocCat" value="'.$term->slug.'">';
												    		echo '<label for="'.$term->slug.'">' . $term->name . '</label>';
												    	echo '</li>';
												    }
												    echo '</ul>';
												}
											?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<button class="insertCatButton" type="button">Insert into post</button>
					</div>
				</body>
			</html>
		<?php
		die();
	}

	public function vi_filter_post_type_by_taxonomy() {
		global $typenow;
		$post_type = 'vi-doc'; // change to your post type
		$taxonomy  = 'document_category'; // change to your taxonomy
		if ($typenow == $post_type) {
			$selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
			$info_taxonomy = get_taxonomy($taxonomy);
			wp_dropdown_categories(array(
				'show_option_all' => __("Show All {$info_taxonomy->label}"),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'show_count'      => true,
				'hide_empty'      => true,
			));
		};
	}

	public function vi_convert_id_to_term_in_query($query) {
		global $pagenow;
		$post_type = 'vi-doc'; // change to your post type
		$taxonomy  = 'document_category'; // change to your taxonomy
		$q_vars    = &$query->query_vars;
		if ( $pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
			$term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
			$q_vars[$taxonomy] = $term->slug;
		}
	}

	public function vi_custom_columns_head($defaults) {
		// we can remove columns
		unset($defaults['comments']);		
		unset($defaults['date']);
		//or we can add columns
	    $defaults['download_count'] = 'Download Count';
	    $defaults['password_protected'] = 'Password Protected';
	    $defaults['date'] = 'Date';
	    return $defaults;
	}

	public function vi_custom_sortable_columns_head($columns) {
	    $columns['download_count'] = 'Download Count';
	    $columns['password_protected'] = 'Password Protected';
	    return $columns;
	}

	public function vi_custom_columns_content($column_name, $post_ID) {
	    if ($column_name == 'download_count') {
	    	$column_data = get_post_meta( $post_ID, 'download_count', true );
	        if ( $column_data ) {
	            echo $column_data;
	        }
	    }
	    if ($column_name == 'password_protected') {
	    	$column_data = get_post_meta( $post_ID, 'password_protected', true );
	        if ( $column_data == '0' ) {
	            echo 'No';
	        }
	        if ( $column_data == '1' ) {
	        	echo 'Yes';
	        }
	    }
	}

	public function vi_custom_column_orderby( $query ) {
	    if( ! is_admin() )
	        return;

	    $orderby = $query->get( 'orderby');

	    if( 'download_count' == $orderby ) {
	        $query->set('meta_key','download_count');
	        $query->set('orderby','meta_value');
	    }

	    if( 'password_protected' == $orderby ) {
	        $query->set('meta_key','password_protected');
	        $query->set('orderby','meta_value');
	    }
	}

	public function vi_dm_search_query( $query ) {
	    if( ! is_admin() )
	        return;

	    if ( $query->query_vars['post_type'] != 'vi-doc' )
	    	return;

	    $custom_fields = array(
	        // put all the meta fields you want to search for here
	        "internal_notes"
	    );
	    $searchterm = $query->query_vars['s'];

	    // we have to remove the "s" parameter from the query, because it will prevent the posts from being found
		$query->query_vars['s'] = "";

		if ($searchterm != "") {
			$meta_query = array('relation' => 'OR');
			foreach($custom_fields as $cf) {
				array_push($meta_query, array(
					'key' => $cf,
					'value' => $searchterm,
					'compare' => 'LIKE'
				));
			}
			$query->set("meta_query", $meta_query);
		};
	}
}