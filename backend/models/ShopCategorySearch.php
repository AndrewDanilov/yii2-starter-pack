<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopCategory;
use common\models\ShopCategoryLang;

/**
 * ShopCategorySearch represents the model behind the search form of `common\models\ShopCategory`.
 */
class ShopCategorySearch extends ShopCategory
{
	public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'order'], 'integer'],
            [['image', 'name'], 'safe'],
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
        $query = ShopCategory::find()->joinWith(['langsRef'])->groupBy('id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	        'sort' => [
		        'defaultOrder' => [
			        'parent_id' => SORT_ASC,
			        'id' => SORT_ASC,
		        ],
		        'attributes' => [
			        'id',
			        'parent_id',
			        'image',
			        'name' => [
				        'asc' => [ShopCategoryLang::tableName() . '.name' => SORT_ASC],
				        'desc' => [ShopCategoryLang::tableName() . '.name' => SORT_DESC],
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
	        ShopCategory::tableName() . '.id' => $this->id,
	        ShopCategory::tableName() . '.order' => $this->order,
	        ShopCategory::tableName() . '.parent_id' => $this->parent_id,
        ]);

        $query->andFilterWhere(['like', ShopCategory::tableName() . '.image', $this->image])
            ->andFilterWhere(['like', ShopCategoryLang::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
