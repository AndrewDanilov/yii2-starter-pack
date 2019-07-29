$(function () {
	$('[data-slider]').each(function () {
		var slider = $(this);
		var slides_count = slider.attr('data-slider');
		var margin = slider.attr('data-slider-margin');
		var group = slider.attr('data-slider-group');
		var freemode = slider.attr('data-slider-freemode');
		var loop = slider.attr('data-slider-loop');
		var breakpoints = slider.attr('data-slider-breakpoints');
		if (breakpoints) {
			breakpoints = breakpoints.split(',');
		} else {
			breakpoints = [];
		}
		// собираем опции слайдера
		var options = {
			grabCursor: true,
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev'
			},
			breakpoints: {}
		};
		if (slides_count === 'auto') {
			options.slidesPerView = 'auto';
		} else if (slides_count) {
			options.slidesPerView = parseInt(slides_count);
		}
		if (margin) {
			options.spaceBetween = parseInt(margin);
		}
		if (group) {
			options.slidesPerGroup = parseInt(group);
		}
		if (freemode) {
			options.freeMode = true;
		}
		if (loop) {
			options.freeMode = true;
		}
		// собираем опции слайдера для брейкпоинтов
		for (var i=0; i < breakpoints.length; i++) {
			var breakpoint = parseInt(breakpoints[i]).toString();
			var breakpoint_slides_count = slider.attr('data-slider-breakpoint-' + breakpoint);
			var breakpoint_margin = slider.attr('data-slider-breakpoint-' + breakpoint + '-margin');
			var breakpoint_group = slider.attr('data-slider-breakpoint-' + breakpoint + '-group');
			if (breakpoint_slides_count === 'auto') {
				options.breakpoints[breakpoint].slidesPerView = 'auto';
			} else if (breakpoint_slides_count) {
				options.breakpoints[breakpoint].slidesPerView = parseInt(breakpoint_slides_count);
			}
			if (breakpoint_margin) {
				options.breakpoints[breakpoint].spaceBetween = parseInt(breakpoint_margin);
			}
			if (breakpoint_group) {
				options.breakpoints[breakpoint].slidesPerGroup = parseInt(breakpoint_group);
			}
		}
		// создаем слайдер
		new Swiper (slider, options);
	});
});