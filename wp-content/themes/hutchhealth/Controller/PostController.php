<?php
          /**
           * Controller For the Basic Posts
           * @since 1.14.13
           * @author Mat Lipe
           * @uses should extend Controller
           */
    

class PostController extends Controller{
     /**
      * Init will always run on each page load
      * @uses must have this method
      */
     function init(){
     	
			remove_action( 'genesis_before_post_content', 'genesis_get_comments_template' );

    }   
	 
	 
	 function before(){
	 	
		global $post;
		
		if ( is_page_template('page_blog.php') || is_post_type_archive('post') || is_category() ) {
				
				
			remove_action( 'genesis_post_content', 'genesis_do_post_image' );
    		remove_action('genesis_post_content', 'genesis_do_post_content' );
	 		
			add_action( 'genesis_post_content', array( $this, 'view_archive' ) );
			add_filter( 'get_the_content_more_link', array( $this,'sp_read_more_link' ));

	 	}
		
		//add the contact information so it appears via social sharing	
		add_action( 'genesis_after_loop', array( $this, 'view_back-to-top' ) );

		if ( is_search() ) {

			remove_action( 'genesis_post_content', 'genesis_do_post_image' );
    		remove_action('genesis_post_content', 'genesis_do_post_content' );
    		remove_action('genesis_post_title', 'genesis_do_post_title');
	 		
			add_action( 'genesis_post_content', array( $this, 'view_search' ) );
			add_filter( 'get_the_content_more_link', array( $this,'sp_read_more_link' ));

			remove_action( 'genesis_after_post_content', 'genesis_post_meta' );
			remove_action( 'genesis_before_post_content', 'genesis_post_info' );
		}
	 }

	function sp_read_more_link() {
		return '... <a class="more-link" href="' . get_permalink() . '">Continue Reading</a>';
	}

}    