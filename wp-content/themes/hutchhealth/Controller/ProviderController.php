<?php

                     /**
                      * Methods that will be made available to all Controllers
                      * @since 2.2
                      * @author Mat Lipe
                      */



class ProviderController extends MvcFramework{
        
        /**
         * Will run only once on page load
         * @uses Must have this method
         */
        public function init(){
            
			
			$this->provider_init();
			$this->create_provider_taxonomy();


			//Add submenu page under Providers for publishing the provider listing page
			add_action('admin_menu', array( $this->Provider, 'register_provider_publish_page') );
		
		}
	

        
        /**
         * Will run right before the page is rendered
         * @uses Optional Method for using conditional/hooks etc that must be run later in the load
         */
        public function before(){


        	global $post;		
			
			//Individual Baby Page
			if( is_single() && (get_post_type() == 'provider') && is_main_query() ) {

				remove_action('genesis_loop','genesis_do_loop');
                add_filter( 'genesis_loop', array( $this, 'view_single' ) );

		        add_action( 'get_header', array( $this->Provider, 'unhook_ss_sidebars'), 99999);
		        add_action( 'genesis_sidebar', array( $this->Provider, 'provider_sidebar') );
			}

			//if( 'provider' == get_post_type() && is_archive() ) {
			if( is_post_type_archive( 'provider' )){
			
				// Force Full Width Layout
				add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
				add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

				remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
        		add_action( 'genesis_before_loop', array($this->Provider, 'provider_breadcrumbs' ));

	            remove_action('genesis_loop','genesis_do_loop');
				add_action( 'genesis_loop', array( $this->Provider, 'display_provider_list' ) );
				//add_action( 'genesis_loop', array( $this, 'view_archive' ) );
	        }


	        if( is_tax( 'specialty')) {
				// Force Full Width Layout
				add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
				add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

				add_action( 'get_header', array( $this->Provider, 'unhook_ss_sidebars'), 99999);
		        add_action( 'genesis_sidebar', array( $this->Provider, 'provider_sidebar') );

	            remove_action('genesis_loop','genesis_do_loop');
	            add_action( 'genesis_loop', array( $this, 'view_specialty' ) );
	        }
        	
        }

        public function provider_init(){

		    $provider_labels = array(
				'name' => __( 'Physicians', 'post type general name' ),
				'singular_name' => __( 'Physician', 'post type singular name' ),
				'add_new' => __('Add New Physician', 'Babies'),
				'add_new_item' => __('Add New Physician'),
				'all_items' => __('All Physicians'),
				'edit_item' => __('Edit Physicians'),
				'new_item' => __('New Physician'),
				'view_item' => __('View Physician'),
				'search_items' => __('Search Entries'),
				'not_found' => __('No Physician Found'),
				'not_found_in_trash' => __('No Entries Found in Trash'),
				'parent_item_colon' => __( 'Parent Collection' )
			);
		
			$args = array (
				'labels' => $provider_labels,
				'public' => true,	
				'has_archive' => 'physicians',
				'rewrite' => array('slug' => 'physician' ),	
				'hierarchical' => false,
				'menu_position' => 5,
				'query_var' => true,	
				'supports' => array('title', 'thumbnail', 'editor')
			);
			register_post_type('provider', $args);
		}

		function create_provider_taxonomy() {
			register_taxonomy('specialty', 'provider', array(
				'hierarchical' => true,
				'label' => 'Specialties',
				'singular_name' => 'Specialty',
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array('slug' => 'specialty')
			));
	    }
}