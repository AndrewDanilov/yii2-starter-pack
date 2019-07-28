<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
use common\models\Account;

/**
 * AccountSearch represents the model behind the search form of `common\models\Account`.
 */
class AccountSearch extends Account
{
	public $isAdmin;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['email', 'name', 'phone', 'organization', 'inn', 'isAdmin'], 'safe'],
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
        $query = Account::find()->joinWith(['userRel'])->leftJoin('auth_assignment','auth_assignment.user_id = ' . User::tableName() . '.id AND auth_assignment.item_name = :role_name')->addParams(['role_name' => 'admin']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        'id' => SORT_DESC,
		        ],
		        'attributes' => [
			        'id',
			        'email' => [
				        'asc' => [User::tableName() . '.email' => SORT_ASC],
				        'desc' => [User::tableName() . '.email' => SORT_DESC],
			        ],
			        'name',
			        'phone',
			        'organization',
			        'inn',
			        'status' => [
				        'asc' => [User::tableName() . '.status' => SORT_ASC],
				        'desc' => [User::tableName() . '.status' => SORT_DESC],
			        ],
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
            Account::tableName() . '.id' => $this->id,
	        'status' => $this->status,
        ]);

        if (isset($this->isAdmin) && $this->isAdmin !== '') {
	        if ($this->isAdmin) {
		        $query->andWhere(['not', ['auth_assignment.item_name' => null]]);
	        } else {
		        $query->andWhere(['auth_assignment.item_name' => null]);
	        }
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
		    ->andFilterWhere(['like', 'email', $this->email])
		    ->andFilterWhere(['like', 'organization', $this->organization])
		    ->andFilterWhere(['like', 'inn', $this->inn]);

	    return $dataProvider;
    }
}
