<?php
namespace common\helpers;

class Geo
{
	/**
	 * Возвращает координаты центра карты относительно
	 * всех имеющихся адресов организации.
	 *
	 * @param array $addresses
	 * @param string $notation - нотация в которой нужно вернуть координаты
	 *                           может принимать значения array|comma|space
	 * @return string|array
	 */
	public static function centerCoordinates($addresses, $notation = 'array')
	{
		if (!in_array($notation, ['array', 'comma', 'space'])) {
			$notation = 'array';
		}
		if (!is_array($addresses) || !count($addresses)) {
			$coordinates = null;
		} else {
			$coordinates = $addresses[0]['coordinates'];
		}
		switch ($notation) {
			case 'array':
				return $coordinates === null ? [] : self::coordsToArrayNotation($coordinates);
			case 'comma':
				return $coordinates === null ? '' : self::coordsToCommaNotation($coordinates);
			case 'space':
				return $coordinates === null ? '' : self::coordsToSpaceNotation($coordinates);
		}
		return [];
	}

	/**
	 * Преобразует любую нотацию координат к строке с разделителем запятой
	 * с заменой десятичной запятой в числах на точку
	 *
	 * @param string|array $coordinates
	 * @return string
	 */
	public static function coordsToCommaNotation($coordinates)
	{
		$coordinates = self::coordsToArrayNotation($coordinates);
		if (is_array($coordinates) && !empty($coordinates)) {
			return implode(",", $coordinates);
		}
		return '';
	}

	/**
	 * Преобразует любую нотацию координат к массиву
	 * с заменой десятичной запятой в числах на точку
	 *
	 * @param string|array $coordinates
	 * @return array
	 */
	public static function coordsToArrayNotation($coordinates)
	{
		if (!is_array($coordinates)) {
			$coordinates = preg_replace("/[^\d\.\,\s]+/", "", $coordinates);
			if (preg_match("/^([\d\.]+)[\,\s]+([\d\.]+)$/", $coordinates, $matches)) {
				$coordinates = [$matches[1], $matches[2]];
			} elseif (preg_match("/^([\d\,]+)[\s]+([\d\,]+)$/", $coordinates, $matches)) {
				$coordinates = [$matches[1], $matches[2]];
			} else {
				$coordinates = [];
			}
		} else {
			$coordinates = array_slice($coordinates, 0, 2);
		}
		foreach ($coordinates as &$coordinate) {
			$coordinate = str_replace(",", ".", $coordinate);
		}
		unset($coordinate);
		return $coordinates;
	}

	/**
	 * Преобразует любую нотацию координат к строке с разделителем пробелом
	 * с заменой десятичной запятой в числах на точку
	 *
	 * @param string|array $coordinates
	 * @return string
	 */
	public static function coordsToSpaceNotation($coordinates)
	{
		$coordinates = self::coordsToArrayNotation($coordinates);
		return implode(" ", $coordinates);
	}
}