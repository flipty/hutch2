<?php
global $post;

$contactID = get_post_meta($post->ID, 'contactID', true);
$jobActive = get_post_meta( $post->ID, 'job_active', true );
			
if($jobActive == 1){


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


		echo  wpautop($post->post_content);

		echo '<p>&nbsp;</p><a class="vivid-button" target="_blank" href="mailto:' .$contact_email. '">Inquire About Position</a><p>&nbsp;</p>';

	    if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); } 
	
}
else{
	echo '<p>This job opening is no longer active.</p>';
	echo '<p>We invite you to explore the other job opportunities that are available at Hutchinson Health.</p>';
	echo '<p><a href="/job-openings/" class="vivid-button">View Current Openings</a><BR /><br /><br /></p>';
}

?>




