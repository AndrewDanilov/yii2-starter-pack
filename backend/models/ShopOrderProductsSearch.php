<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopOrderProducts;
use common\models\ShopProduct;

/**
 * ShopOrderProductsSearch represents the model behind the search form of `common\models\ShopOrderProducts`.
 */
class ShopOrderProductsSearch extends ShopOrderProducts
{
	public $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order_id', 'product_id', 'count'], 'integer'],
            [['name', 'image'], 'safe'],
            [['price'], 'number'],
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
        $query = ShopOrderProducts::find()->joinWith(['product']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
	        	'attributes' => [
	        		'product_id',
			        'image' => [
				        'asc' => [ShopProduct::tableName() . '.image' => SORT_ASC],
				        'desc' => [ShopProduct::tableName() . '.image' => SORT_DESC],
			        ],
			        'name',
			        'price',
			        'count',
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
            ShopOrderProducts::tableName() . '.id' => $this->id,
	        ShopOrderProducts::tableName() . '.order_id' => $this->order_id,
	        ShopOrderProducts::tableName() . '.product_id' => $this->product_id,
	        ShopOrderProducts::tableName() . '.price' => $this->price,
	        ShopOrderProducts::tableName() . '.count' => $this->count,
        ]);

        $query->andFilterWhere(['like', ShopOrderProducts::tableName() . '.name', $this->name])
	        ->andFilterWhere(['like', ShopProduct::tableName() . '.image', $this->image]);

        return $dataProvider;
    }
}
