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
        $query = CarouselItemRecord::find();

        // add conditions that should always apply here

        //$query->joinWith('image');   minimaze db queries from 16 to 12

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
            'id' => $this->id,

        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $data_provider;
    }
}
