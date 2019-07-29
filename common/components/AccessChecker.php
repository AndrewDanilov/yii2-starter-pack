<?php
namespace common\components;

use common\models\User;
use yii\rbac\CheckAccessInterface;

class AccessChecker implements CheckAccessInterface
{
	/**
	 * @param int|string $userId
	 * @param string $permissionName
	 * @param array $params
	 * @return bool|void
	 */
	public function checkAccess($userId, $permissionName, $params = [])
	{
		if ($permissionName === 'admin') {
			return User::find()->where([
					'id' => $userId,
					'is_admin' => true,
					'status' => User::STATUS_ACTIVE,
				])->exists();
		}
		return false;
	}
}