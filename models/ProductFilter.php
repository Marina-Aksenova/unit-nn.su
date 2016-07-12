<?php

namespace app\models;

use yii;
use yii\data\ActiveDataProvider;

class ProductFilter extends Product
{
    public $price_from;
    public $price_to;

    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 155],

            [['article'], 'string', 'max' => 50],

            [['catalog_number'], 'string', 'max' => 50],

            [['price_from'], 'formatPrice'],
            [['price_from'], 'double'],

            [['price_to'], 'formatPrice'],
            [['price_to'], 'double'],

            [['delivery'], 'integer', 'min' => 1],

            [['stock'], 'integer', 'min' => 0],

            [['description'], 'string'],

            [['brand_id'], 'integer'],

            [['group_id'], 'integer'],
        ];
    }

    public function formatPrice($attribute)
    {
        $this->$attribute = str_replace([' ', ','], ['', '.'], $this->$attribute);
    }

    public function search($params = [])
    {
        $query = static::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // load the search form data and validate
        if (!$this->load($params)) {
            return $dataProvider;
        }

        $this->formatPrice('price_dealer');

        // adjust the query by adding the filters
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['brand_id' => $this->brand_id]);
        $query->andFilterWhere(['group_id' => $this->group_id]);
        $query->andFilterWhere(['>=', 'delivery', $this->delivery]);
        $query->andFilterWhere(['>=', 'stock', $this->stock]);
        $query->andFilterWhere(['>=', 'price_dealer', $this->price_from]);
        $query->andFilterWhere(['<=', 'price_dealer', $this->price_to]);
        return $dataProvider;
    }
}
