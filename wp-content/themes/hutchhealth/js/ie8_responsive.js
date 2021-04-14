
                  /**
                   * The Js for IE 8 Responsive 
                   *  
                   */

(function($) {


     ieRespond = function() {      
       var winWidth = $( window ).width();
       //alert(winWidth);
       
       if( $( window ).width() > 1140 ) {
       //$( '#header,#inner,#home-top-container #home-top,#home-middle-container #home-middle,#home-wrapper,#footer-widgets .wrap,#footer .wrap,#nav .wrap' ).css( 'max-width', '1140px' );
          //$( '#header,#inner,#home-top-container #home-top,#home-middle-container #home-middle,#home-wrapper,#footer-widgets .wrap,#footer .wrap,#nav .wrap' ).removeAttr( 'style' );
       
          $( '#home-top #text-7,#text-2,#description,#footer .wrap,#footer-widgets .wrap,#header .menu a,#header .searchform,#header .widget-area #widget_sp_image-3,#header .widget-area #widget_sp_image-2,#header .widget-area,#header ul.menu li,#header ul.nav li a, #header ul.menu li a,#header,#home-bottom .post p,#home-bottom .post,#home-bottom-container #home-bottom,#home-middle #meteor-slideshow,#home-middle-container #home-middle,#home-tabs,#home-tabs-container,#home-top #text-6 h2,#home-top #widget_sp_image-9,#home-top-container #home-top,#home-wrapper,#inner,#nav .wrap,#nav,#nav_menu-2,#nav_menu-3 ul li.item-count-13 a,#nav_menu-3 ul li.item-count-20 a,#nav_menu-3 ul li.item-count-7 a,#text-4 a:nth-of-type(1),#title,#title-area,#wpadminbar,.admin-bar #header,.content-sidebar #content-sidebar-wrap,.full-width-content #content-sidebar-wrap,.menu li li,.menu li.right,.menu-primary a,.menu-primary li,.menu-secondary a,.nursery .back,.nursery .view-girl, .nursery .view-boy,.sidebar #widget_sp_image-10 h4,.sidebar #widget_sp_image-10 img,.sidebar #widget_sp_image-11 h4,.sidebar #widget_sp_image-11 img,.sidebar #widget_sp_image-12 h4,.sidebar #widget_sp_image-12 img,.sidebar #widget_sp_image-13 h4,.sidebar #widget_sp_image-13 img,.sidebar #widget_sp_image-14 h4,.sidebar #widget_sp_image-14 img,.sidebar #widget_sp_image-15 h4, .sidebar #widget_sp_image-15 img,.sidebar #widget_sp_image-17 h4,.sidebar #widget_sp_image-17 img,.sidebar #widget_sp_image-18 h4,.sidebar #widget_sp_image-18 img,.sidebar #widget_sp_image-19 h4,.sidebar #widget_sp_image-19 img,.sidebar-content #content-sidebar-wrap,.wrap #header .widget-area' ).removeAttr( 'style' );
       
       
       }
       if( $( window ).width() < 1140 ) {
       	
       		$( '#wpadminbar,.admin-bar #header' ).removeAttr('style');
       	
       	
             $( '#wpadminbar' ).css( 'display', 'none' );
             $( '.admin-bar #header' ).css( 'margin-top', '-46px' );
             
             $( '#header,#inner,#home-top-container #home-top,#home-middle-container #home-middle,#home-wrapper,#footer-widgets .wrap,#footer .wrap' ).css( 'width', '100%' );
             
             
              $( '#home-bottom-container #home-bottom' ).css( 'width', '98%' );
              $( '#title-area' ).css( 'width', '17.25092%' );
              
              $( '#header .widget-area ' ).css({
              	      'width': '82% !important',
              	      'margin': '6px 0 0 0'
              	    } );

            
              $( '.menu-secondary, #description, #header .searchform, #title ' ).css( 'float', 'left' );
            
			  $( '#header' ).css( 'padding', '0 10px' );
			  $( '#header .menu a' ).css( 'padding', '5px 20px' );
            
			
			  $( '#header .widget-area #widget_sp_image-3' ).css( 'clear', 'both' );
            
			  
			  $( '.menu li li' ).css( 'text-align', 'left' );
			  
			 /* $( '#home-top-container:after ' ).css({
			  		'content': '.',
			  		'color': 'transparent',
			  		'display': 'block',
			  		'clear': 'both'
			  		
			  	  } );*/
			  
			  $( '#nav .wrap' ).css( {
			  		'width': '100%',
			  		'padding': '0 5px 0 28px'
			  		} );			  
			  
			  $( '.content-sidebar #content-sidebar-wrap, .full-width-content #content-sidebar-wrap, .sidebar-content #content-sidebar-wrap' ).css( 'width', '100%' );

			  $( '#nav_menu-2' ).css( 'margin-left', '8%' );
			  
			  
			  $( '#nav_menu-3 ul li.item-count-7 a, #nav_menu-3 ul li.item-count-13 a, #nav_menu-3 ul li.item-count-20 a' ).css( 'border-right', '1px solid #D3D3C9' );
	

			 $( '#home-top #widget_sp_image-9' ).css({ 
			 		'width':'70%',
			 		'margin-left': '-25px'
			 	} );


			$( '#home-tabs' ).css( 'margin', '-600px 35px 0 0' );

       }
       
       
       
       if( $( window ).width() < 1115 ) {
       	
       	
       		$( '.wrap #header .widget-area' ).css({
       				'width': '82% !important',
       			 	'margin': '6px 0 0 0'
       			});
       		
       		$( '#text-2' ).css({ 
       				'clear': 'none',
       				'margin-top': '-30px',
       				'margin-right': '25px'
       			 } );
       		
       		
       		$( '#nav' ).css( 'margin', '0px auto' );
       		
       		$( '#header .widget-area #widget_sp_image-3,#header .widget-area #widget_sp_image-2' ).css( 'margin-top', '-25px' );
       	

			$( '#header ul.nav li a, #header ul.menu li a' ).css( 'padding', '7px 8px 5px' );
			
			$( '#home-bottom .post' ).css({
				'width': '100%',
				'margin':'0' } );
				
			
			$( '#home-bottom .post p' ).css( 'clear', 'both' );
			
			
			$( '#home-middle #meteor-slideshow' ).css( 'width', '95% !important' );
			
			
			$( '.nursery .view-girl, .nursery .view-boy, .nursery .back' ).css( 'width', '100%' );
			
			$( '#text-4 a:nth-of-type(1)' ).css( 'margin-bottom', '10px' );
			
			$( '#home-tabs' ).css({ 
					'margin': '-600px 5px 0 0',
					'float': 'right',
					'width': 'auto'
				 });

			
			
			$( '#home-top #widget_sp_image-9' ).css({
					 'width': '73%',
					 'margin-left': '-35px' 
				});

			
			$( '#home-tabs-container' ).css( 'width', '100%' );
			
			$( '#home-top #text-6 h2' ).css( 'font-size', '31px' );
      
      
      	    $( '.wrap #header .widget-area' ).css({
       				'width': '79% !important',
       			 	'margin': '6px 0 0 0'
       			});

       		$( '#title-area' ).css( 'width', '20.25092%' );
       }
       
       
       if( $( window ).width() < 1080 ) {
       	
	       	$( '.sidebar #widget_sp_image-10 h4,.sidebar #widget_sp_image-11 h4,.sidebar #widget_sp_image-12 h4,.sidebar #widget_sp_image-13 h4,.sidebar #widget_sp_image-14 h4,.sidebar #widget_sp_image-15 h4,.sidebar #widget_sp_image-17 h4,.sidebar #widget_sp_image-18 h4,.sidebar #widget_sp_image-19 h4' ).css({
					    "font-size": "14px", 
					    "margin": "12px 6px 12px 6px"
					    
					});
	
	
		
			$( '.sidebar #widget_sp_image-10 img,.sidebar #widget_sp_image-11 img,.sidebar #widget_sp_image-12 img,.sidebar #widget_sp_image-13 img,.sidebar #widget_sp_image-14 img,.sidebar #widget_sp_image-15 img,.sidebar #widget_sp_image-17 img,.sidebar #widget_sp_image-18 img,.sidebar #widget_sp_image-19 img').css({
						"padding": "8px",
						"width": "15%"
					
					});
					
			$( '.sidebar #widget_sp_image-10,.sidebar #widget_sp_image-11,.sidebar #widget_sp_image-12,.sidebar #widget_sp_image-13,.sidebar #widget_sp_image-14,.sidebar #widget_sp_image-15,.sidebar #widget_sp_image-17,.sidebar #widget_sp_image-18,.sidebar #widget_sp_image-19' ).css({
					    "background-image": "none", 
					    "border": "1px solid #ededed"
					    
					});
	
       
       		$( '#home-top #text-6 h4').css("font-size", "26px");
       		$( '#home-top #text-6 h2').css("font-size", "22px");
       		$( '#home-top #text-7').css("margin-left", "-20px");
       		
       		$( '#home-middle #meteor-slides-widget-2' ).css( 'width', '68%' );
       		$( '#home-middle #widget_sp_image-8' ).css( 'width', '31%' );

       		$( '#header .widget-area #widget_sp_image-2' ).css( {
       			'margin-top': '-52px' ,
       			'margin-right':'-31px'
       		});

       		$( '#header .widget-area #widget_sp_image-3' ).css( {
       			'margin-top': '-52px' ,
       		});



       		
	}
	
       
       if( $( window ).width() < 980 ) {
       
       		$( '#home-tabs').css({
       			"margin" : "-600px 5px 0 0",
       			"float" : "right",
       			"width" : "auto"
       		});
       		
       		
       		$( '#home-top #widget_sp_image-9').css({
       			"margin-left" : "-100px",
       			"width" : "80%"
       		});
       		
       		
       		//$( '#home-tabs-container').css("width", "100%");
			//$( '#home-top #text-6 h2').css("font-size", "31px");
       

	   }
	
       
       if( $( window ).width() < 960 ) {
       
          $( '#header,#inner,#home-top-container #home-top,#home-middle-container #home-middle,#home-wrapper,#footer-widgets .wrap,#footer .wrap,#nav .wrap, #nav' ).css( 'min-width', '960px' );
   
	   }
}

})(jQuery);

jQuery(document).ready(function(){ieRespond();});
jQuery(window).resize(function(){ieRespond();});

