<?php

 /**
  * Methods that will be made available to all Controllers
  * @since 2.2
  * @author Mat Lipe
  */

class NurseryController extends MvcFramework{

    /**
     * Will run only once on page load
     * @uses Must have this method
     */
    public function init(){
	
		  //add_action( 'genesis_before_sidebar_widget_area', array( $this->Model, 'sidebarNavMenu' ) ); // Display the Nav Menu
  
	
	      //Create custom post type for nursery
	      $this->nursery_init();
		  $this->create_nursery_taxonomy();
		  add_action( 'add_meta_boxes', array( $this, 'myplugin_add_custom_box') );
		  add_action( 'save_post', array( $this, 'nursery_save_postdata') );
		  //adds custom icons for nursery
          //add_action( 'admin_head', array( $this, 'nursery_icons') );	
		  
		  add_action( 'pre_get_posts', array( $this->Nursery, 'babies_by_month' ));	

		  //remove add to any default buttons on babies custom post type
		  add_filter( 'addtoany_sharing_disabled', array( $this->Nursery, 'addtoany_disable_sharing_on_babies' ));  				
																		
    }

    /**
     * Will run right before the page is rendered
     * @uses Optional Method for using conditional/hooks etc that must be run later in the load
     */
    public function before(){
    	
		global $post;
		
		//Individual Baby Page
		if( is_single() && (get_post_type() == 'nursery') && is_main_query() ) {
		
			remove_action('genesis_loop','genesis_do_loop');
			add_action( 'genesis_loop', array( $this, 'view_single' ) );
			
			remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
		    add_action( 'genesis_before_loop', array( $this, 'view_breadcrumb' ) );
			add_action( 'genesis_before_loop', array($this, 'view_single-years'));
			

			//add_filter( 'the_content', array( $this, 'view_single' ) );
			// add_action( 'genesis_before_post_content', array( $this, 'view_single' ) );
			
			//if(!is_admin()){
				add_action( 'wp_enqueue_scripts', array($this->Nursery,'lightbox_scripts') );
			//}
		}

		if (is_post_type_archive( 'nursery' ) ) {

			remove_action('genesis_loop','genesis_do_loop');
			add_action( 'genesis_loop', array( $this, 'view_archive' ) );

		    add_action( 'genesis_before_loop', array( $this, 'view_breadcrumb' ) );
			add_action( 'genesis_before_loop', array($this, 'view_single-years'));

			// add_filter( 'the_content', array( $this, 'view_archive' ) );
			add_filter( 'genesis_noposts_text', array( $this, 'no_posts_text') );
				
		}
    }

	function no_posts_text() {
	    echo '<span class="sorry-no-posts">No babies have been added for this month.</span>'; 
	}

	public function displayBabies(){
		
		//get babies for the month
		$babies = $this->Nursery->getBabies();
		
		
		var_dump($babies);
	}

	function nursery_init() {
	
		$nursery_labels = array(
			'name' => __( 'Nursery', 'post type general name' ),
			'singular_name' => __( 'Baby', 'post type singular name' ),
			'add_new' => __('Add New Baby', 'Babies'),
			'add_new_item' => __('Add New Baby'),
			'all_items' => __('All Babies'),
			'edit_item' => __('Edit Baby'),
			'new_item' => __('New Baby'),
			'view_item' => __('View Baby'),
			'search_items' => __('Search Entries'),
			'not_found' => __('No Babies Found'),
			'not_found_in_trash' => __('No Entries Found in Trash'),
			'parent_item_colon' => __( 'Parent Collection' )
		);
	
		$args = array (
			'labels' => $nursery_labels,
			'public' => true,	
			'has_archive' => 'babies',
			'rewrite' => array('slug' => 'baby' ),	
			'hierarchical' => false,
			'menu_position' => 5,
			'query_var' => true,	
			'supports' => array('title', 'thumbnail')
		);
		register_post_type('nursery', $args);
		
	}
	
	function create_nursery_taxonomy() {
		register_taxonomy('Gender', 'nursery', array(
			'hierarchical' => true,
			'label' => 'Gender',
			'singular_name' => 'Gender',
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array('slug' => 'gender')
		));
    }

