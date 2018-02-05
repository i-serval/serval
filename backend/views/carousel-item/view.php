<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = Yii::t('carousel', 'Slide View' );
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slides List' ), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-view">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <p>
        <?= Html::a('Edit', ['update', 'id' => $carousel_item->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $carousel_item->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $carousel_item,
        'options' => [
            'class' => 'table table-striped table-bordered detail-view',
            'style' => 'width:500px;',
        ],

        'attributes' => [
            [
                'attribute' => 'id',
                'captionOptions' => ['style' => 'width:100px;'],
            ],
            'title',
            'description',
            [
                'label' => 'Image',
                'value' => function ($carousel) {

                    if (!is_object($carousel->image)) {
                        return '';
                    }

                    return Html::img($carousel->image->getFileUrl(), ['width' => '400px', 'height' => 'auto']);
                },
                'format' => 'html',
            ]
        ],
    ]) ?>

</div>
