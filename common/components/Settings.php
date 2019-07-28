<?php

namespace common\components;

use common\models\Setting;
use yii\base\Component;

class Settings extends Component
{
	public $_settings = [];

	public function __isset($key)
	{
		if ($this->_settings[$key] === null) {
			return Setting::hasValue($key);
		}
		return true;
	}

	public function __get($key)
	{
		if ($this->_settings[$key] === null) {
			$this->_settings[$key] = Setting::getValue($key);
		}
		return $this->_settings[$key];
	}

	public function is($key, $value)
	{
		return $this->$key == $value;
	}
}