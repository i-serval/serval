<?php

namespace common\models\serval\carousel;

use Yii;
use yii\base\Model;
use common\models\serval\carousel\CarouselImage;


class Carousel extends Model
{
    public $id;
    public $title;
    public $description;
    public $order;
    public $image;

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

        $this->image = new CarouselImage();

        return $this;

    }

    public function loadByID( $id ) {

        $query_cmd = Yii::$app->db->createCommand("SELECT * FROM carousel WHERE id=:id ")->bindValue(':id', $id);
        $result = $query_cmd->queryOne();

        $this->id = $result['id'];
        $this->title = $result['title'];
        $this->description = $result['description'];
        $this->order = $result['order'];
        $this->image =  $this->image->loadByID( $result['image']);

        return $this;

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

        if ($this->validate() && $this->image->save()) {

            Yii::$app->db->createCommand("INSERT INTO carousel ( `title`, `description`, `order`, `image` ) VALUES ( :title, :description, :order, :image )")
                ->bindValue(':title', $this->title)
                ->bindValue(':description', $this->description)
                ->bindValue(':order', $this->order)
                ->bindValue(':image', $this->image->getId())
                ->execute();

            $this->id = Yii::$app->db->getLastInsertID();

            return true;

        }


        return false;

    }

    protected function update()
    {

        if ($this->validate() && $this->image->save()) {

            Yii::$app->db->createCommand("UPDATE carousel SET `title`=:title, `description`=:description, `order`=:order, `image`=:image  WHERE id=:id")
                ->bindValue(':id', $this->id)
                ->bindValue(':title', $this->title)
                ->bindValue(':description', $this->description)
                ->bindValue(':order', $this->order)
                ->bindValue(':image', $this->image->getId())
                ->execute();

            return true;

        }

        return false;

    }

    public function delete()
    {

        Yii::$app->db->createCommand("DELETE FROM carousel WHERE id=:id ")->bindValue(':id', $this->id )->execute();

        $this->image->delete();

        $this->id = null;
        $this->title = null;
        $this->description = null;
        $this->order = null;
        $this->image = null;

    }

    public function load($data, $formName = null)
    {

        if ($this->image->load($data, $formName)) {

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
            'image' => 'Image',
        ];
    }
}
