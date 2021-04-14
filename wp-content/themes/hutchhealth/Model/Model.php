<?php

                 /**
                  * Methods which can be Used on all Models
                  * @since 1.7.13
                  * @author Mat Lipe
                  * @uses Extend your Model Class with This one
                  */
class Model extends MvcFramework{
    
    function vi_load_google_fonts() {
        //SAMPLE Enque for reference
        wp_enqueue_style( 'google-font-ritter', '//fonts.googleapis.com/css?family=Bitter:400,700,400italic' );
        wp_enqueue_style( 'google-font-releway', '//fonts.googleapis.com/css?family=Raleway:400,500,600,700' );
        wp_enqueue_style( 'google-font-karla', '//fonts.googleapis.com/css?family=Karla:400,400italic,700,700italic' );
    } 
	
	function sidebarNavMenu() {
		global $post;
		
		$ancestors = get_post_ancestors( $post->ID );
		
	
		//Display menu on non-blog pages
		if ( !$this->isBlogPage() ){
		
			if ( class_exists( 'Tribe__Events__Main' ) && tribe_is_event_query() ){

				echo '<div id="nav_menu" class="widget widget_nav_menu"><div class="widget-wrap">';
					//echo '<h4 class="widget-title widgettitle">Event Categories</h4>';
					echo wp_list_categories('taxonomy=tribe_events_cat&&title_li=<h4 class="widget-title widgettitle">' . __('Event Categories') . '</h4>');
				echo '</div></div>';

			} 
		
		}
	}


	function sidebarNavMenu2() {
		global $post;
		
		$ancestors = get_post_ancestors( $post->ID );
		
	
		//Display menu on non-blog pages
		if ( !$this->isBlogPage() ){
		
		
		echo '<div id="nav_menu" class="widget widget_nav_menu"><div class="widget-wrap">';

		
		if( $post->ID == 2 ||  $post->post_parent == 2 || in_array( 2, $ancestors ) || is_post_type_archive( 'nursery' ) || (get_post_type() == 'nursery') ) {
			// Patients & Visitors
			echo '<h4 class="widget-title widgettitle"><a href="/patients-visitors/">Patients & Visitors</a></h4>';
			wp_nav_menu( array( 'menu' => 'Patients & Visitors', 'depth' => 3 ) );
			
		} elseif( $post->ID == 140 || $post->post_parent == 140 || in_array( 140, $ancestors ) ) {
			// Medical Services
			echo '<h4 class="widget-title widgettitle"><a href="/medical-services/">Medical Services</a></h4>';
			wp_nav_menu( array( 'menu' => 'Medical Services', 'depth' => 3 ) );
				
		} elseif( $post->ID == 8 || $post->post_parent == 8 || in_array( 8, $ancestors )  ) {
			// Information on Health & Wellness
			echo '<h4 class="widget-title widgettitle"><a href="health-information-and-wellness/">Information on Health & Wellness</a></h4>';
			wp_nav_menu( array( 'menu' => 'Information on Health & Wellness', 'depth' => 3 ) );
			
		} elseif( $post->ID == 142 || $post->post_parent == 142 || in_array( 142, $ancestors )  ) {
			// Location & Hours
			echo '<h4 class="widget-title widgettitle"><a href="/locations_hours/">Location & Hours</a></h4>';
			wp_nav_menu( array( 'menu' => 'Location & Hours', 'depth' => 3 ) );
			
		} elseif( $post->ID == 183 || $post->post_parent == 183 || in_array( 183, $ancestors )  ) {
			// Community
			echo '<h4 class="widget-title widgettitle"><a href="/community/">Community</a></h4>';
			wp_nav_menu( array( 'menu' => 'Community', 'depth' => 3 ) );
			
		} elseif( $post->ID == 141 || $post->post_parent == 141 || in_array( 141, $ancestors ) || is_post_type_archive( 'job-opening' ) || (get_post_type() == 'job-opening') ) {
			// Careers
			echo '<h4 class="widget-title widgettitle"><a href="/career-center/">Careers</a></h4>';
			wp_nav_menu( array( 'menu' => 'Careers', 'depth' => 3 ) );
			
		} elseif( $post->ID == 546 || $post->post_parent == 546 || in_array( 546, $ancestors )  ) {
			// Quality & Safety
			echo '<h4 class="widget-title widgettitle"><a href="/quality-safety/">Quality & Safety</a></h4>';
			wp_nav_menu( array( 'menu' => 'Quality & Safety', 'depth' => 3 ) );
		
		} elseif ( class_exists( 'Tribe__Events__Main' ) && tribe_is_event_query() ){

				//echo '<h4 class="widget-title widgettitle">Event Categories</h4>';
				echo wp_list_categories('taxonomy=tribe_events_cat&&title_li=<h4 class="widget-title widgettitle">' . __('Event Categories') . '</h4>');

		} elseif ( (get_post_type() == 'provider') ){
			//About
			echo '<h4 class="widget-title widgettitle">Provider</h4>';
			echo '<ul class="menu"><li><a href="/providers/">By Specialty</a></li><li><a href="/providers/?displayBy=name">By Name</a></li></ul>';
		
		} else{
			//About
			echo '<h4 class="widget-title widgettitle">About</h4>';
			wp_nav_menu( array( 'menu' => 'About', 'depth' => 3 ) ); 
		}
		
		echo '</div></div>';
		
		}
	}

