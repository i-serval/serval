<?php

namespace backend\models\serval\carousel\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\serval\carousel\CarouselRecord;
use common\models\serval\helper\DateTimeHelper;

class CarouselByItemSearch extends CarouselRecord
{

    public $carousel_item_id;

    public function rules()
    {
        return [
            ['id', 'integer'],
            [['title', 'description'], 'string', 'max' => 150],
            [['is_active'], 'in', 'range' => ['no', 'yes']],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {

        $query = CarouselRecord::find()
            ->addSelect('carousel.*, counter.carousel_items_count AS carousel_items_count')
            ->innerJoin('carousel_carousel_item', 'carousel.id = carousel_carousel_item.carousel_id AND carousel_carousel_item.carousel_item_id = :carousel_item_id',
                [':carousel_item_id' => $this->carousel_item_id])
            ->innerJoin('( SELECT `carousel`.`id`, COUNT(`carousel_carousel_item`.`carousel_id`) AS carousel_items_count	
                FROM `carousel` 
                INNER JOIN `carousel_carousel_item` ON `carousel`.`id` = `carousel_carousel_item`.`carousel_id`
                GROUP BY `carousel`.`id`) AS counter ',
                'carousel.id = counter.id')
            ->groupBy('carousel.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'carousel.id' => $this->id,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'carousel.title', $this->title])
            ->andFilterWhere(['like', 'carousel.description', $this->description]);

        // custom sorting
        $dataProvider->sort->attributes['carousel_items_count'] = [
            'asc' => ['carousel_items_count' => SORT_ASC],
            'desc' => ['carousel_items_count' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['id' => SORT_ASC];

        return $dataProvider;

    }

}
