<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopAttribute;
use common\models\ShopAttributeLang;

/**
 * ShopAttributeSearch represents the model behind the search form of `common\models\ShopAttribute`.
 */
class ShopAttributeSearch extends ShopAttribute
{
	public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order'], 'integer'],
            [['type', 'name'], 'safe'],
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
        $query = ShopAttribute::find()->joinWith(['langsRef', 'tagsRef'])->groupBy('id');

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
				        'asc' => [ShopAttributeLang::tableName() . '.name' => SORT_ASC],
				        'desc' => [ShopAttributeLang::tableName() . '.name' => SORT_DESC],
			        ],
			        'type',
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
            ShopAttribute::tableName() . '.id' => $this->id,
	        ShopAttribute::tableName() . '.order' => $this->order,
	        ShopAttribute::tableName() . '.type' => $this->type,
        ]);

        $query->andFilterWhere(['like', ShopAttributeLang::tableName() . '.name', $this->name]);

        return $dataProvider;
    }
}
