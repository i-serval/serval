<?php

namespace backend\models\serval\carousel\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\serval\carousel\CarouselItemRecord;

class CarouselItemAttachSearch extends CarouselItemRecord
{

    public $search_carousel_id;
    public $attach_status;

    public function rules()
    {
        return [
            [['id', 'use_count'], 'integer'],
            [['title', 'description', 'attach_status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CarouselItemRecord::find()
            ->addSelect('carousel_item.*, COUNT(carousel_carousel_item.carousel_item_id) AS use_count, cci.carousel_id AS `is_used` ')
            ->leftJoin('carousel_carousel_item', 'carousel_item.id = carousel_carousel_item.carousel_item_id')
            ->leftJoin('carousel_carousel_item AS cci', 'carousel_item.id = cci.carousel_item_id AND cci.carousel_id = :carousel_id ', [':carousel_id' => $this->search_carousel_id])
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
        $query->andFilterWhere(['carousel_item.id' => $this->id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterHaving(['=', 'use_count', $this->use_count]);

        if ($this->attach_status == 'attached') {

            $query->andWhere('cci.carousel_id IS NOT NULL');
            //$query->andFilterWhere(['not', ['cci.carousel_id' => null]]);

        } elseif ($this->attach_status == 'detached') {

            $query->andWhere('cci.carousel_id IS NULL');

        }

        //sorting

        $data_provider->sort->attributes['use_count'] = [
            'asc' => ['use_count' => SORT_ASC],
            'desc' => ['use_count' => SORT_DESC],
        ];

        $data_provider->sort->defaultOrder = ['id' => SORT_ASC];

        return $data_provider;

    }

}
