<?php
/**
 * theme-supports.php - Anything that is for theme supports
 * Anything that is related to theme supports
 * go here.
 *
 * @since 04/02/2014
 * @author Tyler Steinhaus
 */

if( !class_exists( 'themeSupports' ) ) {
	class themeSupports extends vividChild {

		function __construct() {
			/**
			 * Turn Mobile Responsive viewport on if theme support "vivid--image-responsive"
			 * is set to true.
			 */
			if( current_theme_supports( 'vivid-image-responsive' ) ) {
				add_action( 'genesis_meta', array( $this, 'mobileViewport' ) );
				add_action( 'wp_enqueue_scripts', function() {
					wp_enqueue_style( 'responsive', THEME_MOBILE.'responsive.css' );
					//wp_enqueue_style( 'mobile-menu-dark', CSS_ASSETS.'/mobile_menu_dark.css' );
					//wp_enqueue_script( 'mobile-menu', JS_ASSETS.'/mobile_menu.js', array( 'jquery' ) );
				} );
				//add_action('genesis_header_right', array( $this, 'menuButton'), 1 );
			}

			/**
			 * If grid-overlay is turned on we create the grid over the
			 * main wrapper.
			 */
			if( current_theme_supports( 'grid-overlay' ) ) {
				add_action( 'genesis_before', array( $this, 'gridOverlay' ), 1 );
				add_action( 'wp_enqueue_scripts', function() {
					wp_enqueue_style( 'grid-overlay', CSS_ASSETS.'/grid-overlay.css' );
					wp_enqueue_script( 'grid-overlay', JS_ASSETS.'/grid-overlay.js', array( 'jquery' ) );
				} );
			}

			/**
			 * Include Font Awesome if theme support "font-awesome"
			 * is enabled
			 */
			if( current_theme_supports( 'font-awesome' ) ) {
				add_action( 'wp_enqueue_scripts', function() {
					wp_enqueue_style( 'font-awesome', CSS_ASSETS.'/font-awesome.min.css' );
				} );
			}

			/**
			 * Move the header outside of #wrap so we can position: fixed;
			 */
			if( current_theme_supports( 'fixed-header' ) ) {
				$breadcrumb = get_theme_support( 'fixed-header' );

				remove_action( 'genesis_header', 'genesis_header_markup_open', 5 );
				remove_action( 'genesis_header', 'genesis_do_header' );
				remove_action( 'genesis_header', 'genesis_header_markup_close', 15 );
				if( $breadcrumb[0] == true ) {
					remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
				}

				add_action( 'genesis_before', 'genesis_header_markup_open', 1 );
				add_action( 'genesis_before', 'genesis_do_header', 2 );
				add_action( 'genesis_before', 'genesis_header_markup_close', 3 );
				add_action( 'genesis_before', 'genesis_do_breadcrumbs', 4 );
				if( $breadcrumb[0] == true ) {
					add_action( 'genesis_before', 'genesis_do_breadcrumbs', 4 );
				}

				add_filter( 'body_class', function( $classes ) {
					$classes[] = 'fixed-header';
					return $classes;
				} );

			}
		}

		/**
		 * Add Mobile Responsive Viewport into the header
		 * @since 03/26/2014
		 * @author Tyler Steinhaus
		 */
		function mobileViewport() {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1" />';
		}

		/**
		 * Overlays grid graphic over #wrap to help align
		 * elements. - Open
		 * @since 03/27/2014
		 * @author Tyler Steinhaus
		 */
		function gridOverlay() {
			// Check to see if grid is 12 column or 16 column
			$grid = get_theme_support( 'grid-overlay' );
			$width = $grid[0] == 960 ? 'small' : 'large';
			$column = $grid[1] == 12 ? 'twelve' : 'sixteen';

			echo '<div id="grid-overlay"><div class="'.$column.' '.$width.'"></div></div>';
		}

	    /**
	     * Output a Menu Button before the Nav
	     *
	     * @since 8.6.13
	     * @uses added to the genesis_after_header hook by self::__constrcut()
	     */
	    function menuButton(){
	       ?>
	       <div id="nav-button">
	           <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/mobile-menu-button.png" />
	       </div>
	      <?php
	    }
	}
	$themeSupports = new themeSupports;
}