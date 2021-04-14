<?php
/**
 * Controller for Board Members
 * @author Justin McGuire
 */

class BoardMembersController extends Controller{
     /**
      * Init will always run on each page load
      */
    function init(){
     	
		$title = "Board Member";
		$pluralTitle = "Board Members";
		
		//Create Custom Post Type
	     $this->registerPostType( 'boardmembers', 
								array( 'supports' => array( 'title', 'thumbnail' ),
										'exclude_from_search'  => true,
										'has_archive' => true,
										'labels' => array(
									                        'name'                       => $pluralTitle,
									                        'singular_name'              => $title,
									                        'menu_name'                  => $pluralTitle,
									                        'all_items'                  => sprintf( 'All %s' , $pluralTitle),
									                        'add_new'                    => sprintf( 'Add %s', $title ),
									                        'add_new_item'               => sprintf( 'Add  %s' , $title),
									                        'edit_item'                  => sprintf( 'Edit %s', $title ),
									                        'new_item'                   => sprintf( '%s', $title ),
									                        'view_item'                  => sprintf( 'View %s', $title ),
									                        'search_items'               => sprintf( 'Search %s', $pluralTitle ),
									                        'not_found'                  => sprintf( 'No %s found', $pluralTitle ),
									                        'not_found_in_trash'         => sprintf( 'No %s found in trash', $pluralTitle ),
									                        'parent_item_colon'          => sprintf( 'Parent %s:', $title ),   
									                ),
										'rewrite' => array( 'slug' => 'about/board-of-directors'),
										) 
								);

		add_image_size( 'boardmember', 163, 228, true );

		add_action( 'pre_get_posts', array( $this->BoardMembers, 'adjust_query' ));	

    }

	function before() {
        if( 'boardmembers' == get_post_type() && ( is_tax() || is_archive() ) ) {
			// Force Full Width Layout
			add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
			add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
            remove_action('genesis_loop','genesis_do_loop');
            add_action( 'genesis_loop', array( $this, 'view_boardmembersarchive' ) );
        }

        if( is_single() && 'boardmembers' == get_post_type() ) {
			// Force Full Width Layout
			add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
			add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
            remove_action('genesis_loop','genesis_do_loop');
            add_action( 'genesis_loop', array( $this, 'view_boardmemberssingle' ) );
        }
	}

}