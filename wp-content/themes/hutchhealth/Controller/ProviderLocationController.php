<?php

                     /**
                      * Methods that will be made available to all Controllers
                      * @since 2.2
                      * @author Mat Lipe
                      */



class ProviderLocationController extends MvcFramework{
        
        /**
         * Will run only once on page load
         * @uses Must have this method
         */
        public function init(){
            



            $provider_location_labels = array(
				'name' => __( 'Locations', 'post type general name' ),
				'singular_name' => __( 'Location', 'post type singular name' ),
				'add_new' => __('Add New Location', 'Babies'),
				'add_new_item' => __('Add New Location'),
				'all_items' => __('Locations'),
				'edit_item' => __('Edit Location'),
				'new_item' => __('New Location'),
				'view_item' => __('View Location'),
				'search_items' => __('Search Entries'),
				'not_found' => __('No Locations Found'),
				'not_found_in_trash' => __('No Entries Found in Trash'),
				'parent_item_colon' => __( 'Parent Collection' )
			);
		
			$args = array (
				'labels' => $provider_location_labels,
				'public' => true,	
				'has_archive' => false,
				'rewrite' => array('slug' => 'provider_location' ),	
				'hierarchical' => false,
				'show_in_menu' => 'edit.php?post_type=provider' ,
				'supports' => array('title', 'thumbnail')
			);

			register_post_type('provider_location', $args);


			
		/*$this->registerPostType( 'provider_location', 
								array( 'supports' => array( 'title','thumbnail' ),
										'exclude_from_search'  => true,
										'show_in_menu' => 'edit.php?post_type=provider' 
										) 
								);*/
		
		}	

        
        
        /**
         * Will run right before the page is rendered
         * @uses Optional Method for using conditional/hooks etc that must be run later in the load
         */
        public function before(){
        	
        }
		
		
		
        
}