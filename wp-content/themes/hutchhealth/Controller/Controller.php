<?php

 /**
  * Methods that will be made available to all Controllers
  * @since 2.2
  * @author Mat Lipe
  */
class Controller extends MvcFramework{
        
    /**
     * Will run only once on page load
     * @uses Must have this method
     */
    public function init(){
		//sidebar menu based on page
		add_action( 'genesis_before_sidebar_widget_area', array( $this->Model, 'sidebarNavMenu' ) ); // Display the Nav Menu
    	add_filter( 'widget_categories_args', array( $this->Model, 'exclude_widget_categories'));

        add_action( 'wp_enqueue_scripts', array( $this->Model, 'vi_load_google_fonts' ) );
		
		add_action( 'wp_enqueue_scripts', array($this->Model,'ie_responsive_scripts') );
	
		//Handles formatting for primary navigation with two lines / styles
		//add_filter( 'wp_get_nav_menu_items', array($this->Model,'two_line_navigation'), 10, 3 );

		add_filter( 'wp_nav_menu_objects', array($this->Model, 'first_last_items' ), 10, 2 );

        add_action( 'genesis_before_header', array($this->Model, 'ada_links'));

        add_action( 'genesis_before_header', array($this->Model, 'top_search_bar'));
        add_action( 'genesis_before_header', array($this->Model, 'top_bar'));


        //Customize Search Text
        add_filter( 'genesis_search_text', array( $this->Model, 'customSearchText') );

        //Remove search button text
        add_filter( 'genesis_search_button_text', array( $this->Model, 'customSearchButtonText') );


        //add side tab to show 'How are we doing link?'
         add_action( 'genesis_after_loop', array( $this->Model, 'show_side_tab' ) );

         //add custom body class for ADA pages
         add_filter( 'body_class', array( $this->Model,'add_body_class_ada' ));
         
         //adjust labels for complex fields in Gravity Forms
	     add_filter( 'gform_field_content',  array( $this->Model, 'change_fields_content_ada' ), 10, 5 );

         add_filter( 'genesis_search_form', array( $this->Model, 'search_form_ada'), 10, 4);

         add_filter( 'vi_doc_template', array( $this->Model, 'vi_document_output'), 10, 2);

         add_action( 'genesis_footer', array( $this->Model, 'vi_language_footer'), 5 );


         //Shortcode to display COVID-19 Yellow Box message in widget
          add_shortcode( 'covid-19-yellow', array( $this->Model, 'covid_yellow' ) );
	}
    
    /**
     * Will run right before the page is rendered
     * @uses Optional Method for using conditional/hooks etc that must be run later in the load
     */
    public function before(){
        //add side tab to show 'How are we doing link?' to homepage
        if( is_home() ){
              add_action ('genesis_before_footer',array( $this->Model, 'show_side_tab' ));
        }

		if ( tribe_is_list_view() ){
    		//remove the breadcrumbs
    		remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
    		add_action( 'genesis_before_loop', array($this->Model, 'event_breadcrumbs' ));
    	} else {
    		add_filter( 'genesis_breadcrumb_args', array($this->Model,'child_breadcrumb_args' ));
    	}

        if ( tribe_is_month() ){
            // Force Full Width Layout
            add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
            add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
        }

        //Newsfeed changes
        if ( is_page_template('page_blog.php') || is_post_type_archive('post') || is_category() ) {
           //remove_action('genesis_before_loop', 'genesis_do_breadcrumbs');
           add_action( 'genesis_before_loop', array( $this->Model,'category_buttons'));
        }

        //Force Full Width on Search Results page
        if ( is_search() ){
            // Force Full Width Layout
            add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
            add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
        }

        //Remove post info from Locations
        if( (is_single() && (get_post_type() == 'wpseo_locations') && is_main_query() ) || is_post_type_archive('wpseo_locations') ) {
            remove_action( 'genesis_before_post_content', 'genesis_post_info' );
            remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
        }


        // COVID 19 Messaging for pages / posts
        //If this is page, display the COVID-19 message if it has been activated for the page (Blue or Yellow Box) (Added 3.19.2020)
        // if ( is_page() || is_single() ){
        //     add_action( 'genesis_before_content', array( $this->Model,'covid_19_message'));
        // }

        // if( is_post_type_archive( 'provider' ) ){
        //     add_action( 'genesis_before_content', array( $this->Model,'covid_19_message_output'));
        // }

        if ( is_page() ) {
            add_action( 'genesis_before_content_sidebar_wrap', array( $this->Model, 'page_hero_image' ), 21 );
        }
	}
}