/**
 * 	Vivid Image Message Bar
 *  jQuery/Javascript file
 *  @since 08/13/2014
 *  @author Tyler Steinhaus
 *
 *  @updated 09/11/2014
 */
jQuery(document).ready(function ( $ ) {

	/**
	 * Add Marquee to the Message bar is the browsers width is less than 960px.
	 *
	 * @since 08/27/2014
	 * @author Tyler Steinhaus
	 */
	$( window ).resize(function() {
		var adminbar = $( '.vi-message-bar.admin-bar' );

		if ( $('body').hasClass('message-bar') ) {
			var show_message_bar = 1;
		}

		if( $( '.vi-message-bar' ).length != 0 && $( window ).width() <= 960 ) {
			var marquee_div = $('.vi-message-bar .js-marquee').length;
			if ( marquee_div == 0 ) {
				var $marquee = $( '.vi-message-bar' ).marquee({
					duration: 18000
				});
			}
		}
	});

	$( window ).load(function() {
		var scroll_status = $('.vi-message-bar').hasClass('scrollenabled');

		if( $( '.vi-message-bar' ).length != 0 && $( window ).width() <= 960 ) {
			var $marquee = $( '.vi-message-bar' ).marquee({
				duration: 18000
			});
		}

		if ( scroll_status ) {
			var $marquee = $( '.vi-message-bar' ).marquee({
				duration: 18000
			});
		}
	});

	if( $( '.vi-message-bar.delay' ).length == 0 ) {
		// Let's check to see if the admin bar is on the screen, if so we need to set our top and padding-top differently
		var adminbar = $( '.vi-message-bar.admin-bar' );
		var wp_adminbar = $( '#wpadminbar' );
		var top = '0px';
		var adminbar_top = 0;

		// Bring in support for Shiftnav Mobile Menu
		var shiftnav = $( '#shiftnav-toggle-main' );
		if ( shiftnav.length != 0 ) {
			shiftnav_top = '0px';
			if( shiftnav.css( 'display' ) != 'none' ) {
				shiftnav_top = shiftnav.css( 'height' ).replace( 'px', '' );
			}

			top = ( parseInt( adminbar_top ) + parseInt( shiftnav_top ) );
		} else {
			top = parseInt( adminbar_top );
		}

		$( '.vi-message-bar' ).css( 'top', top );
	}

	// Check to see if there is a delay or not.
	if( $( '.vi-message-bar.delay' ).length != 0 ) {
		// Remove the top padding on the body so we can animate it when the message bar appears
		// $( 'body').css( 'padding-top', '0px' );

		// When the window fully loads let's display the bar
		$( window ).load( function() {
			// Let's check to see if the admin bar is on the screen, if so we need to set our top and padding-top differently
			var adminbar = $( '.vi-message-bar.admin-bar' );
			var wp_adminbar = $( '#wpadminbar' );
			var top = '0px';

			// Bring in support for Shiftnav Mobile Menu
			var shiftnav = $( '#shiftnav-toggle-main' );
			if ( shiftnav.length != 0 ) {
				shiftnav_top = '0px';
				if( shiftnav.css( 'display' ) != 'none' ) {
					shiftnav_top = shiftnav.css( 'height' ).replace( 'px', '' );
				}

				top = ( parseInt( adminbar_top ) + parseInt( shiftnav_top ) );
			} else {
				top = parseInt( adminbar_top );
			}
		} );
	}

	// Close the message bar if the 'X' is clicked
	$( '.vi-message-bar span.close' ).click( function( e ) {
		$( '#vi-message-bar' ).animate( {
			height: '0px'
		}, 200 );
		
		$('body' ).removeClass('message-bar');

		document.cookie = 'MBcookie=vimmmessagebar;path=/';
	});
});

/**
 * jQuery.marquee - scrolling text like old marquee element
 * @author Aamir Afridi - aamirafridi(at)gmail(dot)com / http://aamirafridi.com/jquery/jquery-marquee-plugin
 */
