<?php

namespace backend\models\serval\carousel;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\serval\carousel\CarouselRecord;
use common\models\serval\helper\DateTimeHelper;

/**
 * CarouselSearch represents the model behind the search form of `\common\models\serval\carousel\CarouselRecord`.
 */
class CarouselSearch extends CarouselRecord
{

    public function rules()
    {
        return [
            ['id', 'integer'],
            //[['created_at', 'updated_at'], 'datetime', 'format' => Yii::$app->formatter->datetimeFormat],
            [['created_at', 'updated_at'],  'safe'],
            [['activate_at'], 'datetime', 'format' => DateTimeHelper::modifyFormat(Yii::$app->formatter->datetimeFormat, [':s' => ''])],  // validate date&time without seconds,
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

        $query = CarouselRecord::find();

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

        //var_dump(DateTimeHelper::convertToUTC($this->created_at));
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => DateTimeHelper::convertToUTC($this->created_at),
            'updated_at' => DateTimeHelper::convertToUTC($this->updated_at),
            'activate_at' => $this->activate_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;

    }

}
