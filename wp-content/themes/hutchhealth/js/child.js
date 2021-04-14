/**
 * 	Vivid Image Child Theme
 *  jQuery/Javascript file
 *  @since 03/26/2014
 *  @author Tyler Steinhaus
 */
jQuery(document).ready(function ( $) {

	if( $('#slides').length > 0 ){
		$('#slides').slides({
			preload: true,
			generateNextPrev: false,
			play: 4000,  //length of time a slide shows
			preloadImage: '/wp-includes/images/blank.gif' ,
			preload: true,
			generatePagination: false,
			slideSpeed: 5000,
			fadeSpeed: 2000,
			effect: 'fade',
			crossfade: true,
			randomize: false
		});
	}

	$( window ).load( function() {
     	//ADA compliance for Google Translator widget
     	$('#top-bar-container .widget-area #glt_widget-2 #google_language_translator .goog-te-combo').attr('id', 'goog-te-combo');
     	$( '<label for="goog-te-combo" class="screen-reader-text">Select Language</label>' ).insertBefore( "#top-bar-container .widget-area #glt_widget-2 #google_language_translator .goog-te-combo" );

     	//Alt tags for Google logos
     	$('.site-header .widget-area #glt_widget-2 #google_language_translator .goog-logo-link img').attr('alt', 'Google Translate Logo');
     	$('#goog-gt-tt .logo img').attr('alt', 'Google Logo');


     	/*ADA compliance for MapifyPro: https://hutchhealth.com/health-well-being/little-free-library*/
        //Add label for Default View select
        $('.mpfy-controls .mpfy-filter .mpfy_tag_select').attr('id', 'mpfy_tag_select');
     	$( '<label for="mpfy_tag_select" class="screen-reader-text">Select View</label>' ).insertBefore( ".mpfy-controls .mpfy-filter .mpfy_tag_select" );

     	//Add label for Search by Zipcode
     	$('.mpfy-search-form .mpfy-search-field .mpfy_search').attr('id', 'mpfy_search');
     	$( '<label for="mpfy_search" class="screen-reader-text">Enter city or zip code</label>' ).insertBefore( ".mpfy-search-form .mpfy-search-field .mpfy_search" );

     	//Add text for Clear Search link
     	$( ".mpfy-search-form .mpfy-search-field .mpfy-clear-search" ).text( "Clear Search" );

     	$( ".mpfy-search-form .mpfy_search_button" ).attr('value', 'Search by Location');

     	//Add text for zoom in & out links
     	$( ".mpfy-controls-wrap .mpfy-zoom-in" ).html( '<span class="screen-reader-text">Zoom In</span>' );
     	$( ".mpfy-controls-wrap .mpfy-zoom-out" ).html( '<span class="screen-reader-text">Zoom In</span>' );

     	//Add text for map pins
     	$( ".mpfy-map-canvas .mpfy-pin" ).html( '<span class="screen-reader-text">Map Location</span>' );
     	
     	//Alt tags for Mapify icons
     	$('.gm-style img').attr('alt', 'Little Free Library Icon');

     	/*End ADA compliance for MapifyPro*/

     	//Add text for VI Docs icon
     	$( ".vidoc-container .vidoc-icon a" ).html( '<span class="screen-reader-text">View Document</span>' );

    });

	if ( $('.breadcrumb').height() > 30){
		$( 'body' ).addClass( "breadcrumb-tall" );
	} ;

	$( '#message-bar span.close' ).click( function( e ) {
		$( '.message-bar #outabody' ).css( 'margin-top', '-50px' );
	});


		//Homepage main image pop-up
	    //$( ".site-container" ).append( "<div id='overlay'></div>" );
	    //Homepage main image pop-up
		//$( "#home-top-container  #custom_html-12 .widget-wrap" ).prepend("<div id='cc_close'><i class='fa fa-times'></i></div>");
		//$( '#home-top-container #widget_sp_image-9' ).click( function( e ) {

			//var windowHeight = $( window ).height();
			//var windowWidth = $( window ).width();
			//var formHeight = $('#home-top-container  #custom_html-12').height();
			//var formWidth = $('#home-top-container  #custom_html-12').width();
			//var scrollTopOffset = $(window).scrollTop();
			//var topOffset = (windowHeight - formHeight) / 2 + scrollTopOffset;
			//var leftOffset = (windowWidth - formWidth)/2;
			/*var styles = { 
				top : topOffset, 
				left: leftOffset
			};*/

			//$( '#home-top-container  #custom_html-12' ).fadeIn();
		//} );
		//Close buttons
		//$('#home-top-container #custom_html-12 #cc_close').click( function() {
			//$( '#home-top-container #custom_html-12' ).fadeOut();
		//});




	if( $( window ).width() > 960 ) {
		$('#nav_menu-7 h4').click(function(){
			//close
			if( $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).attr( 'style' ) == 'display: block;' ) {
				$( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'block' );
		        $("#nav_menu-5" ).removeClass('closed');
		        $("#nav_menu-6" ).removeClass('closed');
			}

			//open
			else{
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
		         $( '#nav_menu-6' ).addClass('closed');
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'none' );
		        $("#nav_menu-5" ).addClass('closed');
	        }
	    });

		$('#nav_menu-6 h4').click(function(){

			//close
			if( $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).attr( 'style' ) == 'display: block;' ) {

				$( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-5' ).removeClass('closed');
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );

			}

			//open
			else{
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-6' ).removeClass('closed');
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-5' ).addClass('closed');
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );
	       }
	    });

	    $('#nav_menu-5 h4').click(function(){


	    	if( $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).attr( 'style' ) == 'display: block;' ) {
	    		$( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'none' );
	    		$( '#nav_menu-5' ).addClass('closed');
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );
	    	}
	    	else{
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-5' ).removeClass('closed');
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-6' ).removeClass('closed');
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );
	       }
	    });
	} else {

		$('#nav_menu-7 h4').click(function(){

			//close
			if( $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).attr( 'style' ) == 'display: block;' ) {
				$( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );

			}

			//open
			else{
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-7' ).addClass('open');
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-6' ).removeClass('open');
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-5' ).removeClass('open');
		    }

		});
	    $('#nav_menu-6 h4').click(function(){

			//close
			if( $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).attr( 'style' ) == 'display: block;' ) {

				$( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
				$( '#nav_menu-6' ).removeClass('open');
			}

			//open
			else{
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-6' ).addClass('open');
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-5' ).removeClass('open');
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );
		   		$( '#nav_menu-7' ).removeClass('open');
		   }
		});

	    $('#nav_menu-5 h4').click(function(){


	    	if( $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).attr( 'style' ) == 'display: block;' ) {
	    		$( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'none' );
	    		$( '#nav_menu-5' ).removeClass('open');
	    	}
	    	else{
		        $( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'block' );
		        $( '#nav_menu-5' ).addClass('open');
		        $( '#nav_menu-6 .menu-featured-services-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-6' ).removeClass('open');
		        $( '#nav_menu-7 .menu-events-classes-quicklinks-container' ).css( 'display', 'none' );
		        $( '#nav_menu-7' ).removeClass('open');
	       }
	    });
	}

   	$('#view-by-specialty').click(function(){

		$('.providers #view-by-specialty ').addClass( "selected" );
		$('.providers #view-by-name').removeClass('selected');
		$( '.providers .specialties' ).css( 'display', 'block' );
	    $( '.providers .name' ).css( 'display', 'none' );

		return false;
 	});

	$('#view-by-name').click(function(){

		$('.providers #view-by-name ').addClass( "selected" );
		$('.providers #view-by-specialty').removeClass('selected');
		$( '.providers .specialties' ).css( 'display', 'none' );
		$( '.providers .name' ).css( 'display', 'block' );

		return false;
	});


	/* Resposnive Table Code */
    if ( $('table.vimmResponsive').length > 0 ) {
        var tableheadCound = 1;
        $('table.vimmResponsive th').each(function() {        
            $("<style type='text/css'> table.vimmResponsive td:nth-of-type("+tableheadCound+"):before { content: \""+$(this).text()+"\"; } </style>").appendTo("head");
            tableheadCound++;
        });
    }

    /* End Responsive Table Code */

	 
   /**
	 * Create default jQuery for accordion shortcode
	 *
	 * @since 07/15/2014
	 * @author Tyler Steinhaus
	*/
	$( '.accordion' ).click( function( e ) {
		if( $( this ).hasClass( 'open' ) == false ) {
			$( '.accordion' ).removeClass( 'open' ).promise().done( function() { 
				$( '.accordion-content' ).slideUp( 'slow' ); 
			} );	
		}
		
		if( $( e.target ).hasClass('accordion-title') ) {
			$( '.accordion-content', this ).slideToggle( 'slow' );
			if( $( this ).hasClass( 'open' ) ) {
				$( this ).removeClass( 'open' );
			} else {
				$( this ).addClass( 'open' );
			}
		}
	});

	/**
	 * Allows you to put in anchor in the URL so when you visit a page with the accordion with the same title
	 * it will slide down and automatically open. Setting an anchortag in a URL to specific class will trigger 
	 * a graceful scroll down to that element. ( http://www.example.com/pagename#classname )
	 *
	 * @author  Justin McGuire
	 */
	var hash = window.location.hash.substring(1).toLowerCase();
	if( hash != '' ) {
		hash = hash.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
		targetAccordion = '.accordion-' + hash;
		if ( $(targetAccordion).length > 0 ) {
			$(targetAccordion).parent().addClass( 'open' );
    		$(targetAccordion).siblings().slideToggle( 'slow', function() {
	    		$('html, body').animate({
	    			scrollTop: $(targetAccordion).offset().top - 50
				}, 2000);
  	 		});
    	} else {
    		targetClass = '#' + hash;

		    $('html, body').animate({
		        scrollTop: $(targetClass).offset().top
		    }, 2000);
    	}
	}

	// scroll handler
  	var scrollToAnchor = function( id ) {
 
	    // grab the element to scroll to based on the name
	    var elem = $("a[name='"+ id +"']");
	 
	    // if that didn't work, look for an element with our ID
	    if ( typeof( elem.offset() ) === "undefined" ) {
	      elem = $("#"+id);
	    }
	 
	    // if the destination element exists
	    if ( typeof( elem.offset() ) !== "undefined" ) {
	 
	      // do the scroll
	      $('html, body').animate({
	        scrollTop: elem.offset().top
	      }, 1000 );
	 
	    }   
	};

	$('a[href*="#"]')
	  // Remove links that don't actually link to anything
	  .not('[href="#"]')
	  .not('[href="#0"]')
	  .click(function(event) {
	    // On-page links
	    if (
	      location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
	      && 
	      location.hostname == this.hostname
	    ) {
	      // Figure out element to scroll to
	      var target = $(this.hash);
	      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
	      // Does a scroll target exist?
	      if (target.length) {
	        // Only prevent default if animation is actually gonna happen
	        event.preventDefault();
	        $('html, body').animate({
	          scrollTop: target.offset().top - 85
	        }, 1000, function() {
	          // Callback after animation
	          // Must change focus!
	          var $target = $(target);
	          if ($target.is(":focus")) { // Checking if the target was focused
	            return false;
	          } else {
	            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
	          };
	        });
	      }
	    }
	  });


	$( window ).resize( function() {
		if( $( window ).width() > 960 ) {
			$( '#nav_menu-5 .menu-patients-visitors-quicklinks-container' ).css( 'display', 'block' );
		}
	} );

	function getUrlParameter(sParam) {
	    var sPageURL = window.location.search.substring(1);
	    var sURLVariables = sPageURL.split('&');
	    for (var i = 0; i < sURLVariables.length; i++) {
	        var sParameterName = sURLVariables[i].split('=');
	        if (sParameterName[0] == sParam) {
	            return sParameterName[1];
	        } else {
	        	return null;
	        }
	    }
	}
	
	var ada = getUrlParameter('ada');

	if ( ada == 1 ) {
		$( 'div.accordion > div.accordion-content' ).slideToggle( 'slow' );
	}

	/** Disply VIMM Email Signup pop up on click **/
	var targetForm = '.tribe-events-gravity-form';
	var targetLink = '.tribe-events-pay-link a.button';
	var closeButtonImage = '/wp-content/themes/hutchhealth/images/close-button.png'
	if ( $( targetLink ).length ) {
		console.log("button found");
	}
	//No changes should need to be made to code below after setting variables above.
	if ( $( targetForm ).length && $( targetLink ).length ) {
		console.log("Form Found");
		$( "body" ).append( "<div id='overlay'></div>" );
		$( 'body .tribe-events-gravity-form .gform_wrapper').prepend("<div id='cc_close'><i class=\"fas fa-times\"></i></div>");
		$( targetLink ).on('click', function( ev ) {
			console.log('Click Detected');
			ev.stopPropagation();
			ev.preventDefault();
			var windowHeight = $( window ).height();
			var windowWidth = $( window ).width();
			var formHeight = $(targetForm).height();
			var formWidth = $(targetForm).width();
			var scrollTopOffset = $(window).scrollTop();
			var topOffset = (windowHeight - formHeight) / 2 + scrollTopOffset;
			var leftOffset = (windowWidth - formWidth)/2;
			var styles = { 
				top : topOffset, 
				left: leftOffset
			};
		    $('#overlay').fadeIn(300);
			$( targetForm ).css(styles);
			$( targetForm ).fadeIn(300);
		} );
		$('#cc_close').click( function() {
			$('#overlay').fadeOut();
			$( targetForm ).fadeOut(300);
		});
		$( window ).resize(function() {
			var windowHeight = $( window ).height();
			var windowWidth = $( window ).width();
			var formHeight = $(targetForm).height();
			var formWidth = $(targetForm).width();
			var scrollTopOffset = $(window).scrollTop();
			var topOffset = (windowHeight - formHeight) / 2 + scrollTopOffset;
			var leftOffset = (windowWidth - formWidth)/2;
			var styles = { 
				top : topOffset, 
				left: leftOffset
			};
			$( targetForm ).css(styles);
		});
		$(window).scroll(function(){
			var windowHeight = $( window ).height();
			var formHeight = $(targetForm).height();
			var formWidth = $(targetForm).width();
			var scrollTopOffset = $(window).scrollTop();
			var topOffset = (windowHeight - formHeight) / 2 + scrollTopOffset;
			var styles = { 
				top : topOffset
			};
			$( targetForm ).css(styles);
		});
		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				$('#overlay').fadeOut();
				$( targetForm ).fadeOut(300);
			}
		});
	}

});

