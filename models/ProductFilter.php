<?php

namespace app\models;

use app\components\BaseActiveRecord;
use yii;
use yii\data\ActiveDataProvider;

class ProductFilter extends Product
{
   public function rules()
    {
        return [
            [['title'], 'string', 'max' => 155],

            [['article'], 'string', 'max' => 50],

            [['catalog_number'], 'string', 'max' => 50],

            [['price_dealer'], 'double'],

            [['delivery'], 'integer', 'min' => 1],

            [['stock'], 'integer', 'min' => 0],

            [['description'], 'string'],

            [['brand_id'], 'integer'],

            [['group_id'], 'integer'],
        ];
    }

    public function search($params = [])
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['price_dealer' => $this->price_dealer]);
        $query->andFilterWhere(['brand_id' => $this->brand_id]);
        $query->andFilterWhere(['group_id' => $this->group_id]);
        $query->andFilterWhere(['delivery' => $this->delivery]);
        $query->andFilterWhere(['stock' => $this->stock]);

        return $dataProvider;
    }
}