    function exclude_widget_categories($args){

		//Removed 'Featured' category from displaying from list of categories
		$cat = get_term_by( 'slug', 'featured', 'category' );
		$exclude = $cat->term_id;

		$args["exclude"] = $exclude;
		return $args;
	}

	function ie_responsive_scripts(){
		
		if( strpos( $_SERVER['HTTP_USER_AGENT'], 'MSIE 8' ) ){
			
		  //wp_enqueue_script( 'ie_responsive', THEME_JS . 'respond.min.js', array(), '1.0.0', true );
			wp_enqueue_script( 'ie_responsive', THEME_JS . 'ie8_responsive.js', array(), '1.0.0', true );
		}


		wp_enqueue_script( 'searchJS', THEME_JS . 'searchJs.js', array(), '1.0.0', true );
		wp_enqueue_script( 'childJS', THEME_JS . 'childJs.js', array(), '1.0.0', true );
	}
	
	function search_posts_filter( $query ){
			
		
	    if ($query->is_search){
	        $query->set('post_type',array('post','custom_post_type1', 'custom_post_type2'));
	    }
	    return $query;
	}
	
	function top_bar() {
		return vimm_dynamic_sidebar( 'Top Bar', true, true );
	}

	function top_search_bar() {
		return vimm_dynamic_sidebar( 'Top Search Bar', true, true );
	}

	function vi_language_footer() {
		return vimm_dynamic_sidebar( 'Language Footer', true, true );	
	}

	function ada_links() {

		global $wp;
        
        $currentURL = add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );

			?>
			<style type="text/css">

				.screen-reader-text,
				.screen-reader-text span,
				.screen-reader-shortcut {
					position: absolute !important;
					clip: rect(0, 0, 0, 0);
					height: 1px;
					width: 1px;
					border: 0;
					overflow: hidden;
				}

				.screen-reader-text:focus,
				.screen-reader-shortcut:focus,
				.genesis-nav-menu .search input[type="submit"]:focus,
				.widget_search input[type="submit"]:focus  {
					clip: auto !important;
					height: auto;
					width: auto;
					display: block;
					font-size: 1em;
					font-weight: bold;
					padding: 15px 23px 14px;
					color: #333;
					background: #fff;
					z-index: 100000; /* Above WP toolbar. */
					text-decoration: none;
					box-shadow: 0 0 2px 2px rgba(0,0,0,.6);
				}

				 ul.genesis-skip-link {
					height: 0;
					width: 0;
					margin: 0;
					padding: 0;
				}

				ul.genesis-skip-link  li {
					height: 0;
					width: 0;
					list-style: none;
					line-height: 0;
					margin: 0;
				}
				</style>
				<?php


	    echo '<section><h2 class="screen-reader-text">Skip links</h2><ul class="genesis-skip-link">';
		echo '<li><a href="#inner" class="skip screen-reader-shortcut" tabindex="2">Skip to content</a></li>';
		echo '<li><a href="#nav" class="skip screen-reader-shortcut" tabindex="3">Skip to primary navigation</a></li>';
		echo '<li><a href="#footer-widgets" class="skip screen-reader-shortcut" tabindex="4">Skip to footer</a></li>';
		echo '</section>';

