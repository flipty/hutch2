<?php
 
 
/*Set full-width template*/
 add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
 
 
//* Remove default loop
remove_action( 'genesis_loop', 'genesis_do_loop' );

add_action( 'genesis_loop', 'genesis_404' );
/**
 * This function outputs a 404 "Not Found" error message
 *
 * @since 1.6
 */
function genesis_404() {

	echo genesis_html5() ? '<article class="entry">' : '<div class="post hentry">';



		$my_id = 335;
		$errorPage = get_page($my_id);
		
		
		echo '<div class="entry-content">';
		echo apply_filters('the_content', $errorPage->post_content);

		echo '</div>';
			

		echo genesis_html5() ? '</article>' : '</div>';

}

genesis();
