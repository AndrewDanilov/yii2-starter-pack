/**
 * Корзина
 */

var cartOptions = {
	// ID товара. Необходимо размещать на элементе, оборачивающем кнопки
	// инкремента/декремента, поле ввода количества, а также кнопки
	// добавления/удаления товара в корзину. Если необходимости в дополнительных полях нет,
	// то ID размещается непосредственно на кнопке добавления в корзину - в таком случае
	// добавляться будет только один товар.
	product_id_attr: 'data-cart-product-id',
	// Поле для ввода количества добавляемого в корзину товара, а также
	// поле количество позиций данного товара в списке корзины.
	product_count_attr: 'data-cart-product-count',
	// Кнопка инкремента количества товара в карточке товара
	// либо позиций товара в списке корзины
	product_inc_attr: 'data-cart-product-inc',
	// Кнопка декремента количества товара в карточке товара
	// либо позиций товара в списке корзины
	product_dec_attr: 'data-cart-product-dec',
	// Опция товара. Пустой аттрибут можно располагать на select, checkbox, radio
	// в карточке товара. Атрибут со значением ID опции товара можно размещать
	// на любом дочернем элементе обертки позиции товара в корзине.
	product_option_attr: 'data-cart-product-option',
	// Если селектор не поддерживает извлечение значения методом .val(), то на
	// его опции необходимо навесить option_id_attr, содежржащий ID данного элемента,
	// и option_selected_attr в случае если этот элемент выбран. Атрибут option_value_attr
	// размещается на элементе, который будет отражать значение выбранной опции.
	option_id_attr: 'data-id',
	option_value_attr: 'data-value',
	option_selected_attr: 'data-selected',
	// Наценка на опцию. Размещается на элементах содержащих значения возможных опций.
	// Для <select> это элементы <option>
	option_margin_attr: 'data-cart-product-option-margin',
	// Атрибут для цены товара. Значение атрибута отражает исходную цену товара.
	// Цена с учетом опций будет отражена в тексте элемента, содержащего этот атрибут.
	product_price_attr: 'data-product-price',

	// Уникальный ключ позиции товара в корзине. Аттрибут нужно располагать на обертке
	// позиции товара в корзине уже имеющей атрибут product_id_attr (см. выше)
	item_key: 'data-cart-item-key',

	// Обертка списка товаров в корзине
	list_attr: 'data-cart-list',
	// Элемент, который необходимо прятать, если корзина пустая
	hide_on_empty_attr: 'data-cart-hide-on-empty',
	// Элемент, который необходимо прятать, если корзина полная
	hide_on_full_attr: 'data-cart-hide-on-full',

	// Кнопка добавления товара в корзину
	add_attr: 'data-cart-add',
	// Кнопка удаления товара из корзины
	remove_attr: 'data-cart-remove',
	// Кнопка удаления всех позиций данного товара из корзины
	remove_all_attr: 'data-cart-remove-all',

	// Элемент, содержащий значение общего количества товаров в корзине
	total_count_attr: 'data-cart-total-count',
	// Элемент, содержащий значение суммарной стоимости товаров в корзине
	total_summ_attr: 'data-cart-total-summ',

	// Атрибут, указываемый у переключателей (checkbox, radio), управляющих
	// показом/скрытием полей ввода информации о юридическом лице. Если
	// переключатель включает видимость, необходимо указать значение этого
	// атрибута равное "1", если выключает - то "0"
	legal_trigger: 'data-field-legal',
	// Атрибут, который необходимо указать у полей (либо обертки полей) для
	// ввода информации о юридическом лице.
	legal_fields: 'data-fields-legal',

	default_lang: 'ru',
	// язык, добавляемый к url
	lang_url: '/ru',
	// URL обрабатывающий добавление товара в корзину
	add_url: '/cart-add',
	// URL обрабатывающий удаление товара из корзины
	remove_url: '/cart-remove',

	// форма заказа
	make_order_form_attr: 'data-cart-order-form',
	// кнопка отправки формы заказа
	make_order_button_attr: 'data-cart-order-button'
};

