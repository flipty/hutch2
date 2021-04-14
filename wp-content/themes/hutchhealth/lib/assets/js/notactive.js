/**
 * Where javascript/jQuery will be put to be copied into actual child.js when needed
 * @author Tyler Steinhaus
 * @since 05/15/2014
 */
jQuery(document).ready(function ( $) {
	if( $('#slides').length > 0 ){
		$('#slides').slides({
			preload: true,
			generateNextPrev: false,
			play: 4000,  //length of time a slide shows
			preloadImage: '/wp-includes/images/blank.gif' ,
			preload: true,
			generatePagination: false,
			slideSpeed: 5000,
			fadeSpeed: 2000,
			effect: 'fade',
			crossfade: true,
			randomize: false
		});
	}
});