<?php
	
	
	global $post;
	
	//get career contacts
	$career_contacts = get_posts( array(
                                           'post_type'   => 'career_contact',
                                           'order_by'    => 'post_title',
                                           'order'       => 'ASC',
 
                                           ) );
	
	
	
	//use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'myplugin_noncename' );
	
	$selectedContact = get_post_meta($post->ID, 'contactID', true);
	
	echo '<label for="Contact">Contact</label><div class="contacts">';
	foreach( $career_contacts as $contact ) {
	
        if ($contact->ID == $selectedContact){
		  echo '<input type="radio" id="conactID" name="contactID" value="'.$contact->ID.'" checked="checked" onclick="javascript:clearFields();"/>' .$contact->post_title. '<br />';
	
		}
		else{
			echo '<input type="radio" id="conactID" name="contactID" value="'.$contact->ID.'" onclick="javascript:clearFields();" />' .$contact->post_title. '<br />';	
		}
    }
    
	if ($selectedContact == '0'){
		echo '<input type="radio" id="conactID" name="contactID" value="0" checked="checked"/>Other';
	}
	else{
			echo '<input type="radio" id="conactID" name="contactID" value="0"/>Other';
	
	}
	echo '</div><p>If other, please enter below:</p>';
	
	$fields = array(
		array('other_name', "Name:"),
		array('other_email', "Email: "),
		array('other_mailing_address', "Mailing Address: ")
	);


    echo '<label for="'.$fields[0][0].'">'.$fields[0][1].'</label></td>
		  <input type="text" id="'.$fields[0][0].'" name="'.$fields[0][0].'" value="'.get_post_meta($post->ID, $fields[0][0], true).'" size="30" /> <BR>';
		  
    //creates the length
	echo '<label for="'.$fields[1][0].'">'.$fields[1][1].'</label></td>
		  <input type="text" id="'.$fields[1][0].'" name="'.$fields[1][0].'" value="'.get_post_meta($post->ID, $fields[1][0], true).'" size="30" /><BR>';
	
  
    //creates the message
	echo '<label for="'.$fields[2][0].'">'.$fields[2][1].'</label><BR>
		  <textarea id="'.$fields[2][0].'" name="'.$fields[2][0].'"  cols="60" rows="4" />'.get_post_meta($post->ID, $fields[2][0], true).'</textarea><BR>';
		
?>


<script language="text/javascript">


	function clearFields(){
		
		document.getElementById("other_name").value = '';
		document.getElementById("other_email").value = '';
		document.getElementById("other_mailing_address").value = '';
	}

</script>