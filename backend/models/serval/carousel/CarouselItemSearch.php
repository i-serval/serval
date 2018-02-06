<?php

namespace backend\models\serval\carousel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\serval\carousel\CarouselItemRecord;

class CarouselItemSearch extends CarouselItemRecord
{

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['title', 'description'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CarouselItemRecord::find()
            ->leftJoin('carousel_carousel_item', 'carousel_item.id = carousel_carousel_item.carousel_item_id')
            ->addSelect('carousel_item.*, COUNT(carousel_carousel_item.carousel_item_id) AS use_count')
            ->groupBy('carousel_item.id');

        $query->joinWith('image');

        $data_provider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $data_provider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'carousel_item.id' => $this->id,

        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $data_provider;
    }
}
