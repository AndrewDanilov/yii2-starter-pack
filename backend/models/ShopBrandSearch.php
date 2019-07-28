<?php

namespace backend\models;

use common\models\ShopBrandLang;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopBrand;

/**
 * ShopBrandSearch represents the model behind the search form of `common\models\ShopBrand`.
 */
class ShopBrandSearch extends ShopBrand
{
	public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['image', 'is_favorite', 'name'], 'safe'],
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
        $query = ShopBrand::find()->joinWith(['langsRef'])->groupBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        'order' => SORT_ASC,
		        ],
		        'attributes' => [
			        'id',
			        'image',
			        'name' => [
				        'asc' => [ShopBrandLang::tableName() . '.name' => SORT_ASC],
				        'desc' => [ShopBrandLang::tableName() . '.name' => SORT_DESC],
			        ],
			        'is_favorite',
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
	        ShopBrand::tableName() . '.id' => $this->id,
	        ShopBrand::tableName() . '.order' => $this->order,
        ]);

        $query->andFilterWhere(['like', ShopBrand::tableName() . '.image', $this->image])
            ->andFilterWhere(['like', ShopBrand::tableName() . '.is_favorite', $this->is_favorite])
	        ->andFilterWhere(['like', ShopBrandLang::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