(function(f){f.fn.marquee=function(x){return this.each(function(){var a=f.extend({},f.fn.marquee.defaults,x),b=f(this),c,t,e=3,y="animation-play-state",p=!1,E=function(a,b,c){for(var e=["webkit","moz","MS","o",""],d=0;d<e.length;d++)e[d]||(b=b.toLowerCase()),a.addEventListener(e[d]+b,c,!1)},F=function(a){var b=[],c;for(c in a)a.hasOwnProperty(c)&&b.push(c+":"+a[c]);b.push();return"{"+b.join(",")+"}"},l={pause:function(){p&&a.allowCss3Support?c.css(y,"paused"):f.fn.pause&&c.pause();b.data("runningStatus",
"paused");b.trigger("paused")},resume:function(){p&&a.allowCss3Support?c.css(y,"running"):f.fn.resume&&c.resume();b.data("runningStatus","resumed");b.trigger("resumed")},toggle:function(){l["resumed"==b.data("runningStatus")?"pause":"resume"]()},destroy:function(){clearTimeout(b.timer);b.find("*").addBack().unbind();b.html(b.find(".js-marquee:first").html())}};if("string"===typeof x)f.isFunction(l[x])&&(c||(c=b.find(".js-marquee-wrapper")),!0===b.data("css3AnimationIsSupported")&&(p=!0),l[x]());else{var u;
f.each(a,function(c,d){u=b.attr("data-"+c);if("undefined"!==typeof u){switch(u){case "true":u=!0;break;case "false":u=!1}a[c]=u}});a.speed&&(a.duration=parseInt(b.width(),10)/a.speed*1E3);var v="up"==a.direction||"down"==a.direction;a.gap=a.duplicated?parseInt(a.gap):0;b.wrapInner('<div class="js-marquee"></div>');var h=b.find(".js-marquee").css({"margin-right":a.gap,"float":"left"});a.duplicated&&h.clone(!0).appendTo(b);b.wrapInner('<div style="width:100000px" class="js-marquee-wrapper"></div>');
c=b.find(".js-marquee-wrapper");if(v){var k=b.height();c.removeAttr("style");b.height(k);b.find(".js-marquee").css({"float":"none","margin-bottom":a.gap,"margin-right":0});a.duplicated&&b.find(".js-marquee:last").css({"margin-bottom":0});var q=b.find(".js-marquee:first").height()+a.gap;a.startVisible&&!a.duplicated?(a._completeDuration=(parseInt(q,10)+parseInt(k,10))/parseInt(k,10)*a.duration,a.duration*=parseInt(q,10)/parseInt(k,10)):a.duration*=(parseInt(q,10)+parseInt(k,10))/parseInt(k,10)}else{var m=
b.find(".js-marquee:first").width()+a.gap;var n=b.width();a.startVisible&&!a.duplicated?(a._completeDuration=(parseInt(m,10)+parseInt(n,10))/parseInt(n,10)*a.duration,a.duration*=parseInt(m,10)/parseInt(n,10)):a.duration*=(parseInt(m,10)+parseInt(n,10))/parseInt(n,10)}a.duplicated&&(a.duration/=2);if(a.allowCss3Support){h=document.body||document.createElement("div");var g="marqueeAnimation-"+Math.floor(1E7*Math.random()),A=["Webkit","Moz","O","ms","Khtml"],B="animation",d="",r="";h.style.animation&&
(r="@keyframes "+g+" ",p=!0);if(!1===p)for(var z=0;z<A.length;z++)if(void 0!==h.style[A[z]+"AnimationName"]){h="-"+A[z].toLowerCase()+"-";B=h+B;y=h+y;r="@"+h+"keyframes "+g+" ";p=!0;break}p&&(d=g+" "+a.duration/1E3+"s "+a.delayBeforeStart/1E3+"s infinite "+a.css3easing,b.data("css3AnimationIsSupported",!0))}var C=function(){c.css("transform","translateY("+("up"==a.direction?k+"px":"-"+q+"px")+")")},D=function(){c.css("transform","translateX("+("left"==a.direction?n+"px":"-"+m+"px")+")")};a.duplicated?
(v?a.startVisible?c.css("transform","translateY(0)"):c.css("transform","translateY("+("up"==a.direction?k+"px":"-"+(2*q-a.gap)+"px")+")"):a.startVisible?c.css("transform","translateX(0)"):c.css("transform","translateX("+("left"==a.direction?n+"px":"-"+(2*m-a.gap)+"px")+")"),a.startVisible||(e=1)):a.startVisible?e=2:v?C():D();var w=function(){a.duplicated&&(1===e?(a._originalDuration=a.duration,a.duration=v?"up"==a.direction?a.duration+k/(q/a.duration):2*a.duration:"left"==a.direction?a.duration+n/
(m/a.duration):2*a.duration,d&&(d=g+" "+a.duration/1E3+"s "+a.delayBeforeStart/1E3+"s "+a.css3easing),e++):2===e&&(a.duration=a._originalDuration,d&&(g+="0",r=f.trim(r)+"0 ",d=g+" "+a.duration/1E3+"s 0s infinite "+a.css3easing),e++));v?a.duplicated?(2<e&&c.css("transform","translateY("+("up"==a.direction?0:"-"+q+"px")+")"),t={transform:"translateY("+("up"==a.direction?"-"+q+"px":0)+")"}):a.startVisible?2===e?(d&&(d=g+" "+a.duration/1E3+"s "+a.delayBeforeStart/1E3+"s "+a.css3easing),t={transform:"translateY("+
("up"==a.direction?"-"+q+"px":k+"px")+")"},e++):3===e&&(a.duration=a._completeDuration,d&&(g+="0",r=f.trim(r)+"0 ",d=g+" "+a.duration/1E3+"s 0s infinite "+a.css3easing),C()):(C(),t={transform:"translateY("+("up"==a.direction?"-"+c.height()+"px":k+"px")+")"}):a.duplicated?(2<e&&c.css("transform","translateX("+("left"==a.direction?0:"-"+m+"px")+")"),t={transform:"translateX("+("left"==a.direction?"-"+m+"px":0)+")"}):a.startVisible?2===e?(d&&(d=g+" "+a.duration/1E3+"s "+a.delayBeforeStart/1E3+"s "+a.css3easing),
t={transform:"translateX("+("left"==a.direction?"-"+m+"px":n+"px")+")"},e++):3===e&&(a.duration=a._completeDuration,d&&(g+="0",r=f.trim(r)+"0 ",d=g+" "+a.duration/1E3+"s 0s infinite "+a.css3easing),D()):(D(),t={transform:"translateX("+("left"==a.direction?"-"+m+"px":n+"px")+")"});b.trigger("beforeStarting");if(p){c.css(B,d);var h=r+" { 100%  "+F(t)+"}",l=c.find("style");0!==l.length?l.filter(":last").html(h):f("head").append("<style>"+h+"</style>");E(c[0],"AnimationIteration",function(){b.trigger("finished")});
E(c[0],"AnimationEnd",function(){w();b.trigger("finished")})}else c.animate(t,a.duration,a.easing,function(){b.trigger("finished");a.pauseOnCycle?b.timer=setTimeout(w,a.delayBeforeStart):w()});b.data("runningStatus","resumed")};b.bind("pause",l.pause);b.bind("resume",l.resume);a.pauseOnHover&&(b.bind("mouseenter",l.pause),b.bind("mouseleave",l.resume));p&&a.allowCss3Support?w():b.timer=setTimeout(w,a.delayBeforeStart)}})};f.fn.marquee.defaults={allowCss3Support:!0,css3easing:"linear",easing:"linear",
delayBeforeStart:1E3,direction:"left",duplicated:!1,duration:5E3,gap:20,pauseOnCycle:!1,pauseOnHover:!1,startVisible:!1}})(jQuery);