<?php
global $post;


//Output the post image


$this->Post->default_featured_image();

//Output post title
genesis_do_post_title();

//Output the content
the_content_limit( '425');


?>

