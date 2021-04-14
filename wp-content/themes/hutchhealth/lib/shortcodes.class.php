<?php
/**
 * shortcodes.class.php - Add all default shortcodes
 * Built just for Vivid Image Needs.
 * Any thing that may be used more than once
 * should go here.
 *
 * @since 07/15/2014
 * @author Tyler Steinhaus
 */

if( !class_exists( 'vivid_child_shortcodes' ) ) {
	class vi_child_theme_shortcodes {

		/**
		 * Constructor
		 * Add our shortcodes here
		 */
		function __construct() {
			// Button Shortcode
			add_shortcode( 'button', array( $this, 'button_shortcode' ) );

			// Accordion Wrap
			add_shortcode( 'accordion-wrap', array( $this, 'accordion_wrap_shortcode' ) );

			// Accordian shortcode
			add_shortcode( 'accordion', array( $this, 'accordion_shortcode' ) );

			//Columns Shrotcodes
			// add_shortcode( "one-half-first", 	array( $this, 'vimm_one_half_first' ) );
			// add_shortcode( 'one-half',  		array( $this, 'vimm_one_half' ) );
			// add_shortcode( "one-third-first",  	array( $this, 'vimm_one_third_first' ) );
			// add_shortcode( 'one-third', 		array( $this, 'vimm_one_third' ) );
			// add_shortcode( "one-fourth-first",  array( $this, 'vimm_one_fourth_first') );
			// add_shortcode( 'one-fourth',  		array( $this, 'vimm_one_fourth' ) );
			// add_shortcode( "one-fifth-first",  	array( $this, 'vimm_one_fifth_first' ) );
			// add_shortcode( 'one-fifth',  		array( $this, 'vimm_one_fifth' ) );
			// add_shortcode( "one-sixth-first",  	array( $this, 'vimm_one_sixth_first' ) );
			// add_shortcode( 'one-sixth',  		array( $this, 'vimm_one_sixth' ) );
			// add_shortcode( 'clear',				array( $this, 'vimm_clear' ) );

			// Tabs Wrap
			//add_shortcode( 'tabs-wrap', 		array( $this, 'tabs_wrap_shortcode' ) );

			//Tabs shortcode
			//add_shortcode( 'tabs-content',		array( $this, 'vimm_tabs' ) );	
			
			// Add buttons to the TinyMCE
			add_filter( 'mce_external_plugins', array( $this, 'tinymce_buttons' ) );
			add_filter( 'mce_buttons', 			array( $this, 'tinymce_buttons_button' ) );

			// Check to see if vertical tab support is on
			//add_action( 'before_wp_tiny_mce', array( $this, 'tinymcepass' ) );
		}

		/**
		 * Checks to see if Theme Support is on for vertical tabs
		 * @since  02/26/2015
		 * @author  Tyler Steinhaus <[email]>
		 */
		function tinymcepass( $settings) {
			?>
			<script type="text/javascript">
				<?php
				if( current_theme_supports( 'vertical-tabs' ) ) {
					echo 'var vertical_tabs = true;';
				} else {
					echo 'var vertical_tabs = false;';
				}
				?>
			</script>
			<?php
		}

		/**
		 * Button Shortcode
		 * Standard button shortcode
		 *
		 * @since 07/15/2014
		 * @author Tyler Steinhaus
		 *
		 * @uses allows you to have a button shortcode. you can also use to create more
		 * @uses button shortcodes with different names.
		 *
		 * @param array $args passed through arguments
		 * @param string $content passed through content
		 *
		 * @return string $output button output
		 */
		function button_shortcode( $args, $content = NULL ) {
			// Set our default arguments if $args is empty
			$args = shortcode_atts( array(
				'link'		=>	'#',
				'target'	=>	'_self', // _blank, _self, _parent, _top, framename
				'class'		=>	'',
				'id'		=>	''
			), $args );

			// Create our output
			$output = '<a href="'.$args['link'].'" target="'.$args['target'].'" class="vivid-button '.$args['class'].'"';
			if( !empty( $args['id'] ) ) {
				$output .= ' id="'.$args['id'].'"';
			}
			$output .= '>'.$content.'</a>';

			// Create a filter that allows us to modify the output
			$output = apply_filters( 'vivid-button-template', $output );

			return $output;
		}

		/**
		 * Accordion Wrap Shortcode
		 * Will wrap the accordion so we can have extra styling if needed
		 *
		 * @since 08/14/2014
		 * @author Tyler Steinhaus
		 *
		 * @uses Wraps the accordions for more styling
		 *
		 * @param array $args passed through arguments
		 * @param string $content passed through contents
		 */
		function accordion_wrap_shortcode( $args, $content = NULL ) {
			$output = '<div class="accordion-wrap'.$horizontal.'">';
				$output .= do_shortcode( $content );
			$output .= '</div>';

			return $output;
		}

		/**
		 * Accordion Shortcode
		 * Standard accordian
		 *
		 * @since 07/15/2014
		 * @author Tyler Steinhaus
		 *
		 * @uses allows you to add accordians to the content. you can also use to create more
		 * @uses button shortcodes with different names.
		 *
		 * @param array $args passed through arguments
		 * @param string $content passed through content
		 *
		 * @return string $output accordian output
		 */
		function accordion_shortcode( $args, $content = NULL ) {
			// Create our output
			$accordionClass = 'accordion-' . strtolower(str_replace( array(' ','-'), array('',''), $args['title']));

			$output = '<div class="accordion">';
				$output .= '<div class="accordion-title '.$accordionClass.'">'.$args['title'].'</div>';
				$output .= '<div class="accordion-content" style="display: none;">'.do_shortcode( $content ).'</div>';
			$output .= '</div>';

			// Create a filter that allows us to modify the output
			$output = apply_filters( 'vivid-accordion-template', $output );

			return $output;
		}

		/**
		 * Tabs Wrap Shortcode
		 * Will wrap the tbs so we can have extra styling if needed
		 *
		 * @since 08/14/2014
		 * @author Justin McGuire
		 *
		 * @uses Wraps the tab for more styling
		 *
		 * @param array $args passed through arguments
		 * @param string $content passed through contents
		 */
		function tabs_wrap_shortcode( $args, $content = NULL ) {
			$atts = shortcode_atts( array( 'vertical' => 'false' ), $args );

			$output = '<div class="vimm-tabs-wrap">';
			if( $atts['vertical'] == 'true' ) {
				$output = '<div class="vimm-tabs-wrap vertical">';
			}
				//$output .= do_shortcode( $content );
				$tab_array = array();
				preg_match_all( '#'.get_shortcode_regex().'#', $content, $tabs );
				$i = 0;
				foreach( $tabs[3] as $sep_tab ) {
					preg_match_all( '#title="(.*)" active="(.*)"#', $sep_tab, $tab );
					$tab_array[] = array(
						'title' => $tab[1][0],
						'active' => $tab[2][0],
						'content' => $tabs[5][$i]
					);
					if( count( $tab ) == $i ) {
						$i = 0;
					} else {
						$i++;
					}
				}

				$output .= '<div class="tabs">';
					foreach( $tab_array as $tab ) {
						$class = "";
						if( $tab['active'] == 'yes' ) $class = ' class="active"';

						// Replace unwanted characters
						$anchor = preg_replace( "/[^a-zA-Z0-9\s]/", "", $tab['title'] );
						$anchor = str_replace( ' ', '-', $anchor );
						$anchor = strtolower( $anchor );

						$output .= '<a href="#'.$anchor.'"'.$class.'>'.$tab['title'].'</a>';
					}
				$output .= '</div>';
				//$output .= '<div class="container">';
					foreach( $tab_array as $tab ) {
						$class = "";
						if( $tab['active'] == 'yes' ) $class = ' active';

						// Replace unwanted characters
						$anchor = preg_replace( "/[^a-zA-Z0-9\s]/", "", $tab['title'] );
						$anchor = str_replace( ' ', '-', $anchor );
						$anchor = strtolower( $anchor );

						$output .= '<div class="tab-content'.$class.' '.$anchor.'">'.$tab['content'].'</div>';
					}
				//$output .= '</div>';
					$output .= '<div class="clearfix"></div>';
			$output .= '</div>';
			return $output;
		}


		/**
		 * Tabs Shortcode
		 * Standard accordian
		 *
		 * @since 07/15/2014
		 * @author Justin McGuire
		 *
		 * @uses allows you to add tabs to the content.
		 *
		 * @param array $args passed through arguments
		 * @param string $content passed through content
		 *
		 * @return string $output atabs output
		 */
		function vimm_tabs( $args, $content = NULL ) {
			if ( $args['active'] == 'yes' ) {
				$output .= '<dt class="vimm-tab active">'.$args['title'].'</dt>';
				$output .= '<dd class="vimm-tab active">'. do_shortcode( $content ) .'</dd>';
			} else {
				$output .= '<dt class="vimm-tab">'.$args['title'].'</dt>';
				$output .= '<dd class="vimm-tab">'. do_shortcode( $content ) .'</dd>';				
			}
			return $output;
		}

		/**
		 * Column Shortcode Functions
		 *
		 * @since 01/15/2015
		 * @author Justin McGuire
		 *
		 * @uses allows you to add columns to the content.
		 *
		 * @param array $args passed through arguments
		 * @param string $content passed through content
		 *
		 * @return string $output column output
		 */
		function vimm_one_half_first($atts, $content = null ) {
			return '<div class="one-half first">'.do_shortcode( $content ).'</div>';
		}

		function vimm_one_half($atts, $content = null) {
			return '<div class="one-half">'.do_shortcode( $content ).'</div>';
		}

		function vimm_one_third_first($atts, $content = null) {
			return '<div class="one-third first">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_third($atts, $content = null) {
			return '<div class="one-third">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_fourth_first($atts, $content = null) {
			return '<div class="one-fourth first">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_fourth($atts, $content = null) {
			return '<div class="one-fourth">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_fifth_first($atts, $content = null) {
			return '<div class="one-fifth first">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_fifth($atts, $content = null) {
			return '<div class="one-fifth">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_sixth_first($atts, $content = null) {
			return '<div class="one-sixth first">' .do_shortcode( $content ). '</div>';
		}

		function vimm_one_sixth($atts, $content = null) {
			return '<div class="one-sixth">' .do_shortcode( $content ). '</div>';
		}
		function vimm_clear($atts) {
			return '<div class="clear"></div>';
		}
		/**
		 * Include the JS for the TinyMCE Button
		 *
		 * @since 08/27/2014
		 * @author Tyler Steinhaus
		 */
		function tinymce_buttons( $plugin_array ) {
			$plugin_array['viButton'] 		= JS_ASSETS.'/admin.shortcodes.js';
			$plugin_array['viAccordion'] 	= JS_ASSETS.'/admin.shortcodes.js';

		    $plugin_array['viColumns'] 		= JS_ASSETS.'/admin.shortcodes.js';
			//$plugin_array['viTabs'] 		= JS_ASSETS.'/admin.shortcodes.js';

			return $plugin_array;
		}

		/**
		 * Add the button key for address via JS
		 *
		 * @since 08/27/2014
		 * @author Tyler Steinhaus
		 */
		function tinymce_buttons_button( $buttons ) {
			array_push( $buttons, 'viButton_button' );
			array_push( $buttons, 'viAccordion_button' );  
			//array_push( $buttons, 'viTabs_button' );  
			//array_push( $buttons, 'Columns' );

			return $buttons;
		}
	}

	new vi_child_theme_shortcodes;
}