		$isADA = filter_input(INPUT_GET, 'ada');
		if( !is_numeric($isADA) ){
		  echo '<a class="skip" tabindex="1" href="' . $currentURL .  '/?ada=1">View ADA compliant version of this page</a>';	
		}

	}

	//adding label to search form
	function search_form_ada( $form, $search_text, $button_text ) {

	    $onfocus = " onfocus=\"if (this.value == '$search_text') {this.value = '';}\"";
	    $onblur = " onblur=\"if (this.value == '') {this.value = '$search_text';}\"";
	    $form = '<form method="get" class="searchform search-form" action="' . home_url() . '/" >
	    <label class="search-form-label screen-reader-text" for="s">Search this website</label>
	    <input id="s" type="search" value="' . esc_attr( $search_text ) . '" name="s" class="s search-input"' . $onfocus . $onblur . ' />
	    <input type="submit" class="searchsubmit search-submit" value="' . esc_attr( $button_text ) . '" />
	    </form>';
	 
	    return $form;
	 
	}

	// Search Text
    function customSearchText( $text ) {
        return esc_attr( 'enter your search...' );
    }

    // Search Button Text
    function customSearchButtonText( $text ) {
        return esc_attr( 'Search' );
    }

    function category_buttons() {

    	$catID = get_query_var( 'cat' );

    	if ( $catID == '2435' || in_array('2435', get_ancestors( $catID, 'category' )) ) {
			$exclude = array(2431,2496,2437,2477,34,5,19,11,27,110,21,20,18,26);
			// $exclude = array(5,2352,2282,2289,2283,2293,2294,2288,2292,2299);
    	} elseif( $catID == '2428' || in_array('2428', get_ancestors( $catID, 'category' )) )  {
			$exclude = array(2478,2486,2432,2495,2433,2434,2436,2479,2455,34,5,19,11,27,110,21,20,18,26);
    	} else {
			$exclude = array(5,2428);
    	}
    	
		$args = array(
		  'hide_empty'	=> 0,
		  'show_count'  => 0,
		  'exclude'		=> $exclude,
		  'title_li'	=> ''
		);

    	echo '<div class="news-buttons"><ul>';
        	wp_list_categories($args);
        echo '</ul></div>';
    }

	function two_line_navigation( $items, $args ) {

	  if($args->name == 'Primary Navigation') {
	  	
		foreach ( $items as &$item ) {

			$myArray = preg_split('/<br[^>]*>/i', $item->title);
			
			$myArraySize = count($myArray);
			if ( $myArraySize == 2){
				$item->title = '<span class="nav-line-1">' .$myArray[0]. '</span><br>' . $myArray[1];
			}
		 }
	  }
	  
	  return $items; 
	}

	function first_last_items( $objects, $args  ) {

	    $ids        = array();
	    $parent_ids = array();
	    $top_ids    = array();
	    foreach ( $objects as $i => $object ) {
	        // If there is no menu item parent, store the ID and skip over the object.
	        if ( 0 == $object->menu_item_parent ) {
	            $top_ids[$i] = $object;
	            continue;
	        }
	        // Add first item class to nested menus.
	        if ( ! in_array( $object->menu_item_parent, $ids ) ) {
	            $objects[$i]->classes[] = 'first-menu-item';
	            $ids[]                  = $object->menu_item_parent;
	        }
	        // If we have just added the first menu item class, skip over adding the ID.
	        if ( in_array( 'first-menu-item', $object->classes ) ) {
	            continue;
	        }
	        // Store the menu parent IDs in an array.
	        $parent_ids[$i] = $object->menu_item_parent;
	    }
	    // Remove any duplicate values and pull out the last menu item.
	    $sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );
	    // Loop through the IDs and add the last menu item class to the appropriate objects.
	    foreach ( $sanitized_parent_ids as $i => $id ) {
	        $objects[$i]->classes[] = 'last-menu-item';
	    }
	    // Finish it off by adding classes to the top level menu items.
	    $objects[1]->classes[] = 'first-menu-item'; // We can be assured 1 will be the first item in the menu. :-)
	    $objects[end( array_keys( $top_ids ) )]->classes[] = 'last-menu-item';
	    // Return the menu objects.
	    return $objects;
	}

	function events_cat_list() {

		    $args = array(
			'show_option_all'    => '',
			'orderby'            => 'name',
			'order'              => 'ASC',
			'style'              => 'list',
			'show_count'         => 0,
			'hide_empty'         => 1,
			'use_desc_for_title' => 1,
			'child_of'           => 0,
			'feed'               => '',
			'feed_type'          => '',
			'feed_image'         => '',
			'exclude'            => '',
			'exclude_tree'       => '',
			'include'            => '',
			'hierarchical'       => 1,
			'title_li'           => __( 'Event Categories' ),
			'show_option_none'   => __( '' ),
			'number'             => null,
			'echo'               => 1,
			'depth'              => 0,
			'current_category'   => 0,
			'pad_counts'         => 0,
			'taxonomy'           => 'tribe_events_cat',
			'walker'             => null
		    );

	    	

	    	echo wp_list_categories( $args ); 
    }

    function event_breadcrumbs( $args ) {

		 echo '<div class="breadcrumb"><a href="/">Hutch Health</a> &gt; Events</div>';
    }

    function child_breadcrumb_args( $args ) {
		global $post;
          $args['home']                    = 'Hutch Health';
          $args['sep']                     = ' > ';
          $args['list_sep']                = ', '; // Genesis 1.5 and later
          $args['prefix'] = '<div class="breadcrumb">';
          $args['suffix']  = '</div>';
          $args['heirarchial_attachments'] = true; // Genesis 1.5 and later
          $args['heirarchial_categories']  = true; // Genesis 1.5 and later
          $args['display']                 = true;
          $args['labels']['prefix']        = '';
          $args['labels']['author']        = 'Archives for ';
          $args['labels']['category']      = 'Archives for '; // Genesis 1.6 and later
          $args['labels']['tag']           = 'Archives for ';
          $args['labels']['date']          = 'Archives for ';
          $args['labels']['search']        = 'Search for ';
          $args['labels']['tax']           = 'Archives for ';
          $args['labels']['404']           = 'Not Found '; // Genesis 1.5 and later


          return $args;
	}

	function filter_events_title ($title) {
		
		if ( tribe_is_upcoming()) { // List View Category Page: Upcoming Events
			$title = 'Events';
		}


		//return $title;
	}

	function show_side_tab() {
	   echo '<div class="sidetab"><a href="/tell-us-how-we-are-doing/" >Tell Us How We&rsquo;re Doing <i class="fas fa-angle-down"></i></a></div>';
	}

	//Determine if this is an ADA page ?ada=1 and add the ada class if so
	function add_body_class_ada( $classes ) {

		$isADA = filter_input(INPUT_GET, 'ada');
		if( is_numeric($isADA) && $isADA == 1  ){
		   $classes[] = 'ada';		
		}

        return $classes;
    }

     /**
     * Main function
	 * - Replaces field content with WCAG 2.0 compliant HTML
     */
	function change_fields_content_ada( $content, $field, $value, $lead_id, $form_id ) {

		if ( is_admin() || 'print-entry' == RGForms::get( 'gf_page' ) ) {
			return $content;
		}


		$field_type = rgar( $field, 'type' );
		$field_required = rgar( $field, 'isRequired' );
		$field_failed_valid = rgar( $field, 'failed_validation' );
		$field_label = htmlspecialchars( rgar( $field, 'label' ), ENT_QUOTES );
		$field_id = rgar( $field, 'id' );
		$field_description = rgar( $field, 'description' );

		// NAME FIELD
		//
		// name field in fieldset
		// adds aria-required='true' if required field
		if ( 'name' == $field_type ) {
			// wrap in fieldset
			// includes variations for 2-8 depending on field configuration
			if ( $field_required ) {
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_2' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_3' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_4' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_6' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_8' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
			} else {
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_2' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_3' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_4' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>",$content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_6' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>", $content );
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_8' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>", $content );
			}
			$content .= "</fieldset>";
		}

		// EMAIL FIELD
		//
		// wrap email field with confirmation enable in fieldset
		// adds aria-required='true' if required field
		elseif ( 'email' == $field_type && rgar( $field, 'emailConfirmEnabled' ) ) {
			//wrap in fieldset
			if ( $field_required ) {
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
			} else {
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>", $content );
			}
			$content .= "</fieldset>";
		}

		// ADDRESS FIELD
		//
		// address field in fieldset
		// adds aria-required='true' if required field
		elseif ( 'address' == $field_type ) {
			//wrap in fieldset
			if ( $field_required ) {
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_1' >{$field_label}<span class='gfield_required'>*</span></label>", "<fieldset aria-required='true' class='gfieldset'><legend class='gfield_label'>{$field_label}<span class='gfield_required'>*</span></legend>", $content );
			} else {
				$content = str_replace( "<label class='gfield_label gfield_label_before_complex' for='input_{$form_id}_{$field_id}_1' >{$field_label}</label>", "<fieldset class='gfieldset'><legend class='gfield_label'>{$field_label}</legend>", $content );
			}
			$content .= "</fieldset>";
		}

		return $content;

	}

	function vi_document_output($html, $vidoc_elements) {

				$html = '';
		        $html .= '<div class="vidoc-container">';
					$html .= '<div class="vidoc-wrap">';
						$html .= '<div class="vidoc-element">';
							$html .= '<div class="vidoc-icon '.$vidoc_elements['fileextension'].'"><a id="'.$vidoc_elements['id'].'" target="_blank" href="'.$vidoc_elements['fileurl'].'"></a></div>';
							//$html .= '<div class="vidoc-link">';
								//$html .= '<a id="'.$vidoc_elements['id'].'" target="_blank" href="'.$vidoc_elements['fileurl'].'"><img src="'.plugin_dir_url( dirname(__FILE__) ) . 'public/images/download.png" alt="Click here to download the '.strtoupper($extension_class).'" /></a>';
							//$html .= '</div>';
							$html .= '<div class="vidoc-content-wrapper">';
								$html .= '<div class="vidoc-title">';
									$html .= '<a id="'.$vidoc_elements['id'].'" target="_blank" href="'.$vidoc_elements['fileurl'].'">Download '.$vidoc_elements['title'].' (' . strtoupper($vidoc_elements['fileextension']) . ')</a>';
								$html .= '</div>';
								$html .= '<div class="vidoc-content">';
									$html .= $vidoc_elements['content'];
								$html .= '</div>';
							$html .= '</div>';
						$html .= '</div>';
					$html .= '</div>';
				$html .= '</div>';

			return $html;
    }

    //Display COVID-19 message (Added 3.19.2020)
    function covid_19_message(){

    	//Blue Box
    	$display_message = get_field_object('display_covid_19_message');
		$display_message_value = $display_message['value'][0];

    	//If the message is activated for the page, get the content of the COVID-19 Message page (ID=11522)
    	if($display_message_value == "Yes"){

    		$messagePage = get_page(11522);
		
			//Output the page content
			echo '<div class="covid-19-message-wrap">';
				echo apply_filters('the_content', $messagePage->post_content);
			echo '</div>';

    	}

    	$display_message_yellow = get_field_object('display_covid_19_message_yellow');
		$display_message_yellow_value = $display_message_yellow['value'][0];

		//If the message is activated for the page, get the content of the COVID-19 Message - Yellow Box page (ID=11522)
    	if($display_message_yellow_value == "Yes"){

    		$messageYellowPage = get_page(11534);
		
			//Output the page content
			echo '<div class="covid-19-message-yellow-wrap">';
				echo apply_filters('the_content', $messageYellowPage->post_content);
			echo '</div>';

    	}
    }

    function covid_19_message_output(){

    		$messagePage = get_page(11522);
		
			//Output the page content
			echo '<div class="covid-19-message-wrap">';
				echo apply_filters('the_content', $messagePage->post_content);
			echo '</div>';
    }


    function covid_yellow(){

     	ob_start();

    		$messageYellowPage = get_page(11534);
		
			//Output the page content
			echo '<div class="covid-19-message-yellow-wrap">';
				echo apply_filters('the_content', $messageYellowPage->post_content);
			echo '</div>';
		return ob_get_clean();
    }

    function page_hero_image() {
    	if ( has_post_thumbnail() ) {
    		remove_action( 'genesis_post_title', 'genesis_do_post_title' );
    		remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
    		$image_url 	= get_the_post_thumbnail_url();
    		$title 		= get_the_title();

			$output .= '<div class="page-hero-image">';
				$output .= '<div class="conent-wrapper" style="background-image:url(' .  $image_url . ');">';
					$output .= '<h1 class="entry-title">'.$title.'</h1>';
				$output .= '</div>';
			$output .= '</div>';

			echo $output;
    	}
    }


}  