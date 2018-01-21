<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = 'View Carousel Item';
//$this->params['breadcrumbs'][] = ['label' => 'Carousels', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-view">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        &nbsp;
        <?= Html::a('Go to List', ['/carousel'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            'order',
            [
                'label' => 'Image',
                'value' => function ($carousel_item) {

                    if (!is_object($carousel_item->image)) {
                        return '';
                    }

                    return Html::img($carousel_item->image->getImageUrl(), ['width' => '400px', 'height' => 'auto']);
                },
                'format' => 'html',
            ]
        ],
    ]) ?>

</div>
