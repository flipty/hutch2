( function() {
    tinymce.PluginManager.add( 'viDocmanager', function( editor, url ) {
        var newURL = url.substring(0, ( url.length - 3 ) ) + 'admin/css/vimm-dm-admin.css';

        editor.addButton( 'viDocmanager_button', {
            title: 'Add a Document',
            onclick: function() {
                editor.windowManager.open( {
                    title: 'Add a Document',
                    maximizable: true,
                    inline : 1,
                    width: 500,
                    height: 500,
                    //load the form via an AJAX call so we can build our lists of available categories and documents in PHP
                    url: ajaxurl+'?action=tinymcepopup',
                });
            }
        });
    });
})();