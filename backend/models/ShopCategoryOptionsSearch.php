<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopCategoryOptions;

/**
 * ShopCategoryOptionsSearch represents the model behind the search form of `common\models\ShopCategoryOptions`.
 */
class ShopCategoryOptionsSearch extends ShopCategoryOptions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'option_id', 'category_id'], 'integer'],
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
        $query = ShopCategoryOptions::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'option_id' => $this->option_id,
            'category_id' => $this->category_id,
        ]);

        return $dataProvider;
    }
}
