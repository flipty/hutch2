(function($, $window, $document){

$('body').on('mpfy_instance_created', function(e, map_instance){
	var container = $(map_instance.container);
	var searchDropdown = container.find('select[name="mpfy_search_radius"]:first');
	if (searchDropdown.length == 0) {
		return;
	}

	searchDropdown.on('change', function(){
		map_instance.search_radius = parseInt($(this).val());
	}).trigger('change');
});

})(jQuery, jQuery(window), jQuery(document));