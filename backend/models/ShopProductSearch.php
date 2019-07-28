<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopBrand;
use common\models\ShopProductCategories;
use common\models\ShopProduct;
use common\models\ShopProductLang;

/**
 * ShopProductSearch represents the model behind the search form of `common\models\ShopProduct`.
 */
class ShopProductSearch extends ShopProduct
{
	public $name;
	public $category_id;

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'brand_id', 'category_id', 'is_popular'], 'integer'],
            [['old_price', 'price'], 'number'],
	        [['name', 'article'], 'safe'],
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
        $query = ShopProduct::find()->joinWith(['langsRef', 'brand', 'tagsRef'])->groupBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        'id' => SORT_DESC,
		        ],
		        'attributes' => [
			        'id',
			        'article',
			        'name' => [
				        'asc' => [ShopProductLang::tableName() . '.name' => SORT_ASC],
				        'desc' => [ShopProductLang::tableName() . '.name' => SORT_DESC],
			        ],
			        'old_price',
			        'price',
			        'is_popular',
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
	        ShopProduct::tableName() . '.id' => $this->id,
	        ShopProduct::tableName() . '.brand_id' => $this->brand_id,
	        ShopProduct::tableName() . '.old_price' => $this->old_price,
	        ShopProduct::tableName() . '.price' => $this->price,
	        ShopProduct::tableName() . '.is_popular' => $this->is_popular,
	        ShopProductCategories::tableName() . '.category_id' => $this->category_id,
        ]);

	    $query->andFilterWhere(['like', ShopProduct::tableName() . '.article', $this->article])
		    ->andFilterWhere(['like', ShopProductLang::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
