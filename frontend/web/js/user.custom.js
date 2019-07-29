$(document).on("locality-select", function(event) {
	// элемент вызвавший событие
	var select = $(event.target).find('select');
	var locality = select.val();
	var current_locality = $(document).find('[data-current-locality]').attr('data-current-locality');
	if (locality === current_locality) {
		$.fancybox.close();
	} else {
		var uri = window.location.href;
		uri = uri.replace(/^http(s)?:\/\/[^\/]+(\/)?/g, '');
		uri = uri.replace(/#.+$/g, '');
		if (current_locality === uri) {
			uri = locality;
		} else if (current_locality === '') {
			if (uri) {
				uri = locality + '/' + uri;
			} else {
				uri = locality
			}
		} else {
			var pattern = new RegExp('^' + current_locality + '\/');
			if (locality === '') {
				uri = uri.replace(pattern, '');
			} else {
				uri = uri.replace(pattern, locality + '/');
			}
		}
		window.location.href = '/' + uri;
	}
});

$(function () {
	$('form.filter-form .filter-submit').click(function(e) {
		e.preventDefault();
		var form = $(this).parents('form.filter-form');
		var locality = form.find('select[name="locality"]').val();
		var category = form.find('select[name="category"]').val();
		var brand = form.find('select[name="brand"]').val();
		var uri = [];
		if (locality && locality !== '0') {
			uri.push(locality);
		}
		if (category && category !== '0') {
			uri.push(category);
		}
		if (brand && brand !== '0') {
			uri.push(brand);
		}
		uri = uri.join('/');
		var current_uri = window.location.href;
		current_uri = current_uri.replace(/^http(s)?:\/\/[^\/]+(\/)?/g, '');
		current_uri = current_uri.replace(/#.+$/g, '');
		if (uri !== current_uri) {
			window.location.href = '/' + uri;
		}
	});
});

$(function () {
	$('.cut-text').each(function () {
		var text_block = $(this);
		var cut_link = text_block.find('.cut-text-link');
		var block_height = text_block.height();
		var text_height = text_block[0].scrollHeight;
		if (text_height > block_height) {
			cut_link.click(function () {
				var cut_link = $(this);
				var text_block = cut_link.parents('.cut-text');
				var block_height = text_block.height();
				var text_height = text_block[0].scrollHeight;
				if (text_height > block_height) {
					text_block.animate({'max-height': text_height + 'px'}, 400);
					cut_link.hide();
				}
			});
		} else {
			cut_link.hide();
		}
	});
});

$(function () {
	// удаляем со слайдов все лишние классы
	$('.swiper-slide').removeClass().addClass('swiper-slide');
	// инициализируем слайдер
	new Swiper ('.service-gallery .swiper-container', {
		slidesPerView: 'auto',
		spaceBetween: 20,
		slidesPerGroup: 3,
		grabCursor: true,
		navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev'
		},
		breakpoints: {
			992: {
				slidesPerGroup: 3
			},
			768: {
				slidesPerGroup: 2
			},
			480: {
				slidesPerGroup: 1
			}
		}
	});
});

$(function () {
	$('.show-phone-link[data-phone-token]').click(function (e) {
		e.preventDefault();

		var button = $(this);
		var wrapper = button.parent();
		var token = button.attr('data-phone-token');
		var short = button[0].hasAttribute('data-phone-short');

		var csrf_param = $('meta[name=csrf-param]').attr("content");
		var csrf_token = $('meta[name=csrf-token]').attr("content");
		var csrf_data = {};
		if (csrf_param && csrf_token) {
			csrf_data[csrf_param] = csrf_token;
		}

		csrf_data['token'] = token;
		$.ajax({
			url: "/ajax/show-phone",
			type: 'post',
			data: csrf_data
		}).done(function(data) {
			if (data != null && data.length) {
				var phones = [];
				$.each(data, function (i, phone) {
					if (!short && phone['comment']) {
						phones.push('<div style="margin-bottom:4px;">' + phone['value'] + '<div style="font-size:12px;line-height:16px;">' + phone['comment'] + '</div></div>');
					} else {
						phones.push('<div style="margin-bottom:4px;">' + phone['value'] + '</div>');
					}
				});
				if (phones.length) {
					wrapper.html(phones.join(''));
					wrapper.css('font-size', '20px');
					wrapper.css('line-height', '20px');
					return true;
				}
			}
			wrapper.text('Нет телефона');
		});
	});
});

$(function () {
	var addressesForm = $('#addresses-form');
	addressesForm.on('click', '.addresses-remove', function(e) {
		e.preventDefault();
		$(this).parents('.form-address-block').remove();
	}).on('click', '.addresses-add', function(e) {
		e.preventDefault();
		var addressList = addressesForm.find('.form-address-list');
		var addressBlocks = addressList.find('.form-address-block');
		var addAddressUrl = addressesForm.attr('data-add-address-url');
		var nextFormId = 0;
		if (addressBlocks.length) {
			nextFormId = addressBlocks.last().attr('data-form-id');
			nextFormId++;
		}
		var formData = {
			id: nextFormId
		};
		var csrf_param = $('meta[name=csrf-param]').attr("content");
		var csrf_token = $('meta[name=csrf-token]').attr("content");
		if (csrf_param && csrf_token) {
			formData[csrf_param] = csrf_token;
		}
		$.ajax({
			url: addAddressUrl,
			type: 'post',
			dataType: 'html',
			data: formData
		}).done(function (data) {
			if (data !== null) {
				var dataBlock = $(data).appendTo(addressList);
				select2update(dataBlock);
				var submitBtn = addressesForm.find('[type="submit"]');
				submitBtn.show();
			}
		});
	}).on('click', '.addresses-save-add', function(e) {
		e.preventDefault();
		addressesForm.append($('<input>', {
			type: 'hidden',
			name: 'save_add',
			value: 1,
		}));
		addressesForm.trigger('submit');
	});
});

function organizationsAddressChangeCoordinates(mapID, coords, address) {
	var formID = mapID.split('address-map-')[1];
	$('input[name="AddressForm[' + formID + '][coordinates]"]').val(coords.join(' '));
	$('input[name="AddressForm[' + formID + '][text]"]').val(address);
}