function show_object( obj ){
	var str = ""; //variable which will hold property values
	for( prop in obj ) {
		str += prop+" value: "+obj[prop]+"\n";
	}
	console.log( str );
}

( function( $ ) {
	$.fn.hoverEffect = function( options ) {
		var defaults = {
			'style': '',
			'newImage': ''
		};

		var option = $.extend( defaults, options );

		return this.each( function() {
			var defaultImage = $( 'img', this ).attr( 'src' );
			$( this ).hover(function() {
		 		$( 'img', this ).attr( 'src', option.newImage );
		 	}, function() {
		 		$( 'img', this ).attr( 'src', defaultImage );
		 	});
		} );
	};

	$.fn.focusEffect = function( options ) {
		var defaults = {
			'focus': ''
		};

		var option = $.extend( defaults, options );

		return this.each( function() {
			if( $( this ).val() == '' ) {
		       $( this ).attr( 'value', option.focus );
		     }

		     $( this ).focus (function() {
		      if( $( this ).val() == option.focus ) {
		             $( this ).attr( 'value', '' );
		      }
		     });

		      $( this ).blur (function() {
		      if( $( this ).val() == ''  ) {
		             $( this ).attr( 'value', option.focus );
		       }
		     });
		} );
	};

	$.fn.fixedSidebar = function( extraOffset, header, endPoint ) {
		return this.each( function() {
			var $sidebar   = $( this ),
	        	$window    = $( window ),
	        	offset     = $sidebar.offset(),
	        	topPadding = extraOffset;

			var headerOffset = header;
			if( $( '#wpadminbar' ).length != 0 ) {
				headerOffset += 32;
			}
			if( $sidebar.length != 0 ) {
			    $window.scroll(function() {
			        if( ( $window.scrollTop() + headerOffset ) > offset.top ) {
			            $sidebar.css( {
			                marginTop: ( $window.scrollTop() + headerOffset ) - offset.top + topPadding
			            } );
			        } else {
			            $sidebar.css( {
			                marginTop: endPoint
			            } );
			        }
			    } );
			}
		} );
	};

	$.fn.parallax = function() {
		return this.each( function() {
			var ID = this;
			$( window ).scroll( function() {
		        scrolltop = $(window).scrollTop();
		        $( ID ).css( "background-position", "50% " + - ( scrolltop / 2 ) + "px" );
			} );
		} );
	};
}( jQuery ) );