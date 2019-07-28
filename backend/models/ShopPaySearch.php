<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopPay;
use common\models\ShopPayLang;

/**
 * ShopPaySearch represents the model behind the search form of `common\models\ShopPay`.
 */
class ShopPaySearch extends ShopPay
{
	public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'order', 'is_legal'], 'integer'],
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
        $query = ShopPay::find()->joinWith(['langsRef'])->groupBy('id');

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
				        'asc' => [ShopPayLang::tableName() . '.name' => SORT_ASC],
				        'desc' => [ShopPayLang::tableName() . '.name' => SORT_DESC],
			        ],
			        'is_legal',
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
	        ShopPay::tableName() . '.id' => $this->id,
	        ShopPay::tableName() . '.order' => $this->order,
	        ShopPay::tableName() . '.is_legal' => $this->is_legal,
        ]);

	    $query->andFilterWhere(['like', ShopPayLang::tableName() . '.name', $this->name]);

	    return $dataProvider;
    }
}
