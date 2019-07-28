<?php

namespace common\helpers;

use yii\db\ActiveRecord;
use common\models\ShopCategory;

/**
 * NestedCategoryHelper class
 */
class NestedCategoryHelper
{
	private static $_groupedCategories = null;

	public static function getGroupedCategories()
	{
		if (static::$_groupedCategories === null) {
			$all = ShopCategory::find()->all();
			static::$_groupedCategories = [];
			foreach ($all as $category) {
				static::$_groupedCategories[$category->parent_id][$category->id] = $category;
			}
		}
		return static::$_groupedCategories;
	}

	/**
	 * Возвращает псевдо-иерархический Dropdown-список
	 * для использования в полях форм.
	 *
	 * @param int $parent_id
	 * @param int $level
	 * @return array
	 */
	public static function getDropdownTree($parent_id=0, $level=0) {
		$tree = [];
		$categories = static::getGroupedCategories();
		if (isset($categories[$parent_id])) {
			foreach ($categories[$parent_id] as $id => $category) {
				$tree[$id] = str_repeat('│ ', $level) . '├ ' . $category->lang->name;
				if (isset($categories[$id])) {
					$tree += static::getDropdownTree($id, $level + 1);
				}
			}
		}
		return $tree;
	}

	/**
	 * Возвращает список ID's дочерних категорий любого уровня вложенности
	 *
	 * @param int $parent_id
	 * @return array
	 */
	public static function getChildrenIds($parent_id=0)
	{
		$tree = static::getDropdownTree($parent_id);
		return array_keys($tree);
	}
}