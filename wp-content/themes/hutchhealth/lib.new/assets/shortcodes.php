<script type="text/javascript" src="/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
<script type="text/javascript" src="/wp-admin/load-scripts.php?c=1&amp;load%5B%5D=jquery-core,jquery-migrate,utils,plupload,json2&amp;ver=3.9.2"></script>
<script>
jQuery(document).ready(function ( $) {
	$( '#add_another' ).click( function() {
		// Count how many accordions we currently have
		var howMany = $( '.accordion' ).length;

		// Build out accordion div to add onto
		var accordion_row = '<div class="accordion">' +
		'<h3>Accordion '+(howMany+1)+':</h3>' +
		'<div class="title">' +
			'<h4>Title:</h4><input type="text" name="acc_title[]" class="acc_title" value="" style="width: 75%;" />' +
		'</div>' +
		'<div class="content">' +
			'<h4>Content:</h4>' +
			'<textarea class="acc_content" name="acc_content[]" style="width: 75%;" rows="5"></textarea>' +
		'</div>' +
	'</div>';
		$( accordion_row ).clone().insertAfter( $( '.accordion' ).last() );

		$( 'html, body' ).animate( {
			scrollTop: $( document ).height()
		}, "slow" );
	} );

	$( '#submit' ).click( function() {
		var acc_title = $( '.acc_title' );
		var acc_content = $( '.acc_content' );
		var i = 0;

		var buildAccordionShortcode = '[accordion-wrap]';

		acc_title.each( function( e ) {
			var content = acc_content[i].value;

			if( this.value != '' ) {
				;
				buildAccordionShortcode += '[accordion title="'+this.value+'"]'+content+'[/accordion]';
			}
			i++;
		} );

		buildAccordionShortcode += '[/accordion-wrap]';

		window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, buildAccordionShortcode );
		tinyMCEPopup.close();
	} );
} );
</script>

<form method="post" id="vi-accordion-form">
	<div class="accordion">
		<h3>Accordion 1:</h3>
		<div class="title">
			<h4>Title:</h4><input type="text" name="acc_title[]" class="acc_title" value="" style="width: 75%;" />
		</div>
		<div class="content">
			<h4>Content:</h4>
			<textarea class="acc_content" name="acc_content[]" style="width: 75%;" rows="5"></textarea>
		</div>
	</div>
	<br />
	<?php
	/*<div class="horizontal">
		<input type="checkbox" type="type" value="horizontal" class="horizontal" /> Display Horizontal Accordion?
	</div>*/
	?>
	<input type="button" id="add_another" value="Add Another Accordion" /><br /><br />
	<input type="submit" id="submit" value="submit" />
</form>