	 //adds metabox to the main column on the post type edit screens
	function myplugin_add_custom_box() {
	    add_meta_box( 
	        'myplugin_sectionid',
	        __( 'Details', 'myplugin_textdomain' ),
	        array( $this, 'nursery_meta_box'),
	        'nursery' 
	    );
	}

	//creates the meta box for nursery
	function nursery_meta_box( $post ) {
		
		//use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
		
		$fields = array(
			array('parents', "Parents: "),
			array('delivered_by', "Delivered By: "),
			array('day', 'month', 'year', "Birthday: "),
			array('lbs', 'oz', "Weight: "),
			array('hour', 'minute', 'period', 'Time:'),
			array('message', "Message from the Family "),
			array('share', "Enable Social Sharing: ")
		);


	    
	    echo '<label for="'.$fields[0][0].'">'.$fields[0][1].'</label></td>
			  <input type="text" id="'.$fields[0][0].'" name="'.$fields[0][0].'" value="'.get_post_meta($post->ID, $fields[0][0], true).'" size="30" /> <BR>';
			  
	    //creates the length
		echo '<label for="'.$fields[2][0].'">'.$fields[1][1].'</label></td>
			  <input type="text" id="'.$fields[1][0].'" name="'.$fields[1][0].'" value="'.get_post_meta($post->ID, $fields[1][0], true).'" size="30" /><BR>';
		
		//creates the birthday fields
		echo '<label for="'.$fields[2][0].'">'.$fields[2][3].'</label>
			 '.date_picker(
			$fields[2][0], get_post_meta($post->ID, $fields[2][0], true), 
			$fields[2][1], get_post_meta($post->ID, $fields[2][1], true),
			$fields[2][2], get_post_meta($post->ID, $fields[2][2], true)).'<BR>';
		
