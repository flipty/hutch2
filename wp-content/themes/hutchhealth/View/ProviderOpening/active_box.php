<?php
    
    global $post;

	
	if ($post->post_type == 'provider-opening'){
	    $value = get_post_meta($post->ID, 'job_active', true);
	    echo '<div class="misc-pub-section misc-pub-section-last">
	         <span id="timestamp">'
	         . '<label><input type="checkbox"' . (!empty($value) ? ' checked="checked" ' : null) . 'value="1" name="job_active" /> Active</label>'
	    .'</span></div>';
	}
?>