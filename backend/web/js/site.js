$(function () {
	$('[data-group-option-id]')
		.on('click', '.option-group-add', function () {
			var groupsWrapper = $(this).parents('[data-group-option-id]');
			var optionId = groupsWrapper.attr('data-group-option-id');
			var groups = groupsWrapper.find('.option-groups');
			$.ajax({
				url: '/admin/shop-product/option-group?optionId=' + optionId,
				type: 'post',
				dataType: 'html'
			}).done(function (html) {
				if (html !== null) {
					groups.append(html);
				}
			});
		})
		.on('click', '.option-group-remove', function () {
			var group = $(this).parents('.option-group');
			group.remove();
		});
});