		//creates the weights
		echo '<label for="'.$fields[3][0].'">'.$fields[3][2].'</label>
			  <input type="text" id="'.$fields[3][0].'" name="'.$fields[3][0].'" value="'.get_post_meta($post->ID, $fields[3][0], true).'" size="3" /> lbs 
			  <input type="text" id="'.$fields[3][1].'" name="'.$fields[3][1].'" value="'.get_post_meta($post->ID, $fields[3][1], true).'" size="3" /> oz<BR>';
		
		
		//creates the length
		/*echo '<label for="'.$fields[4][0].'">'.$fields[4][1].'</label>
			  <input type="text" id="'.$fields[4][0].'" name="'.$fields[4][0].'" value="'.get_post_meta($post->ID, $fields[4][0], true).'" size="20" /> inches<BR>';*/
		
		
		//creates the time picker fields
		echo '<label for="'.$fields[4][0].'">'.$fields[4][3].'</label>
			  '.time_picker(
			$fields[4][0], get_post_meta($post->ID, $fields[4][0], true), 
			$fields[4][1], get_post_meta($post->ID, $fields[4][1], true),
			$fields[4][2], get_post_meta($post->ID, $fields[4][2], true)).'<BR>';
		
		 
	    //creates the message
		echo '<label for="'.$fields[5][0].'">'.$fields[5][1].'</label><BR>
			  <textarea id="'.$fields[5][0].'" name="'.$fields[5][0].'"  cols="60" rows="4" />'.get_post_meta($post->ID, $fields[5][0], true).'</textarea><BR>';
			
		//enable sociable
		echo '<label for="'.$fields[6][0].'">'.$fields[6][1].'</label>
			  <input type="checkbox" name="'.$fields[6][0].'" value="checked" '.get_post_meta($post->ID, $fields[6][0], true).'/>';
		
	}

	function nursery_meta_box2( $post ) {
		
		//use nonce for verification
		wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
		
		$fields = array(
			array('parents', "Parents: "),
			array('delivered_by', "Delivered By: "),
			array('day', 'month', 'year', "Birthday: "),
			array('lbs', 'oz', "Weight: "),
			array('hour', 'minute', 'period', 'Time:'),
			array('message', "Message from the Family "),
			array('share', "Enable Social Sharing: ")
		);

		$nextRow = '</tr><tr>';
	    
	    echo '<tr><td><label for="'.$fields[0][0].'">'.$fields[0][1].'</label></td>
			  <td width="250"><input type="text" id="'.$fields[0][0].'" name="'.$fields[0][0].'" value="'.get_post_meta($post->ID, $fields[0][0], true).'" size="30" /> <BR></td>
			  <td></td></tr>';
			  
	    //creates the length
		echo '<tr><td><label for="'.$fields[2][0].'">'.$fields[1][1].'</label></td>
			  <td width="250"><input type="text" id="'.$fields[1][0].'" name="'.$fields[1][0].'" value="'.get_post_meta($post->ID, $fields[1][0], true).'" size="30" /> </td>
			  <td></td></tr>';
		
		//creates the birthday fields
		echo '<tr><td><label for="'.$fields[2][0].'">'.$fields[2][3].'</label></td>
			  <td>'.date_picker(
			$fields[2][0], get_post_meta($post->ID, $fields[2][0], true), 
			$fields[2][1], get_post_meta($post->ID, $fields[2][1], true),
			$fields[2][2], get_post_meta($post->ID, $fields[2][2], true)).'</td></tr>';
		
		//creates the weights
		echo '<tr><td><label for="'.$fields[3][0].'">'.$fields[3][2].'</label></td>
			  <td><input type="text" id="'.$fields[3][0].'" name="'.$fields[3][0].'" value="'.get_post_meta($post->ID, $fields[3][0], true).'" size="3" /> lbs 
			  <input type="text" id="'.$fields[3][1].'" name="'.$fields[3][1].'" value="'.get_post_meta($post->ID, $fields[3][1], true).'" size="3" /> oz</td></tr>';
		
		
		//creates the length
		/*echo '<tr><td><label for="'.$fields[4][0].'">'.$fields[4][1].'</label></td>
			  <td width="250"><input type="text" id="'.$fields[4][0].'" name="'.$fields[4][0].'" value="'.get_post_meta($post->ID, $fields[4][0], true).'" size="20" /> inches</td>
			  <td></td></tr>';*/
			  
			  
		//creates the time picker fields
		echo '<tr><td><label for="'.$fields[4][0].'">'.$fields[4][3].'</label></td>
			  <td>'.time_picker(
			$fields[4][0], get_post_meta($post->ID, $fields[4][0], true), 
			$fields[4][1], get_post_meta($post->ID, $fields[4][1], true),
			$fields[4][2], get_post_meta($post->ID, $fields[4][2], true)).'</td></tr>';
			
	    //creates the message
		echo '<tr><td align="top"><label for="'.$fields[5][0].'">'.$fields[5][1].'</label></td>
			  <td width="250"><textarea id="'.$fields[5][0].'" name="'.$fields[5][0].'"  cols="60" rows="4" />'.get_post_meta($post->ID, $fields[5][0], true).'</textarea inches</td>
			  <td></td></tr>';
			
		//enable sociable
		echo '<td><label for="'.$fields[6][0].'">'.$fields[6][1].'</label></td>
			  <td><input type="checkbox" name="'.$fields[6][0].'" value="checked" '.get_post_meta($post->ID, $fields[6][0], true).'/>'.$nextRow;
		
			
		echo '</tr></table>';
	}

	//saves our custom data

	function nursery_save_postdata() {
		
		global $post;
		
		//prevents this from getting erased by an AUTOSAVE
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post->ID;
		update_post_meta( $post->ID, 'delivered_by', $_POST['delivered_by']);
		update_post_meta( $post->ID, 'parents', $_POST['parents']);
		update_post_meta( $post->ID, 'hour', $_POST['hour']);
		update_post_meta( $post->ID, 'minute', $_POST['minute']);
		update_post_meta( $post->ID, 'period', $_POST['period']);
		update_post_meta( $post->ID, 'lbs', $_POST['lbs']);
		update_post_meta( $post->ID, 'oz', $_POST['oz']);
		update_post_meta( $post->ID, 'month', $_POST['month']);
		update_post_meta( $post->ID, 'day', $_POST['day']);
		update_post_meta( $post->ID, 'year', $_POST['year']);
		update_post_meta( $post->ID, 'message', $_POST['message']);
		update_post_meta( $post->ID, 'share', $_POST['share']);
		
	}	

	function nursery_icons() {
		?>
			<style type="text/css" media="screen">
				#menu-posts-nursery .wp-menu-image {
					background: url(<?php bloginfo('url') ?>/wp-content/themes/ortonville/images/cradle16.png) no-repeat 6px !important;
				}
				#menu-posts-nursery:hover > .wp-menu-image {
					background: url(<?php bloginfo('url') ?>/wp-content/themes/ortonville/images/cradle16color.png) no-repeat 6px !important;
				}
				.icon32-posts-nursery {
					background: url(<?php bloginfo('url') ?>/wp-content/themes/ortonville/images/cradle32.png) no-repeat !important;
				}
		    </style>
		<?php 
	}
}


