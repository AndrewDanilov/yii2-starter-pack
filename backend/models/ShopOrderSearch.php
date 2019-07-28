<?php

namespace backend\models;

use common\models\Account;
use common\models\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopOrder;

/**
 * ShopOrderSearch represents the model behind the search form of `common\models\ShopOrder`.
 *
 * @method getISODate($attribute)
 * @method getDisplayDate($attribute)
 */
class ShopOrderSearch extends ShopOrder
{
	public $account_info;
	public $addressee;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'account_id', 'pay_id', 'delivery_id'], 'integer'],
            [['created_at', 'addressee', 'status', 'account_info'], 'safe'],
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
        $query = ShopOrder::find()->joinWith(['account.userRel', 'pay.langsRef', 'delivery.langsRef'])->groupBy(ShopOrder::tableName() . '.id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        'id' => SORT_DESC,
		        ],
		        'attributes' => [
			        'id',
			        'created_at',
			        'account_info' => [
				        'asc' => [Account::tableName() . '.name' => SORT_ASC],
				        'desc' => [Account::tableName() . '.name' => SORT_DESC],
			        ],
			        'addressee' => [
				        'asc' => [Account::tableName() . '.addressee_name' => SORT_ASC],
				        'desc' => [Account::tableName() . '.addressee_name' => SORT_DESC],
			        ],
			        'pay_id',
			        'delivery_id',
			        'status',
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
            ShopOrder::tableName() . '.id' => $this->id,
            ShopOrder::tableName() . '.account_id' => $this->account_id,
            ShopOrder::tableName() . '.pay_id' => $this->pay_id,
            ShopOrder::tableName() . '.delivery_id' => $this->delivery_id,
            ShopOrder::tableName() . '.status' => $this->status,
        ]);

        $query->andFilterWhere(['between', ShopOrder::tableName() . '.created_at', $this->getISODate('created_at'), $this->getISODate('created_at') . ' 23:59:59']);

        $query->andFilterWhere(['or',
	        ['like', ShopOrder::tableName() . '.addressee_name', $this->addressee],
	        ['like', ShopOrder::tableName() . '.addressee_email', $this->addressee],
	        ['like', ShopOrder::tableName() . '.addressee_phone', $this->addressee],
        ]);

        $query->andFilterWhere(['or',
	        ['like', Account::tableName() . '.name', $this->account_info],
	        ['like', User::tableName() . '.email', $this->account_info],
        ]);

        return $dataProvider;
    }
}
