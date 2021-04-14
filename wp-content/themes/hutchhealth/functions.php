<?php
// Include Genesis
require_once( get_template_directory().'/lib/init.php' );

// Theme Supports
add_theme_support( 'vivid-image-responsive' );
#add_theme_support( 'grid-overlay', '960', '12' ); // 12 or 16
add_theme_support( 'font-awesome' );
#add_theme_support( 'fixed-header' );
add_theme_support( 'genesis-footer-widgets', 2 );

//Image Sizes
add_image_size( 'baby-small', 175, 186, true );
add_image_size( 'baby-large', 600, 638, true );
add_image_size( 'post-feed', 285, 216, true );
add_image_size( 'provider', 155, 218, true );


// Include Vivid Image Library/Classes
require_once( get_stylesheet_directory().'/lib/bootstrap.php' );

// Change how many outabody's we need, default is 3
#$vivid->outabody = 3;


//require( 'MvcMenuIcons.php');
//$MvcMobileIcons = new MvcMenuIcons;

// Widget Areas
mvc_register_sidebar( 'Header Contact' );
mvc_register_sidebar( 'Top Bar' );
mvc_register_sidebar( 'Top Search Bar' );
mvc_register_sidebar( 'Home Top' );
mvc_register_sidebar( 'Home Tabs' );
mvc_register_sidebar( 'Home Middle' );
mvc_register_sidebar( 'Home Bottom' );
mvc_register_sidebar( 'Blog Sidebar' );
mvc_register_sidebar( 'Provider Sidebar' );
mvc_register_sidebar( 'Language Footer' );



//add_filter( 'genesis_breadcrumb_args', 'child_breadcrumb_args' );
/**
* Modifys the breadcrumb display
 */              
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
    $args['labels']['404']           = 'Not Found: '; // Genesis 1.5 and later
    return $args;
}

add_filter( 'the_content_more_link', 'sp_read_more_link' );
add_filter( 'excerpt_more', 'sp_read_more_link' );
add_filter( 'get_the_content_more_link', 'sp_read_more_link' );
function sp_read_more_link() {
    return '... <span class="more-link-container"><a class="more-link" href="' . get_permalink() . '">Continue Reading</a></span>';
}

/**
 * Add our theme settings page
 *
 * @since 10/21/2014
 * @author Tyler Steinhaus
 */
function add_vi_theme_settings() {
      global $_vi_child_settings;

      new vi_child_theme_settings();
      new vi_child_theme_seo_settings();
}
add_action( 'genesis_admin_menu', 'add_vi_theme_settings' );
include 'lib.new/seo.class.php'; // Main SEO Class
include 'lib.new/theme-settings/theme-settings.class.php';
include 'lib.new/theme-settings/seo.class.php';

wp_enqueue_style( 'font-awesome', '//use.fontawesome.com/releases/v5.7.2/css/all.css' );

/**
   * Change TinyMCE Text Colors to Theme Defaults
   * @since 04/29/2014 - Original
   * @author Tyler Steinhaus
   *
   * @since 05/02/2014
   * Checks to see whether we are using 3.9 and above, if so we use the new format otherwise us old.
   *
   * @uses Gives you the ability to change the default colors of the TinyMCE Text Color Selector
   */
function changeTinyMCETextColor( $init ) {
      /**
       * This will allow you to customize the TinyMCE Text Colors
       * @uses array( 'HEX COLOR' => 'COLOR TITLE' );
       */
      $custom_colors = apply_filters( 'tinymce_custom_colors', NULL );
      $colors = '';

      // Let's check to see what version of Wordpress we're using so we can identify how it passes the colors through.
      foreach( $custom_colors as $color => $title ) {
            $colors .= '"'.$color.'", "'.$title.'", ';
      }
      $custom_colors = substr( $colors, 0, -2 );

      $init['textcolor_map'] = '['.$custom_colors.']';
      $init['textcolor_rows'] = 6;
      return $init;
}
add_filter('tiny_mce_before_init', 'changeTinyMCETextColor' );

// Change Default Text Colors
add_filter( 'tinymce_custom_colors', function() {
     return array(
            '2C5697' => 'Dark Blue',
            '542E91' => 'Tan',
            '009B49' => 'Lighter Blue',
            '343741' => 'Black',
            'D03D60' => 'Dark Red'
     );
} );

add_filter( 'the_content', 'vi_shortcode_empty_paragraph_fix' );
function vi_shortcode_empty_paragraph_fix( $content ) {
    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr( $content, $array );
}

add_filter('tribe_events_single_event_the_meta_group_venue', '__return_true');

function clear_func( $atts ) {
  return "<div class='clearfix'></div>";
}
add_shortcode( 'clear', 'clear_func' );


add_filter( 'message_bar_colors', 'message_bar_custom_colors' );
function message_bar_custom_colors() {
  return array(
              'one'     => '#5cb85c',
              'two'     => '#00759f',
              'three'   => '#f0ad4e',
              'four'    => '#bd5027'
              );
}

add_shortcode( 'callout',  'vivid_callout_shortcode' );
function vivid_callout_shortcode( $args, $content = NULL ) {
    // Set our default arguments if $args is empty
    $args = shortcode_atts( array(
      'class'   =>  '',
    ), $args );
    
    // Create our output
    $output = '<div class="vivid-callout ' . $args['class'] . '">' . do_shortcode($content) . '</div>';
    return $output;
}

add_action('get_header','custom_events_sidebar');

function custom_events_sidebar() {
  if ( get_post_type() == 'tribe_events' ) {
      remove_action('genesis_loop','genesis_do_loop');
      add_action( 'genesis_loop', 'events_view' );
  }
}

function events_view() {
  echo '<main id="tribe-events-pg-template" class="tribe-events-pg-template">';
      tribe_events_before_html();
      tribe_get_view();
      tribe_events_after_html();
  echo '</main>';
}
