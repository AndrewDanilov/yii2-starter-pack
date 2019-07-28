<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_shop_relation".
 *
 * @property int $id
 * @property string $key
 * @property string $name
 */
class ShopRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_shop_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'name'], 'required'],
            [['key', 'name'], 'string', 'max' => 255],
            [['key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'name' => 'Название',
        ];
    }

    //////////////////////////////////////////////////////////////////

    public static function getShopRelationByKey($key)
    {
    	return static::findOne(['key' => $key]);
    }
}