$(function () {

	var lang = $('html').attr('lang');
	if (lang && lang !== cartOptions.default_lang) {
		cartOptions.lang_url = '/' + lang;
	} else {
		cartOptions.lang_url = '';
	}

	/**
	 * Функции корзины
	 */

	function addToCart(product_id, product_option_ids, count, callback) {
		if (typeof count === 'undefined' || count <= 0) {
			count = 1;
		}

		var csrf_data = {};
		var param = $('meta[name=csrf-param]').attr("content");
		var token = $('meta[name=csrf-token]').attr("content");
		if (param && token) {
			csrf_data[param] = token;
		}

		var url = cartOptions.lang_url + cartOptions.add_url + '?id=' + product_id + '&count=' + count;
		if (product_option_ids.length) {
			url += '&product_option_ids=' + product_option_ids.join(',');
		}
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: csrf_data
		}).done(function (data) {
			if (data !== null && data.success) {
				var summ = number_format(data['cart']['summ'], '2', '.', ' ');
				$('[' + cartOptions.total_count_attr + ']').text(data['cart']['count']);
				$('[' + cartOptions.total_summ_attr + ']').text(summ);
				$('[' + cartOptions.hide_on_empty_attr + ']').show();
				$('[' + cartOptions.hide_on_full_attr + ']').hide();
				if (typeof callback !== 'undefined') {
					callback(data['cart']);
				}
			}
		});
	}

	function removeFromCart(product_id, product_option_ids, count, callback) {
		if (typeof count === 'undefined' || count <= 0) {
			count = 1;
		}

		var csrf_data = {};
		var param = $('meta[name=csrf-param]').attr("content");
		var token = $('meta[name=csrf-token]').attr("content");
		if (param && token) {
			csrf_data[param] = token;
		}

		var url = cartOptions.lang_url + cartOptions.remove_url + '?id=' + product_id + '&count=' + count;
		if (product_option_ids.length) {
			url += '&product_option_ids=' + product_option_ids.join(',');
		}
		$.ajax({
			url: url,
			type: 'post',
			dataType: 'json',
			data: csrf_data
		}).done(function (data) {
			if (data !== null && data.success) {
				var summ = number_format(data['cart']['summ'], '2', '.', ' ');
				$('[' + cartOptions.total_count_attr + ']').text(data['cart']['count']);
				$('[' + cartOptions.total_summ_attr + ']').text(summ);
				if (data['cart']['items'].length === 0) {
					$('[' + cartOptions.hide_on_empty_attr + ']').hide();
					$('[' + cartOptions.hide_on_full_attr + ']').show();
				}
				if (typeof callback !== 'undefined') {
					callback(data['cart']);
				}
			}
		});
	}

	function number_format(number, decimals, dec_point, thousands_sep) {
		var i, j, kw, kd, km;
		// input sanitation & defaults
		if( isNaN(decimals = Math.abs(decimals)) ){
			decimals = 2;
		}
		if( dec_point === undefined ){
			dec_point = ",";
		}
		if( thousands_sep === undefined ){
			thousands_sep = ".";
		}
		i = parseInt(number = (+number || 0).toFixed(decimals)) + "";
		if( (j = i.length) > 3 ){
			j = j % 3;
		} else{
			j = 0;
		}
		km = (j ? i.substr(0, j) + thousands_sep : "");
		kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
		kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
		if (kd === '.00') {
			kd = '';
		}
		return km + kw + kd;
	}

	/**
	 * События корзины
	 */

	// добавить/удалить товар в корзину
	$('[' + cartOptions.add_attr + '], [' + cartOptions.remove_attr + ']').click(function (e) {
		e.preventDefault();

		var button = $(this);
		var product_id;
		var count;
		var callback;
		var product_option_ids = [];

		var cart_list = button.parents('[' + cartOptions.list_attr + ']');
		if (cart_list.length) {
			// если действие в списке корзины
			var cart_item = button.parents('[' + cartOptions.product_id_attr + ']');
			var cart_item_key = cart_item.attr(cartOptions.item_key);
			product_id = cart_item.attr(cartOptions.product_id_attr);
			count = 1;
			// извлекаем опции
			cart_item.find('[' + cartOptions.product_option_attr + ']').each(function () {
				product_option_ids.push($(this).attr(cartOptions.product_option_attr));
			});
			// колбэк
			callback = function (cart) {
				if (typeof cart['items'][cart_item_key] !== 'undefined') {
					var result_count = cart['items'][cart_item_key]['count'];
					cart_item.find('[' + cartOptions.product_count_attr + ']').text(String(result_count).padStart(2, '0'));
				} else {
					cart_item.remove();
				}
			}
		} else {
			// если действие в карточке товара или списке товаров
			product_id = button.attr(cartOptions.product_id_attr);
			if (product_id) {
				// атрибут ID непосредственно на кнопке
				count = 1;
			} else {
				// атрибут ID на обертке товара
				var product_wrapper = button.parents('[' + cartOptions.product_id_attr + ']');
				product_id = product_wrapper.attr(cartOptions.product_id_attr);
				count = product_wrapper.find('[' + cartOptions.product_count_attr + ']').text();
				// извлекаем опции
				var product_options = product_wrapper.find('[' + cartOptions.product_option_attr + ']');
				// из стандартных элементов выбора
				product_options.filter('select, input[type=radio]:checked, input[type=checkbox]:checked').each(function () {
					product_option_ids.push($(this).val());
				});
				// из нестандартных элементов выбора
				product_options.filter('div').each(function () {
					var sel = $(this).find('[' + cartOptions.option_selected_attr + ']');
					product_option_ids.push(sel.attr(cartOptions.option_id_attr));
				});
			}
			// колбэк
			callback = function () {
				alert('Товар добавлен в корзину');
			}
		}

		if (button[0].hasAttribute(cartOptions.add_attr)) {
			addToCart(product_id, product_option_ids, parseInt(count), callback);
		} else {
			removeFromCart(product_id, product_option_ids, parseInt(count), callback);
		}
	});

	// удалить все позиции данного товара из корзины
	$('[' + cartOptions.remove_all_attr + ']').click(function (e) {
		e.preventDefault();
		var button = $(this);
		var cart_item = button.parents('[' + cartOptions.product_id_attr + ']');
		var product_id = cart_item.attr(cartOptions.product_id_attr);
		var count = cart_item.find('[' + cartOptions.product_count_attr + ']').text();

		// извлекаем опции
		var product_option_ids = [];
		cart_item.find('[' + cartOptions.product_option_attr + ']').each(function () {
			product_option_ids.push($(this).attr(cartOptions.product_option_attr));
		});

		removeFromCart(product_id, product_option_ids, parseInt(count), function () {
			cart_item.remove();
		});
	});

	// инкремент/декремент товара в счетчике без добавления/удаления в корзину
	$('[' + cartOptions.product_inc_attr + '], [' + cartOptions.product_dec_attr + ']').click(function (e) {
		e.preventDefault();
		var button = $(this);
		var product_wrapper = button.parents('[' + cartOptions.product_id_attr + ']');
		var count = product_wrapper.find('[' + cartOptions.product_count_attr + ']').text();

		if (button[0].hasAttribute(cartOptions.product_inc_attr)) {
			count++;
		} else {
			count--;
			if (count <= 0) {
				count = 1
			}
		}
		product_wrapper.find('[' + cartOptions.product_count_attr + ']').text(String(count).padStart(2, '0'));
	});

	// выбор опций в карточке товара
	$('div[' + cartOptions.product_option_attr + '] [' + cartOptions.option_id_attr + ']').click(function (e) {
		e.preventDefault();
		var option_item = $(this);
		var option = option_item.parents('[' + cartOptions.product_option_attr + ']');
		var margin = option_item.attr(cartOptions.option_margin_attr);
		var product_wrapper = option.parents('[' + cartOptions.product_id_attr + ']');
		var price_el = product_wrapper.find('[' + cartOptions.product_price_attr + ']');
		var price = price_el.attr(cartOptions.product_price_attr);

		price_el.text(number_format(parseFloat(price) + parseFloat(margin), '2', '.', ' '));
		option.find('[' + cartOptions.option_value_attr + ']').text(option_item.text());
		option.triggerHandler('w-close.w-dropdown');
		option_item.parent().children().removeAttr(cartOptions.option_selected_attr);
		option_item.attr(cartOptions.option_selected_attr, '');
	});

	// отправка заполненной формы заказа
	$('[' + cartOptions.make_order_button_attr + ']').click(function (e) {
		e.preventDefault();
		$('[' + cartOptions.make_order_form_attr + ']').submit();
	});

	// показ полей относящихся к юридической информации
	if ($('[' + cartOptions.legal_trigger + '="1"]:checked').length) {
		$('[' + cartOptions.legal_fields + ']').show();
	} else {
		$('[' + cartOptions.legal_fields + ']').hide();
	}
	$('[' + cartOptions.legal_trigger + ']').change(function () {
		if ($(this).prop('checked')) {
			if ($(this).attr('data-field-legal') === '1') {
				$('[' + cartOptions.legal_fields + ']').show();
			} else {
				$('[' + cartOptions.legal_fields + ']').hide();
			}
		}
	});
});