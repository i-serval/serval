<?php

namespace common\models;

use Yii;
use yii\base\Model;
use common\models\CarouselImage;


class Carousel extends Model
{
    public $id;
    public $title;
    public $description;
    public $order;
    public $image_id;

    public function rules()
    {
        return [
            [['order'], 'number'],
            [['title', 'description'], 'string', 'max' => 255],
            [['title', 'description', 'order'], 'required']
        ];

    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);

        $this->image_id = new CarouselImage();

    }

    public function isNewRecord()
    {

        if ($this->id == null) {
            return true;
        }

        return false;

    }

    public function save()
    {

        if ($this->isNewRecord()) {

            return $this->insert();

        }

        return $this->update();

    }

    protected function insert()
    {

        if ($this->validate() && $this->image_id->save()) {

            Yii::$app->db->createCommand("INSERT INTO carousel ( `title`, `description`, `order` ) VALUES ( :title, :description, :order)")
                ->bindValue(':title', $this->title)
                ->bindValue(':description', $this->description)
                ->bindValue(':order', $this->order)
                ->execute();

            $this->id = Yii::$app->db->getLastInsertID();

            return true;

        }


        return false;

    }

    protected function update()
    {


    }

    public function delete()
    {


    }

    public function loadById()
    {

    }

    public function load($data, $formName = null)
    {

        if ($this->image_id->load($data, $formName)) {

            return parent::load($data, $formName);

        }

        return false;

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'order' => 'Order',
            'image_id' => 'Image ID',
        ];
    }
}
