( function() {
	/**
	 * Adds a button to add a button shortcode
	 */
	tinymce.PluginManager.add( 'viButton', function( editor, url ) {
		editor.addButton( 'viButton_button', {
			text: '',
			icon: false,
            title: 'Add a Button',
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
            title: 'Add an Accordion',
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


    /**
     * Adds a button so we can add tabs shortcode
     */
    tinymce.PluginManager.add( 'viTabs', function( editor, url ) {
        editor.addButton( 'viTabs_button', {
            text: '',
            icon: false,
            title: 'Add Tabs',
            onclick: function() {
                tabs_url = url.substring(0, ( url.length - 2 ) )+'tabsshortcodes.php';
                if( vertical_tabs == true ) {
                    tabs_url = url.substring(0, ( url.length - 2 ) )+'tabsshortcodes.php?vertical_tabs=true';
                }
                editor.windowManager.open( {
                    title: 'Add Tabs',
                    width: 500,
                    height: 500,
                    url: tabs_url,
                    inline: 'yes',
                });
            }
        } );
    } );


    /**
     * Adds a button so we can add columns shortcode
     */

    tinymce.PluginManager.add( 'viColumns', function( editor, url ) {
            editor.addButton( 'Columns', {
                type: 'listbox',
                text: 'Columns',
                icon: false,
                onselect: function(e) {
                }, 
                values: [
                    {text: '2 Columns', onclick : function() {
                        editor.insertContent('[one-half-first]Column 1 Content[/one-half-first]');
                        editor.insertContent('[one-half]Column 2 Content[/one-half]');                 
                    }},
                     
                    {text: '3 Columns', onclick : function() {
                        editor.insertContent('[one-third-first]Column 1 Content[/one-third-first]');  
                        editor.insertContent('[one-third]Column 2 Content[/one-third]');  
                        editor.insertContent('[one-third]Column 3 Content[/one-third]');                           
                    }},

                    {text: '4 Columns', onclick : function() {
                        editor.insertContent('[one-fourth-first]Column 1 Content[/one-fourth-first]');  
                        editor.insertContent('[one-fourth]Column 2 Content[/one-fourth]');  
                        editor.insertContent('[one-fourth]Column 3 Content[/one-fourth]');  
                        editor.insertContent('[one-fourth]Column 4 Content[/one-fourth]');                         
                    }},

                    {text: '5 Columns', onclick : function() {
                        editor.insertContent('[one-fifth-first]Column 1 Content[/one-fifth-first]');  
                        editor.insertContent('[one-fifth]Column 2 Content[/one-fifth]');  
                        editor.insertContent('[one-fifth]Column 3 Content[/one-fifth]');  
                        editor.insertContent('[one-fifth]Column 4 Content[/one-fifth]'); 
                        editor.insertContent('[one-fifth]Column 5 Content[/one-fifth]');                          
                    }},

                    {text: '6 Columns', onclick : function() {
                        editor.insertContent('[one-sixth-first]Column 1 Content[/one-sixth-first]');  
                        editor.insertContent('[one-sixth]Column 2 Content[/one-sixth]');  
                        editor.insertContent('[one-sixth]Column 3 Content[/one-sixth]');  
                        editor.insertContent('[one-sixth]Column 4 Content[/one-sixth]');  
                        editor.insertContent('[one-sixth]Column 5 Content[/one-sixth]'); 
                        editor.insertContent('[one-sixth]Column 6 Content[/one-sixth]');                          
                    }},

                    {text: 'Clear Floats', onclick : function() {
                        editor.insertContent('[clear]');
                    }},
                ]
            });
    });


} )();