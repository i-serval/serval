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
        <h1><?=$this->title?></h1>
    </div>

    <p>
        <?= Html::a('Edit', ['update', 'id' => $carousel->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $carousel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        &nbsp;
        <?= Html::a('Go to List', ['/carousel'], [ 'class' => 'btn btn-info' ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $carousel,
        'attributes' => [
            'id',
            'title',
            'description',
            'order',
            [
                'label' => 'Image',
                'value' => function( $carousel ) {

                    if ( ! is_object( $carousel->image ) ) {
                        return '';
                    }

                    return Html::img( $carousel->image->getFileUrl(), ['width' => '400px', 'height' => 'auto' ]);
                },
                'format' => 'html',
            ]
        ],
    ]) ?>

</div>
