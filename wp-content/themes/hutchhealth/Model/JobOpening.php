<?php
/**
 * The Page Model
 * @since 1.13.13
 * @author Mat Lipe
 */


class JobOpening extends Model{
	
	function jobopening_save_postdata() {
	
		global $post;
		
	
		//prevents this from getting erased by an AUTOSAVE
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post->ID;
			update_post_meta( $post->ID, 'other_name', $_POST['other_name']);
			update_post_meta( $post->ID, 'other_email', $_POST['other_email']);
			update_post_meta( $post->ID, 'other_mailing_address', $_POST['other_mailing_address']);
			update_post_meta( $post->ID, 'contactID', $_POST['contactID']);
				
		
		if($_POST['action'] == 'editpost'){
	        delete_post_meta($post->ID, 'job_active');
	    }

    	add_post_meta($post->ID, 'job_active', $_POST['job_active']);
	}
	
	function get_active_openings( $query ) {
        	
		if ( $query->is_main_query() && $query->is_post_type_archive( 'job-opening' ) && !is_admin() ) {

			//$query->set( 'meta_key', 'day' );
			$query->set( 'orderby', 'menu_order' );
  			$query->set( 'order', 'ASC' );
			
			
			$meta_query = array(
								array(
									'key' => 'job_active',
									'value' => 1
								)
							);

			
			$query->set('meta_query' , $meta_query); 
			
				    
	        // Display 50 posts for a custom post type called 'nursery'
	        $query->set( 'posts_per_page', 50 );
	        return;
	        }
	}
	
	function job_opening_post_list_columns($defaults) {
	    //get checkbox and title
	    $output = array_slice ( $defaults, 0, 2 );
	     
	    //Add a new column and label it
		$output['job_active' ] = 'Active';
	     
	    //Add the rest of the default back onto the array
	    $output = array_merge ( $output, array_slice( $defaults , 2 ) );
	    
		var_dump($output);
		exit();
		
	    //return
	    return $output; 
	}
	
	/**
	 * Display 'X' if Job Opening is active
	 * @param string $column
	 * @param int $post_id
	 * @since 5/2/14
	 */
	function job_opening_post_list_column_output( $column, $post_id ){

		if( $column == 'job_active' ){
	        $jobActive = get_post_meta( $post_id, 'job_active', true );
			
			if($jobActive == 1){
				echo 'X';
			}

	    }
	}
	
	function hook_canonical() {
	    
	    echo '<link rel="canonical" href="' .get_bloginfo('url'). '/job-openings/" />';
	}

}