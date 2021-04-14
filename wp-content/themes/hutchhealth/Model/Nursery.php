<?php
                    /**
                     * The Page Model
                     * @since 1.13.13
                     * @author Mat Lipe
                     */


class Nursery extends Model{

	
	
	function babies_by_month( $query ) {
        	
		if ( $query->is_main_query() && $query->is_post_type_archive( 'nursery' ) && !is_admin() ) {

			
			$babyYear =  date('Y');
			$babyMonth =  date('n');
			
			$lastYear = 2014;
			$lastMonth = 12;
			
			$thisMonth = filter_input(INPUT_GET, 'month');
			if( is_numeric($thisMonth) && $thisMonth > 0 && $thisMonth <= 12 ){
				$babyMonth =  $thisMonth;		
			}


			/* ADDED 1-5-2014 to show December 2014 babaies*/
			$thisYear = $_GET['y'];
			if( is_numeric($thisYear) ) {
				$babyYear =  $thisYear;	
			}

			
			
			$query->set( 'meta_key', 'day' );
			$query->set( 'orderby', 'meta_value_num' );
  			$query->set( 'order', 'DESC' );
			
			$meta_query = array(
							'relation'	=> 'AND',
								array(
									'key' => 'month',
									'value' => $babyMonth
								),
								array(
									'key' => 'year',
									'value' => $babyYear
								)
							);
			// $meta_query = array(
								// array (
									// array( 
										// 'key' => 'month', 
										// 'value' => array( $babyMonth, $lastYear ) 
									// ),
									// array( 
										// 'key' => 'year', 
										// 'value' => array( $babyYear, $lastYear ) 
									// )
								// )
							// );


			
			$query->set('meta_query' , $meta_query); 
			
				    
	        // Display 50 posts for a custom post type called 'nursery'
	        $query->set( 'posts_per_page', 50 );
	        return;
	        }
	}
	
	
	
	function lightbox_scripts() {
		
		wp_enqueue_style( 'lightbox-styles', THEME_DIR . '/lib/assets/css/lightbox.css' );
		wp_enqueue_script( 'lightbox', THEME_JS . 'responsive-lightbox.js', array(), '1.0.0', true );
		wp_enqueue_script( 'lightbox-babies', THEME_JS . 'babies-lightbox.js', array(), '1.0.0', true );
	}
	
	

	function addtoany_disable_sharing_on_babies() {
	    if ( 'nursery' == get_post_type() ) {
	        return true;
	    }
	}
	
	
    
}
    