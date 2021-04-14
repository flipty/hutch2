(function( $ ) {
	'use strict';

	$(window).on('load', function () {
		$('.vidoc-container a').on('click', function(event) {

			var url = $(this).attr('href');
			if ( $(this).attr('href').search('#') != -1 ) {
				//we're password protected
				event.preventDefault();
				var docid = url.substring(1);
				var passwordPopup = '<div class="vidoc-password-popup fadein animate-fade-in" id="'+docid+'-password-popup"><div class="close"><i class="fa fa-times" aria-hidden="true"></i></div><h1>Password Protected</h1><div class="container"><p>This file is password protected. Please enter the password to download this file.</p><p class="warning"></p><input type="text" name="password" class="'+docid+'-submitted-password" placeholder="Enter password here..."><button class="password-submit" type="button">Submit</button></div></div>';
					// remove any existing popups
					$(".vidoc-password-popup").remove();
					
					// add another popup
					$(this).closest('.vidoc-element').append(passwordPopup);
					
					// focus on its input
					$('#'+docid+'-password-popup input[type="text"]').focus();
					
				$('.vidoc-element').on('click', '.password-submit', function(event) {
					var submittedpassword = $('.'+docid+'-submitted-password').val();
			        var data = {
			        	password : submittedpassword,
			        	id: docid,
			            action : "passwordcheck"
			        }
			        if ( submittedpassword != null ) {
				        $.ajax({
				        	type: 'POST',
				        	url: plugin_ajax.ajaxurl,
				        	data: data, 
				        	dataType: "JSON"
						}).done(function(response){
							if ( response['fileurl'] != 'false' ) {
								$('#'+docid+'-password-popup .container').empty();
								var newHtml = '<div class="vidoc-link"><a href="'+response['fileurl']+'" target="_blank" class="download-button">Download Document</a></div>';
								$('#'+docid+'-password-popup .container').html(newHtml);
							} else {
								var warningText = "The password you entered is incorrect.<br>Please try again.";
								$('.'+docid+'-submitted-password').val('');
								$('#'+docid+'-password-popup .warning').html(warningText);
							}
				        });
			        }
				});
			} else {
				var id = $(this).attr('class');
		        var data = {
		           	id: id,
		            action : "addcount"
		        }
		        $.ajax({
		        	type: 'POST',
		        	url: plugin_ajax.ajaxurl,
		        	data: data, 
		        	dataType: "JSON"
				}).done(function(response){
		        });
			}
		});

		$('.vidoc-element').on('click', '.close', function(event) {
			event.preventDefault();
			var parent = $(this).closest('.vidoc-password-popup').attr('id');
			$('#'+parent).remove();	
		});

		$('.vidoc-element').on('click', '.download-button', function(event) {
			var parent = $(this).closest('.vidoc-password-popup').attr('id');
			$('#'+parent).remove();	
		});
	});
	
})( jQuery );