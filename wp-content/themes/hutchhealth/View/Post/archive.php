<?php
global $post;


//Output the post image


$this->Post->default_featured_image();

//Output the content
the_content_limit( '850');


?>

