<?php
/**
 * Template Name: Landing Page 1
 * @author Tyler Steinhaus
 * @since 06/19/2014
 *
 * To use this for landing pages you will need to move this template file to the root of your theme folder.
 * You will need to create a stylesheet and register it below. Make changes to the id for the stylesheet if needed
 *
 * array $styles Put all the stylesheet names that are needed here. By default should be your landing page stylesheet
 * array $scripts Put all the script names that are needed here. By default should be jquery and gravity forms
 *
 * To pull the Gravity Forms in use the shortcode below:
 * echo do_shortcode( '[gravityforms id="" title="false" description="false" tabindex="50" ajax="false"]' );
 */
	// Register Landing Page Stylesheet so we can call below
	wp_register_style( 'landing-page-1', get_stylesheet_directory_uri().'/landingpage1.css' );

	// Gather Plugin Stylesheets and other stylesheets
	$styles = array(
    	'landing-page-1'
	);

	// Gather Plugin Scripts and other plugins
	$scripts = array(
 		'jquery',
 		'gform_conditional_logic',
    	'gform_gravityforms'
	);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US" prefix="og: http://ogp.me/ns#">
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title></title>
	<link rel="Shortcut Icon" href="" type="image/x-icon" />
	<?php
	// Load the styles
	wp_print_styles( $styles );

	// Load the scripts
	wp_print_scripts( $scripts );
	echo genesis_get_custom_field( '_genesis_scripts' );
	?>
</head>

<body>
</body>

</html>