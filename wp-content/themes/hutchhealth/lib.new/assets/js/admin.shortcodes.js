( function() {

	/**
	 * Adds a button to add a button shortcode
	 */
	tinymce.PluginManager.add( 'viButton', function( editor, url ) {
		editor.addButton( 'viButton_button', {
			text: '',
			icon: false,
			onclick: function() {
				editor.windowManager.open( {
					title: 'Add Button',
					body: [{
						type: 'textbox',
						name: 'title',
						label: 'Title',
						value: editor.selection.getContent()
					},{
						type: 'textbox',
 						name: 'link',
						label: 'Link'
					},{
                    	type: 'checkbox',
                    	name: 'target',
                    	label: 'Open in new Window'
                    }],
                    onsubmit: function( e ) {
                        // Check to see if target is true
                        var target = '';
                        if( e.data.target == true ) {
                        	var target = ' target="_blank"';
                        }
                        editor.insertContent( '[button link="'+e.data.link+'"'+target+']'+e.data.title+'[/button]' );
                    }
                } );
            }
        } );
    } );

    /**
     * Adds a button so we can add accordion shortcode
     */
    tinymce.PluginManager.add( 'viAccordion', function( editor, url ) {
        editor.addButton( 'viAccordion_button', {
            text: '',
            icon: false,
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Add Accordions',
                    width: 500,
                    height: 500,
                    url: url.substring(0, ( url.length - 2 ) )+'shortcodes.php',
                    inline: 'yes',
                });
            }
        } );
    } );
} )();