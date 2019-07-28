<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopProductOptions;

/**
 * ShopProductOptionsSearch represents the model behind the search form of `common\models\ShopProductOptions`.
 */
class ShopProductOptionsSearch extends ShopProductOptions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'option_id', 'product_id'], 'integer'],
            [['margin'], 'number'],
            [['margin_type'], 'safe'],
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
        $query = ShopProductOptions::find();

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
            'product_id' => $this->product_id,
            'margin' => $this->margin,
        ]);

        $query->andFilterWhere(['like', 'margin_type', $this->margin_type]);

        return $dataProvider;
    }
}
