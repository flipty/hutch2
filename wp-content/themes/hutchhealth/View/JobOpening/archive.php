<?php
global $post;


$contactID = get_post_meta($post->ID, 'contactID', true);

if ($contactID != 999  && !empty($contactID)){
	
	//Defined Contact
	
	$careerContact = get_post($contactID );
	

	$contact_name = $careerContact->post_title;
	$contact_email = get_post_meta($contactID, 'email', true);
	$contact_address = get_post_meta($contactID, 'Mailing_Address', true);

}

else{
	
	$contact_name = get_post_meta($post->ID, 'other_name', true);
	$contact_email = get_post_meta($post->ID, 'other_email', true);
	$contact_address = get_post_meta($post->ID, 'other_mailing_address', true);

}



/*echo '<dl class="vision-accordion"> 
	  <dt>' .$post->post_title. '</dt>
	  <dd>' .$post->post_content. '
	  
	  <ul class="apply">
	  	
		<li><a href="https://www.formstack.com/forms/?1730360-Fcv1dM1boI" target="_blank">Apply Online</a></li>
		<li><a href="mailto:' .$contact_email. '">Email Your Resume</a> to ' .$contact_name. '</li>
		<li>Or Send Your Resume:<BR>
		     ' .$contact_address. '</li>
	  </ul>';
	  

			if(function_exists('selfserv_shareaholic')) {
				 selfserv_shareaholic(); 
			}
	  echo '</dd></dl>';
	  
*/  

echo '<div class="accordion"> 
	  <div class="accordion-title">' .$post->post_title. '</div>
	  <div class="accordion-content">' .$post->post_content. '
	  
	  <ul class="apply">
	  	
		<li><a href="https://www.formstack.com/forms/?1730360-Fcv1dM1boI" target="_blank">Apply Online</a></li>
		<li><a href="mailto:' .$contact_email. '">Email Your Resume</a> to ' .$contact_name. '</li>
		<li>Or Send Your Resume:<BR>
		     ' .$contact_address. '</li>
	  </ul>';
	  

			/*if(function_exists('selfserv_shareaholic')) {
				 selfserv_shareaholic(); 
			}*/
			if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); }
	  echo '</div></div>';

?>