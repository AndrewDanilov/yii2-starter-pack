<?php

namespace frontend\helpers;

class Dates
{
	/**
	 * Возвращает дату послезавтра в виде строки '3 Января'
	 *
	 * @return string
	 */
	public static function dayAfterTommorowStr()
	{
		$date = date('Y-m-d', time() + 2*24*60*60);
		return self::getDay($date) . ' ' . self::getMonth($date);
	}

	/**
	 * Возвращает дату послепослезавтра в виде строки '3 Января'
	 *
	 * @return string
	 */
	public static function dayAfterAfterTommorowStr()
	{
		$date = date('Y-m-d', time() + 3*24*60*60);
		return self::getDay($date) . ' ' . self::getMonth($date);
	}

	/**
	 * Возвращает указанную дату в виде строки 'Сегодня', 'Завтра', '3 Января'
	 *
	 * @param null|string $date - Дата в MySQL формате YYYY-MM-DD
	 * @return string
	 */
	public static function dayStr($date=null)
	{
		$today = date('Y-m-d');
		$tomorrow = date('Y-m-d', time() + 24*60*60);
		if (!$date) {
			$date = $today;
		}
		if ($date == $today) {
			return 'Сегодня';
		} elseif ($date == $tomorrow) {
			return 'Завтра';
		}
		return self::getDay($date) . ' ' . self::getMonth($date);
	}

	/**
	 * Возвращает номер дня переданной даты
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return false|string
	 */
	public static function getDay($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		return date("j", $date);
	}

	/**
	 * Возвращает строковое представление дня недели переданной даты
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getWeek($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		$week = date("N", $date);
		switch ($week) {
			case '1': return 'Понедельник';
			case '2': return 'Вторник';
			case '3': return 'Среда';
			case '4': return 'Четверг';
			case '5': return 'Пятница';
			case '6': return 'Суббота';
			case '7': return 'Воскресенье';
			default: return '';
		}
	}

	/**
	 * Возвращает строковое представление дня недели переданной даты в сокращенном формате
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getWeekShort($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		$week = date("N", $date);
		switch ($week) {
			case '1': return 'ПН';
			case '2': return 'ВТ';
			case '3': return 'СР';
			case '4': return 'ЧТ';
			case '5': return 'ПТ';
			case '6': return 'СБ';
			case '7': return 'ВС';
			default: return '';
		}
	}

	/**
	 * Возвращает строковое представление месяца для составления с числительным
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getMonth($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		$month = date("n", $date);
		switch ($month) {
			case '1': return 'Января';
			case '2': return 'Февраля';
			case '3': return 'Марта';
			case '4': return 'Апреля';
			case '5': return 'Мая';
			case '6': return 'Июня';
			case '7': return 'Июля';
			case '8': return 'Августа';
			case '9': return 'Сентября';
			case '10': return 'Октября';
			case '11': return 'Ноября';
			case '12': return 'Декабря';
			default: return '';
		}
	}

	/**
	 * Возвращает строковую запись месяца и года указанной даты
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getMonthYear($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		$month = date("n", $date);
		switch ($month) {
			case '1': $str = 'Январь'; break;
			case '2': $str = 'Февраль'; break;
			case '3': $str = 'Март'; break;
			case '4': $str = 'Апрель'; break;
			case '5': $str = 'Май'; break;
			case '6': $str = 'Июнь'; break;
			case '7': $str = 'Июль'; break;
			case '8': $str = 'Август'; break;
			case '9': $str = 'Сентябрь'; break;
			case '10': $str = 'Октябрь'; break;
			case '11': $str = 'Ноябрь'; break;
			case '12': $str = 'Декабрь'; break;
			default: $str = '';
		}
		return $str . ', ' . date('Y', $date);
	}

	/**
	 * Возвращает строковую запись месяца и года для следущего от указанной даты месяца.
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getNextMonthYear($date=null)
	{
		$date = self::getNextMonthStart($date);
		return self::getMonthYear($date);
	}

	/**
	 * Возвращает дату начала месяца
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getMonthStart($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		return  date("Y-m-01", $date);
	}

	/**
	 * Возвращает дату начала следующего месяца
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getNextMonthStart($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		$month = date("n", $date);
		$year = date("Y", $date);
		if ($month == 12) {
			$next_month = '01';
			$next_year = $year + 1;
		} else {
			$next_month = str_pad($month + 1, 2, '0', STR_PAD_LEFT);
			$next_year = $year;
		}
		return $next_year . '-' . $next_month . '-01';
	}

	/**
	 * Возвращает дату последнего дня месяца
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getMonthEnd($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		return date("Y-m-t", strtotime($date));
	}

	/**
	 * Возвращает дату последнего дня следующего месяца
	 *
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function getNextMonthEnd($date=null)
	{
		$date = self::getNextMonthStart($date);
		return date("Y-m-t", strtotime($date));
	}

	/**
	 * @param null|string $date - дата в формате, понятном функции strtotime()
	 * @return string
	 */
	public static function isWeekend($date=null)
	{
		if (!$date) {
			$date = time();
		} else {
			$date = strtotime($date);
		}
		if (in_array(date("N", $date), [6, 7])) {
			return true;
		}
		return false;
	}

	public static function getYearBegin()
	{
		return date('Y-01-01');
	}

	public static function getYearEnd()
	{
		return date('Y-12-31');
	}

	public static function getPrevYearBegin()
	{
		return date('Y-01-01', strtotime("-1 year"));
	}

	public static function getPrevYearEnd()
	{
		return date('Y-12-31', strtotime("-1 year"));
	}
}