<?php
/**
 * Widget template. This template can be overriden using the "sp_template_image-widget_widget.php" filter.
 * See the readme.txt file for more info.
 */

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

$sidebar_custom = array(
	'widget_sp_image-10',
	'widget_sp_image-11',
	'widget_sp_image-12',
	'widget_sp_image-13',
	'widget_sp_image-14',
	'widget_sp_image-15',
	'widget_sp_image-17',
	'widget_sp_image-18',
	'widget_sp_image-19',
	'widget_sp_image-21',
	'widget_sp_image-22',
	'widget_sp_image-24',
	'widget_sp_image-26',
	'widget_sp_image-27',
	'widget_sp_image-28'
);


if( in_array( $args['widget_id'], $sidebar_custom ) ) {
	
	echo $before_widget;

	
	echo $this->get_image_html( $instance, true );
	
	 if( $instance['link'] != '' ){
	 	
		echo '<a target="'.$instance['linktarget'].'" href="' .$instance['link']. '">';
	 }
	 
	if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
	
	if( $instance['link'] != '' ){
	 	
		echo '</a>';
	 }

	if ( !empty( $description ) ) {
		echo '<div class="'.$this->widget_options['classname'].'-description" >';
		echo wpautop( $description );
		echo "</div>";
	}
	echo $after_widget;
} else {
	
echo $before_widget;
		
		
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		echo $this->get_image_html( $instance, true );
		
		if ( !empty( $description ) ) {
			echo '<div class="'.$this->widget_options['classname'].'-description" >';
			echo wpautop( $description );
			echo "</div>";
		}
		echo $after_widget;
}


?>