<?php

/**
* Methods that will be made available to all Controllers
* @since 2.2
* @author Mat Lipe
*/

class ProviderOpeningController extends MvcFramework{
        
    /**
     * Will run only once on page load
     * @uses Must have this method
     */
    public function init(){
		//Create custom post type for job opening
		$this->jobopening_init();
		$this->create_jobopening_taxonomy();
		add_action( 'add_meta_boxes', array( $this, 'jobopening_custom_box') );
		add_action( 'save_post', array( $this->JobOpening, 'jobopening_save_postdata') );


		add_action( 'post_submitbox_misc_actions', array( $this, 'view_active_box') );

		add_filter('manage_job-opening_posts_columns', array( $this, 'job_opening_post_list_columns' ) );
		add_action('manage_job-opening_posts_custom_column', array( $this->JobOpening, 'job_opening_post_list_column_output' ), 10, 2 );


		add_action( 'pre_get_posts', array( $this->JobOpening, 'get_active_openings' ));
	}
    
    /**
     * Will run right before the page is rendered
     * @uses Optional Method for using conditional/hooks etc that must be run later in the load
     */
    public function before(){
    	
    	global $post;
		
		if (is_post_type_archive( 'provider-opening' ) ) {
        	
			remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		    add_action( 'genesis_before_loop', array( $this, 'view_breadcrumb' ) );
			
			add_action('genesis_before_loop', array($this, 'view_top'));
			// add_filter( 'the_content', array( $this, 'view_archive' ) );

            remove_action('genesis_loop','genesis_do_loop');
            add_action( 'genesis_loop', array( $this, 'view_archive' ) );

			add_filter( 'genesis_noposts_text', array( $this, 'no_posts_text') );
		}

		if( is_single() && (get_post_type() == 'provider-opening') ) {

		  remove_action( 'genesis_before_post_content', 'genesis_post_info' );
		  remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
		  

		  //remove Yoast SEO canonical
		  add_filter( 'wpseo_canonical', '__return_false' ); 

		  //Add canonical that points to main job openings page
		  remove_action( 'wp_head','genesis_canonical', 5 );
		  remove_action( 'wp_head', 'rel_canonical' );
		  add_action( 'wp_head', array( $this->JobOpening, 'hook_canonical'), 5);
		  
		  //add the contact information so it appears via social sharing	
		  //add_action( 'the_content', array( $this, 'view_single' ) );
		  remove_action( 'genesis_post_content', 'genesis_do_post_content' );
		  add_action( 'genesis_after_post_content', array( $this, 'view_single' ) );
		  
		 /*$isActive =  get_post_meta($post->ID, 'job_active', true);
		 echo 'Active: ' . $post->ID;
		  if ($isActive == 1){
		  	remove_action( 'genesis_post_content', 'genesis_do_post_content' ); 
		  }
		  else{
		  	
		  }*/

		}
    }
	
	function no_posts_text() {
	    echo '<span class="sorry-no-posts">No provider opportunites are available at this time.</span>'; 
	}
	
	function job_opening_post_list_columns($defaults) {
		//get checkbox and title
		$output = array_slice ( $defaults, 0, 2 );
		 
		//Add a new column and label it
		$output['job_active' ] = 'Active';
		 
		//Add the rest of the default back onto the array
		$output = array_merge ( $output, array_slice( $defaults , 2 ) );

		//return
		return $output;
	}

	function jobopening_init() {

		$jobopening_labels = array(
			'name' => __( 'Provider Openings', 'post type general name' ),
			'singular_name' => __( 'Provider Opening', 'post type singular name' ),
			'add_new' => __('Add New Provider Opening', 'Provider Opening'),
			'add_new_item' => __('Add New Provider Opening'),
			'all_items' => __('All Provider Openings'),
			'edit_item' => __('Edit Provider Opening'),
			'new_item' => __('New Provider Opening'),
			'view_item' => __('View Provider Opening'),
			'search_items' => __('Search Entries'),
			'not_found' => __('No Provider Openings Found'),
			'not_found_in_trash' => __('No Provider Openings Found in Trash'),
			'parent_item_colon' => __( 'Parent Collection' )
		);
	
		$args = array (
			'labels' => $jobopening_labels,
			'public' => true,	
			'has_archive' => 'provider-openings',
			'rewrite' => array('slug' => 'provider-opening' ),	
			'hierarchical' => false,
			'menu_position' => 6,
			'query_var' => true,	
			'supports' => array('title', 'editor')
		);
		register_post_type('provider-opening', $args);
	}

	function create_jobopening_taxonomy() {
		register_taxonomy('provider_category', 'provider-opening', array(
			'hierarchical' => true,
			'label' => 'Provider Categories',
			'singular_name' => 'Provider Category',
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'provider-categories')
		));
    }
	
	function jobopening_custom_box() {
	    add_meta_box( 
	        'provideropenings_sectionid',
	        __( 'Application Contact', 'myplugin_textdomain' ),
	        array( $this, 'view_meta_box_output'),
	        'provider-opening' 
	    );
	}
}