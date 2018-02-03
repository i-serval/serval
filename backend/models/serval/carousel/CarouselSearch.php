<?php

namespace backend\models\serval\carousel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\serval\carousel\CarouselRecord;
use common\models\serval\helper\DateTimeHelper;

class CarouselSearch extends CarouselRecord
{

    public function rules()
    {
        return [
            ['id', 'integer'],
            //[['created_at', 'updated_at'], 'datetime', 'format' => Yii::$app->formatter->datetimeFormat],
            //[['created_at', 'updated_at', 'last_activation_at'],  'safe'],
            //[['activate_at'], 'datetime', 'format' => DateTimeHelper::modifyFormat(Yii::$app->formatter->datetimeFormat, [':s' => ''])],  // validate date&time without seconds,
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
            ->joinWith('carousel_items')
            ->addSelect('carousel.*, COUNT(carousel_id) AS carousel_items_count')
            ->groupBy('carousel.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            /*'created_at' => DateTimeHelper::convertToUTC($this->created_at),
            'updated_at' => DateTimeHelper::convertToUTC($this->updated_at),
            'activate_at' => $this->activate_at,*/
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        // custom sorting
        $dataProvider->sort->attributes['carousel_items_count'] = [
            'asc' => ['carousel_items_count' => SORT_ASC],
            'desc' => ['carousel_items_count' => SORT_DESC],
        ];

        $dataProvider->sort->defaultOrder = ['id' => SORT_ASC];

        return $dataProvider;

    }

}
