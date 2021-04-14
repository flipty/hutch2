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

			// Add buttons to the TinyMCE
			add_filter( 'mce_external_plugins', array( $this, 'tinymce_buttons' ) );
			add_filter( 'mce_buttons', array( $this, 'tinymce_buttons_button' ) );
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
			$output = '<div class="accordion">';
				$output .= '<div class="title">'.$args['title'].'</div>';
				$output .= '<div class="content" style="display: none;">'.do_shortcode( $content ).'</div>';
			$output .= '</div>';

			// Create a filter that allows us to modify the output
			$output = apply_filters( 'vivid-accordion-template', $output );

			return $output;
		}

		/**
		 * Include the JS for the TinyMCE Button
		 *
		 * @since 08/27/2014
		 * @author Tyler Steinhaus
		 */
		function tinymce_buttons( $plugin_array ) {
			$plugin_array['viButton'] = JS_ASSETS.'/admin.shortcodes.js';
			$plugin_array['viAccordion'] = JS_ASSETS.'/admin.shortcodes.js';
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
			return $buttons;
		}
	}

	new vi_child_theme_shortcodes;
}
