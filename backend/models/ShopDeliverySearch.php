<?php

namespace backend\models;

use common\models\ShopDeliveryLang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopDelivery;

/**
 * ShopDeliverySearch represents the model behind the search form of `common\models\ShopDelivery`.
 */
class ShopDeliverySearch extends ShopDelivery
{
	public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['name'], 'safe'],
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
        $query = ShopDelivery::find()->joinWith(['langsRef'])->groupBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        'order' => SORT_ASC,
		        ],
		        'attributes' => [
			        'id',
			        'name' => [
				        'asc' => [ShopDeliveryLang::tableName() . '.name' => SORT_ASC],
				        'desc' => [ShopDeliveryLang::tableName() . '.name' => SORT_DESC],
			        ],
			        'order',
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
	        ShopDelivery::tableName() . '.id' => $this->id,
	        ShopDelivery::tableName() . '.order' => $this->order,
        ]);

	    $query->andFilterWhere(['like', ShopDeliveryLang::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
