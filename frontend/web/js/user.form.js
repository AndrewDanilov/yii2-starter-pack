$(function () {
	$('form[data-mark]').each(function () {
		var mark = $(this).attr('data-mark');
		var mark_el = $(this).find('input[name="mark"]');
		if (mark_el.length) {
			mark_el.remove();
		}
		$('<input />', {
			'type': 'hidden',
			'name': 'mark',
			'value': mark,
			appendTo: $(this)
		});
	});
	$('[data-fancybox][data-mark]').click(function () {
		var mark = $(this).attr('data-mark');
		var button_val = $(this).text();

		// отметки ставим только на формах с атрибутом data-lightbox
		var form = $('form[data-lightbox]');

		var title = form.parents('.div-form').find('h1,h2,h3,h4');
		if (title.length && button_val) {
			title.text(button_val);
		} else {
			title.text('Отправить заявку');
		}
		var mark_el = form.find('input[name="mark"]');
		if (mark_el.length) {
			mark_el.remove();
		}
		$('<input />', {
			'type': 'hidden',
			'name': 'mark',
			'value': mark,
			appendTo: form
		});
	});
});

$(function () {

	$.fancybox.defaults.afterClose = function() {
		var form = this.$content.find('form');
		form.siblings('.w-form-fail').hide();
		form.siblings('.w-form-done').hide();
		form.trigger("reset");
	};

	//$.fancybox.defaults.btnTpl.smallBtn =
	//	'<a href="javascript:$.fancybox.close();" class="close-btn">x</a>';

	// обрабатываются только формы с атрибутом data-ajax
	$('form[data-ajax]').submit(function(e) {

		var delay = 4000; // задержка исчезновения лайтбокса в миллисекундах (0 - не скрывать)
		var wait_msg = 'Отправка...'; // сообщение об отправке (оставить пустым чтоб не показывать)
		var redirect = ''; // страница, на котороую перейти после отправки (оставить пустым чтоб никуда не переходить)
		var action = '/feedback'; // путь к скрипту отправки почты по умолчанию

		e.preventDefault();
		var form = $(this);

		// лайтбокс форма
		var form_lightbox = form.filter('[data-lightbox]').length;

		var cur_redirect = form.attr('data-redirect');
		if (cur_redirect) {
			redirect = cur_redirect;
		}

		var cur_action = form.attr('action');
		if (cur_action && cur_action !== '/') {
			action = cur_action;
		}

		var submit_div = form.find('[type="submit"]');
		if (submit_div.hasClass('btn-disabled')) {
			// if form in process - exiting
			return;
		}
		submit_div.addClass('btn-disabled');

		var submit_txt = submit_div.attr('value');
		if (wait_msg !== '') {
			submit_div.attr('value', wait_msg);
		}

		var formData = new FormData(form[0]);
		var param = $('meta[name=csrf-param]').attr("content");
		var token = $('meta[name=csrf-token]').attr("content");
		if (param && token) {
			formData.set(param, token);
		}
		$.ajax({
			url: action,
			type: 'POST',
			dataType: 'json',
			processData: false,
			contentType: false,
			data: formData
		}).done(function(result) {
			submit_div.attr('value', submit_txt);
			submit_div.removeClass('btn-disabled');

			var success = result && result.success;

			if (success) {
				if (!redirect) {
					form.siblings('.w-form-fail').hide();
					form.siblings('.w-form-done').show();
					if (form_lightbox) {
						setTimeout(function () {
							$.fancybox.close();
						}, delay);
					} else {
						form.hide();
					}
				}
				if (typeof callback_submit_form !== 'undefined' && $.isFunction(callback_submit_form)) {
					callback_submit_form(form);
				}
				if (redirect) {
					document.location.href = redirect;
					return (true);
				}
			} else {
				form.siblings('.w-form-fail').show();
				if (form_lightbox) {
					setTimeout(function () {
						form.siblings('.w-form-fail').hide();
					}, delay);
				}
			}

			// reset ReCaptcha
			if (typeof(grecaptcha) !== 'undefined') {
				grecaptcha.reset();
			}
		});
	});
});

function callback_submit_form(form) {
	var mark_el = $(form).find('input[name="mark"]');
	if (mark_el.length) {
		var mark = mark_el.val();
		if (mark) {
			//yaCounter100500.reachGoal(mark);
			//ga('send', 'event', 'callbackform', 'submit');
		}
	}
}

$(function () {
	// формы в несколько шагов
	$('[data-form-step]').hide();
	$('[data-form-step]:first-child').show();
	$('[data-form-next]').click(function (e) {
		e.preventDefault();
		var step = $(this).parents('[data-form-step]');
		var step_list = step.parents('[data-form-steps]').find('[data-form-step]');
		var step_count = step_list.length;
		var current_step = step.attr('data-form-step');
		if (current_step < step_count) {
			step_list.hide();
			step.next().show();
		}
	});
	$('[data-form-prev]').click(function (e) {
		e.preventDefault();
		var step = $(this).parents('[data-form-step]');
		var step_list = step.parents('[data-form-steps]').find('[data-form-step]');
		var current_step = step.attr('data-form-step');
		if (current_step > 1) {
			step_list.hide();
			step.prev().show();
		}
	});
});