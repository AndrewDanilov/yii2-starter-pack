$(function () {
	$('.more-btn').click(function (e) {
		e.preventDefault();
		var button = $(this);
		var url = button.attr('href');
		var wrapper = button.parents('.wrapper-catalog-store').find('.wrapper-catalog-cards');
		var total_count = wrapper.attr('data-total-count');
		var param = $('meta[name=csrf-param]').attr("content");
		var token = $('meta[name=csrf-token]').attr("content");
		var csrf_data = {};
		if (param && token) {
			csrf_data[param] = token;
		}
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'html',
			data: csrf_data
		}).done(function (html) {
			wrapper.append(html);
			var url_parts = url.split('offset=');
			var offset = wrapper.children().length;
			if (offset >= total_count) {
				button.parent().remove();
			} else {
				url = url_parts[0] + 'offset=' + offset;
				button.attr('href', url);
			}
		});
	});
});