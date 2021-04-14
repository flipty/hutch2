<?php


$my_job_opportunity_page = 12156;
$jobPage = get_page($my_job_opportunity_page);


echo '<h1>' .$jobPage->post_title. '</h1>';

//echo '<div class="entry-content">' .$jobPage->post_content . '</div>';

echo '<div class="entry-content">'; 

	echo wpautop(do_shortcode($jobPage->post_content));

echo '</div>';

//echo apply_filters('the_content', $jobPage->post_content);

//echo '<div class="jobs-top">';

//echo apply_filters('the_content', $jobPage->post_content);

//echo '</div>';

echo '<h2 class="currentOpenings">Current Openings</h2>'  

?>