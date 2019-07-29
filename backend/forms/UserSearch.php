<?php
namespace backend\forms;

use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
	        [['id'], 'integer'],
	        [['email', 'name'], 'string'],
	        [['status'], 'integer'],
	        [['is_admin'], 'boolean'],
        ];
    }

	/**
	 * @inheritdoc
	 */
	public function scenarios()
	{
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
		$query = static::find();

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'sort' => [
				'defaultOrder' => [
					'id' => SORT_DESC,
				],
				'attributes' => [
					'id',
					'email',
					'name',
					'status',
					'created_at',
					'updated_at',
					'online_at',
					'is_admin',
				],
			],
		]);

		$this->load($params);

		if (!$this->validate()) {
			return $dataProvider;
		}

		$query->andFilterWhere([
			'id' => $this->id,
			'status' => $this->status,
			'is_admin' => $this->is_admin,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'email', $this->email]);

		return $dataProvider;
	}
}
