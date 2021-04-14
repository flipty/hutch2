(function($, $window, $document){

function mpfy_mll_mirror_list(map_instance, mll_container, sortByDistance) {
	sortByDistance = (typeof sortByDistance == 'undefined') ? false : sortByDistance;

	for (var i = 0; i < map_instance.markers.length; i++) {
		var marker = map_instance.markers[i];
		var location_id = marker._mpfy.pin_id;

		if (marker.getVisible()) {
			mll_container.find('.mpfy-mll-location[data-id="' + location_id + '"]').removeClass('mpfy-mll-filter-hidden');
		} else {
			mll_container.find('.mpfy-mll-location[data-id="' + location_id + '"]').addClass('mpfy-mll-filter-hidden');
		}
	}

	var list = mll_container.find('.mpfy-mll-location:first').parent();
	mll_container.find('.mpfy-mll-location').sort(function(a, b){
		if (sortByDistance && map_instance.lastSearchPosition != null) {
			var markerA = map_instance.getMarkerByLocationId($(a).attr('data-id'));
			var markerB = map_instance.getMarkerByLocationId($(b).attr('data-id'));
			var distanceA = google.maps.geometry.spherical.computeDistanceBetween(map_instance.lastSearchPosition, markerA.getPosition());
			var distanceB = google.maps.geometry.spherical.computeDistanceBetween(map_instance.lastSearchPosition, markerB.getPosition());
			

			if (isNaN(distanceA) && isNaN(distanceB)) {
				return 0;
			}
			if (isNaN(distanceA)) {
				return 1;
			}
			if (isNaN(distanceB)) {
				return -1;
			}
			return distanceA - distanceB;
		}
		return parseInt($(a).attr('data-order')) - parseInt($(b).attr('data-order'));
	}).appendTo(list);

	$(map_instance.container).trigger('mpfy_mll_recalculate_paging');
}

function mpfy_mll_recalculate_paging(map_instance, mll_container) {
	var paging = mll_container.find('.mpfy-mll-paging');
	var items = mll_container.find('.mpfy-mll-location');
	var per_page = parseInt(paging.attr('data-number'));
	per_page = (isNaN(per_page)) ? 3 : Math.abs(per_page);
	var pages = Math.ceil(items.not('.mpfy-mll-filter-hidden').length / per_page);
	var current_page = 0;

	if (pages <= 1) {
		paging.hide();
	} else {
		paging.show();
	}
	
	$(map_instance.container).data('mpfy_mll_paging', {
		per_page: per_page,
		items: items,
		pages: pages,
		current_page: current_page
	});

	$(map_instance.container).trigger($.Event('mpfy_mll_paging_change_page', {
		settings: {
			current_page: current_page
		}
	}));
}

$('body').on('mpfy_instance_created', function(e, map_instance){
	$(map_instance.container).find('.mpfy-mll').each(function() {
		var container = $(map_instance.container);
		var mll_container = $(this);

		container.find('.mpfy-mll-l-heading').click(function(e) {
			if ($(e.target).is('.mpfy-mll-l-categories a')) {
				return;
			}

			var parent = $(this).closest('.mpfy-mll-location');
			parent.siblings('.mpfy-mll-location').find('.mpfy-mll-l-content').each(function() {
				$(this).slideUp().closest('.mpfy-mll-location').removeClass('active');
			});

			if (parent.find('.mpfy-mll-l-content:first').is(':visible')) {
				$(this).closest('.mpfy-mll-location').removeClass('active');
				parent.find('.mpfy-mll-l-content:first').slideUp();
			} else {
				$(this).closest('.mpfy-mll-location').addClass('active');
				parent.find('.mpfy-mll-l-content:first').slideDown();

				container.trigger($.Event('mpfy_highlight_pin', {
					settings: {
						'location_id': parent.attr('data-id')
					}
				}));
			}
		});

		container.on('mpfy_search', function(e) {
			mpfy_mll_mirror_list(map_instance, mll_container, true);
		});

		container.on('mpfy_filter_applied', function(e) {
			mpfy_mll_mirror_list(map_instance, mll_container);
		});

		container.on('mpfy_mll_recalculate_paging', function(e) {
			mpfy_mll_recalculate_paging(map_instance, mll_container);
		});

		container.on('mpfy_mll_paging_change_page', function(e) {
			var paging = mll_container.find('.mpfy-mll-paging');
			var settings = container.data('mpfy_mll_paging');
			var current_page = e.settings.current_page;
			current_page = Math.max(0, Math.min(settings.pages - 1, current_page));
			settings.current_page = current_page;
			container.data('mpfy_mll_paging', settings);

			var start = current_page * settings.per_page;
			var end = start + settings.per_page;

			settings.items.addClass('mpfy-mll-paging-hidden');
			var index = 0;
			settings.items.each(function() {
				if (!$(this).hasClass('mpfy-mll-filter-hidden')) {
					if (index >= start && index <= end - 1) {
						$(this).removeClass('mpfy-mll-paging-hidden');
					}
					index ++;
					if (index > end) {
						return; // break
					}
				}
			});

			paging.find('.mpfy-mll-paging-current-page').text(current_page + 1);
			paging.find('.mpfy-mll-paging-max-page').text(settings.pages);
		});

		mll_container.find('.mpfy-mll-button-prev').click(function(e) {
			e.preventDefault();

			var settings = container.data('mpfy_mll_paging');
			container.trigger($.Event('mpfy_mll_paging_change_page', {
				settings: {
					current_page: settings.current_page - 1
				}
			}));
		});

		mll_container.find('.mpfy-mll-button-next').click(function(e) {
			e.preventDefault();

			var settings = container.data('mpfy_mll_paging');
			container.trigger($.Event('mpfy_mll_paging_change_page', {
				settings: {
					current_page: settings.current_page + 1
				}
			}));
		});

		container.trigger('mpfy_mll_recalculate_paging');
	});
});

})(jQuery, jQuery(window), jQuery(document));