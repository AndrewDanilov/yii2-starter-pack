<?php

namespace backend\models;

use common\models\SettingLang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Setting;
use common\models\SettingCategory;

/**
 * SettingSearch represents the model behind the search form of `common\models\Setting`.
 */
class SettingSearch extends Setting
{
	public $value;

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'category_id'], 'integer'],
			[['key', 'name', 'type', 'value'], 'safe'],
		];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

	/**
	 * Creates data provider instance with search query applied
	 *
	 * @param array $params
	 *
	 * @return ActiveDataProvider
	 */
	public function search($params)
	{
		$query = Setting::find()->joinWith(['langsRef', 'category']);

        // add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					SettingCategory::tableName() . '.order' => SORT_ASC,
					'id' => SORT_ASC,
				],
				'attributes' => [
					'id',
					'category_id' => [
						'asc' => [SettingCategory::tableName() . '.name' => SORT_ASC],
						'desc' => [SettingCategory::tableName() . '.name' => SORT_DESC],
					],
					'key',
					'value',
					'type',
					'name',
					SettingCategory::tableName() . '.order',
				],
			],
		]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

		// grid filtering conditions
		$query->andFilterWhere([
			Setting::tableName() . '.id' => $this->id,
			Setting::tableName() . '.category_id' => $this->category_id,
			Setting::tableName() . '.type' => $this->type,
		]);

		$query->andFilterWhere(['like', Setting::tableName() . '.key', $this->key])
			->andFilterWhere(['like', Setting::tableName() . '.name', $this->name])
			->andFilterWhere(['like', SettingLang::tableName() . '.value', $this->value]);

        return $dataProvider;
    }
}
