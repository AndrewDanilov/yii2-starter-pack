<?php

namespace frontend\components;

use yii\db\Query;

trait QueryTrait
{
	/**
	 * Вычисляет общее количество записей возвращаемых
	 * последним использованным запросом, если бы к нему
	 * не были применены limit() и offset()
	 *
	 * @param Query $query
	 * @return int
	 */
	public static function queryCount($query)
	{
		$limit = $query->limit;
		$offset = $query->offset;
		$query->limit = null;
		$query->offset = null;

		$count = $query->count();

		$query->limit = $limit;
		$query->offset = $offset;

		return $count;
	}
}