//creates a date picker, used in the nursery custom post type
function date_picker( $dayFieldName, $day, $monthFieldName, $month, $yearFieldName, $year) {
    
	//$startyear = date("Y");
	$startyear = '2014';
	$endyear = date("Y"); 
	
	//if the year is not set, default to the current year ($endyear)
	if (strlen($year) == 0){
		$year = $endyear;
	}

    $months = array('','January','February','March','April','May',
    'June','July','August', 'September','October','November','December');

    //month dropdown
    $html = '<select name="'.$monthFieldName.'">';

    for($i = 1; $i <= 12; $i++) {
		if ($i == $month) {
			$html .= '<option value="'.$i.'" selected>'.$months[$i].'</option>';
		} else {
			$html .= '<option value="'.$i.'">'.$months[$i].'</option>';
		}
	}
    $html .= '</select>';
   
    //day dropdown
    $html .= '<select name="'.$dayFieldName.'">';
    for($i = 1; $i <= 31; $i++) {
		if ($i == $day) {
			$html .= '<option value="'.$i.'" selected>'.$i.'</option>';
		} else {
			$html .= '<option value="'.$i.'">'.$i.'</option>';
		}
	}
    $html .= '</select>';

    //year dropdown
    $html .= '<select name="'.$yearFieldName.'">';

    for($i = $startyear; $i <= $endyear; $i++) {      
		if ($i == $year) {
			$html .= '<option value="'.$i.'" selected>'.$i.'</option>';
		} 
		else {
			
			$html .= '<option value="'.$i.'">'.$i.'</option>';

		}
	}
    $html .= '</select>';

    return $html;
}


//creates a time picker, used in the nursery custom post type
function time_picker( $hourFieldName, $hour, $minuteFieldName, $minute, $periodFieldName, $period) {
    
    $periods = array('','AM','PM');

    //month dropdown
    $html = '<select name="'.$hourFieldName.'">';

    for($i = 1; $i <= 12; $i++) {
		if ($i == $hour) {
			$html.='<option value="'.$i.'" selected>'.$i.'</option>';
		} else {
			$html.='<option value="'.$i.'">'.$i.'</option>';
		}
	}
    $html .= '</select>';
   
    //day dropdown
    $html .= '<select name="'.$minuteFieldName.'">';
    for($i = 0; $i <= 60; $i++) {
		if ($i == $minute) {
			$html.='<option value="'.$i.'" selected>'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>';
		} else {
			$html.='<option value="'.$i.'">'.str_pad($i, 2, 0, STR_PAD_LEFT).'</option>';
		}
	}
    $html .= '</select>';

    //year dropdown
    $html .= '<select name="'.$periodFieldName.'">';

    for($i = 1; $i <= 2; $i++) {      
		if ($i == $period) {
			$html.='<option value="'.$i.'" selected>'.$periods[$i].'</option>';
		} else {
			$html.='<option value="'.$i.'">'.$periods[$i].'</option>';
		}
	}
    $html .= '</select>';

    return $html;
}