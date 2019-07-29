/**
 * Update all select2 widgets.
 * It selector is defined, function updates select2 widgets
 * within elements inside this selector.
 *
 * selector - jQuery list of objects
 */
var select2update = function(selector) {
	$.fn.select2.defaults.set("ajax--data-type", "json");
	$.fn.select2.defaults.set("ajax--method", "post");
	var body = $('body');
	var param = $('meta[name=csrf-param]').attr("content");
	var token = $('meta[name=csrf-token]').attr("content");
	var csrf_data = {};
	if (param && token) {
		csrf_data[param] = token;
	}
	var select;
	if (typeof selector !== 'undefined') {
		select = selector.find('[data-select2]');
	} else {
		select = $('[data-select2]');
	}
	select.each(function () {
		var wrapper = $(this);
		var wrapper_id = wrapper.attr('id');
		if (!wrapper_id) {
			wrapper_id = 'wrapper_' + Math.ceil(Math.random() * 10000);
			wrapper.attr('id', wrapper_id);
		}
		if (wrapper[0].hasAttribute('data-dropdown-inplace') && wrapper.attr('data-dropdown-inplace') !== '0') {
			body.append(
				'<style>' +
				'#' + wrapper_id + ' .select2-container{display:block;position:relative!important;top:0!important;}' +
				'#' + wrapper_id + ' .select2-dropdown{display:block;position:relative!important;top:0!important;}' +
				'#' + wrapper_id + ' .select2-search{margin-top:0!important;}' +
				'</style>'
			);
		}
		var select = wrapper.find('select');
		var select_border_color = select.css('border-top-color');
		var select_border_width = select.css('border-top-width');
		var select_border_style = select.css('border-top-style');
		body.append(
			'<style>' +
			'#' + wrapper_id + ' .select2-container .select2-selection{' +
			'border-color:' + select_border_color +';' +
			'border-width:' + select_border_width + ';' +
			'border-style:' + select_border_style + ';' +
			'}' +
			'</style>'
		);
		// присваиваем опции по умолчанию
		var select2_options = {
			dropdownParent: wrapper,
			width: '100%'
		};
		// остальные опции извлекаем из атрибутов обертки
		if (wrapper.attr('data-placeholder')) {
			select2_options['placeholder'] = wrapper.attr('data-placeholder');
		}
		if (wrapper.attr('data-tags')) {
			select2_options['tags'] = true;
		}
		if (wrapper.attr('data-allow-clear')) {
			select2_options['allowClear'] = true;
		}
		if (wrapper.attr('data-ajax--url')) {
			select2_options['ajax'] = {
				url: wrapper.attr('data-ajax--url'),
				cache: wrapper.attr('data-ajax--cache'),
				data: function (params) {
					var data = Object.assign({}, csrf_data);
					data['term'] = params.term;
					data['q'] = params.term;
					data['_type'] = params._type;
					data['page'] = params.page;
					// chained selects
					if (wrapper.attr('data-depends-on')) {
						var master_select = wrapper.siblings(wrapper.attr('data-depends-on')).find('select');
						if (master_select.val()) {
							data[master_select.attr('name')] = master_select.val();
						}
					}
					return data;
				}
			}
		}
		var select_height = select.outerHeight() + "px";
		select.select2(select2_options);
		wrapper.find('.select2-selection').css({"height":select_height});
		wrapper.find('.select2-selection__rendered').css({"line-height":select_height});
		var button = wrapper.find('[data-select2-button]');
		if (button.length) {
			wrapper.find('b[role="presentation"]').hide();
			wrapper.find('.select2-selection__arrow').append(button);
			button.css({"right":"-1px","top":"-1px"});
		}
		// events for chained selects
		var wrappers = wrapper.parent().find('[data-select2]');
		wrapper.on('change.select2', function () {
			// selects dependent on current select needs to be reset
			wrappers.filter('[data-depends-on="#' + wrapper_id + '"]').find('select').val(0).trigger("change");
		});
		// custom events
		var onselect_event = wrapper.attr('data-onselect-event');
		if (onselect_event) {
			wrapper.on('change.select2', function () {
				// triggering custom event (you need to handle it in your logic)
				wrapper.trigger(onselect_event);
			});
		}
	});
};

$(function () {
	select2update();
});