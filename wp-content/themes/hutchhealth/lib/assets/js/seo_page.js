/**
 * 	Vivid Image Child Theme
 *  jQuery/Javascript file
 *  @since 03/26/2014
 *  @author Tyler Steinhaus
 */
jQuery( document ).ready(function ( $ ) {
	$( '#add_canonical' ).click( function( evt ) {
		evt.preventDefault();
        evt.stopPropagation();
		$( 'ul.canonical-list li.hide' ).clone( true ).appendTo( 'ul.canonical-list' ).removeClass( 'hide' );
	} );

	$( '#seo-canonical button.remove_row' ).click( function( evt ) {
		evt.preventDefault();
        evt.stopPropagation();
        $( this ).parent().parent().parent().remove();
	} );

	$( '#add_redirect' ).click( function( evt ) {
		evt.preventDefault();
        evt.stopPropagation();
		$( 'ul.redirect-list li.hide' ).clone( true ).insertAfter( 'ul.redirect-list li.title' ).removeClass( 'hide' );
	} );

	$( '#seo-redirects button.remove_row' ).click( function( evt ) {
		evt.preventDefault();
        evt.stopPropagation();
        $( this ).parent().parent().parent().remove();
	} );
} );