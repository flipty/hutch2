/**
 * Shows all element information in the console
 * @author Tyler Steinhaus
 *
 * @param string obj - element
 */
function show_object( obj ){
	var str = ""; //variable which will hold property values
	for( prop in obj ) {
		str += prop+" value: "+obj[prop]+"\n";
	}
	console.log( str );
}

/**
 * Add Class to Element
 * @author Tyler Steinhaus
 *
 * @param string element - element to add class
 * @param string className - class to add to element
 */
var addClass = function( element, className ) {
	if( element.classList ) {
		element.classList.add( className );
	} else {
		element.className += ' ' + className;
	}
};

/**
 * Remove Class from element
 * @author Tyler Steinhaus
 *
 * @param string element - element to remove class from
 * @param string className - class to remove element
 */
var removeClass = function( element, className ) {
	if( element.classList ) {
		element.classList.remove( className );
	} else {
		element.className = element.className.replace( new RegExp( '(^|\\b)' + className.split( ' ' ).join( '|' ) + '(\\b|$)', 'gi' ), ' ' );
	}
};

/**
 * Will add a div with a class sf-sub-indicator.
 * This will allow the mobile menu to slide for sub menus
 * @author Tyler Steinhaus
 *
 * @param string element - Element to loop so we can check for sub menus
 */
var subMenuIndicator = function( element ) {
	if( document.querySelector( element ) ) { // Check to see if element exists
		var elements = [].slice.call( document.querySelectorAll( element ) ); // Create an array of all the elements
		elements.forEach( function( e ) { // Loop through the elements
			if( e.classList.contains( 'menu-item-has-children' ) ) { // Check to see if menu-item-has-children is a class for the li
				var id = e.id; // get the id but also easier to call this way
				var sfIndicator = document.createElement( 'div' ); // create div
				sfIndicator.classList.add( 'sf-sub-indicator' ); // add class sf-sub-indicator to newly created div
				document.querySelector( '#'+id+' a' ).appendChild( sfIndicator ); // Append new div after link.
			}
		} );
	}
};

/**
 * Default text in input box
 * @author Tyler Steinhaus
 *
 * @param string id - id or class of input box
 * @param string text - default text
 */
var focusEffect = function( id, text ) {
	var element = document.querySelector( id );
	if( element ) {
		if( element.value == '' ) {
			element.value = text;
		}

		element.onfocus = function() {
			if( element.value == text ) {
				element.value == '';
			}
		};

		element.onblur = function() {
			if( element.value == '' ) {
				element.value = text;
			}
		};
	}
};

/**
 * Hover over an image for alternative image
 * @author Tyler Steinhaus
 *
 * @param string id - id or class of the parent element for the img
 * @param string newImage - image to replace on hover
 */
var hoverEffect = function( id, newImage) {
	var mainImage = document.querySelector( id + ' img' );
	if( mainImage ) {
		var mainImageSrc = mainImage.src;
		document.querySelector( id ).onmouseover = function() {
			document.querySelector( id + ' img' ).src = newImage;
		};
		document.querySelector( id ).onmouseout = function() {
			document.querySelector( id + ' img' ).src = mainImageSrc;
		};
	}
};

/**
 * Sidebar moves with page scrolling
 * @author Tyler Steinhaus
 *
 * @param string sidebar - id or class of the sidebar
 * @param int extraOffset - Add any padding to the top of the sidebar
 * @param int header - What the height of the header is (Mainly for fixed header)
 * @param int endPoint - @TODO when the menu should stop sliding
 */
var fixedSidebar = function( sidebar, extraOffset, header, endPoint ) {
	var sidebar = document.querySelector( sidebar );
	if( sidebar ) {
		var offset = sidebar.getBoundingClientRect();
		var defaultTop = offset.top;
		var topPadding = extraOffset;

		var headerOffset = header;
		if( document.querySelector( '#wpadminbar' ) != null ) {
			headerOffset += 32;
		}

		document.onscroll = function() {
			var topOffset = ( offset.top - sidebar.scrollTop + sidebar.clientTop );
			if( ( document.body.scrollTop + headerOffset ) > ( offset.top ) ) {
				var newOffset = ( document.body.scrollTop + headerOffset ) - ( topOffset ) + topPadding;
 				sidebar.style.marginTop = newOffset+'px';
			} else {
				sidebar.style.marginTop = endPoint;
			}
		};
	}
};

/**
 * Gives ability to add parallax to a background
 * @author Tyler Steinhaus
 *
 * @param string id - id or class of background
 */
var parallax = function( id ) {
	if( document.querySelector( id ) ) {
		window.onscroll = function( event ) {
			scrolltop = document.body.scrollTop;
			document.querySelector( id ).style.backgroundPosition = "50% "+ ( scrolltop / 2 ) + "px";
		};
	}
};

/**
 * Allows you to center widgets/elements inside a container
 * @author Tyler Steinhaus
 *
 * @param array elements - list of elements to center
 * @param int containerHeight - height of container to center element in
 */
var elementCenter = function( elements, containerHeight ) {
	elements.forEach( function( element ) {
		if( document.querySelector( element ) ) { // Check to see if element exists
			var elementHeight = document.querySelector( element ).offsetHeight; // Get element height
			var marginTop = ( ( containerHeight / 4 ) - ( elementHeight / 4 ) ); // Find how far the element needs to be pushed down
			document.querySelector( element ).style.marginTop = marginTop + 'px'; // Give the element margin-top
		}
	} );
};