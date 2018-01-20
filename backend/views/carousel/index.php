<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CarouselSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carousels';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-index">

    <div class="page-title-wrapper">
        <h1><?=$this->title?></h1>
    </div>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?=Html::a('Create Carousel', ['create'], ['class' => 'btn btn-success']) . '   ' ?>
        <?=Html::tag('a', Html::encode('Open in frontend'), [ 'href' => Yii::$app->params['frontendDomain'], 'target' => '_blank', 'class' => 'btn btn-info' ] ); ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => [ 'class'=>'number-col' ],
            ],

            [
                'attribute' => 'id',
                'contentOptions' => [ 'class'=>'col-4-chars' ],
            ],
            'title',
            'description',
            [
                'attribute' => 'order',
                'contentOptions' => [ 'class'=>'col-3-chars' ],
            ],
            [
                'attribute' => 'image',
                'value' => function( $carousel_item ) {

                    if ( ! is_object( $carousel_item->image ) ) {
                        return '';
                    }
                    return Html::img( $carousel_item->image->getImageUrl(), ['width' => '150px', 'height' => 'auto' ]);
                },
                'format' => 'html',
                'contentOptions' => [ 'class'=>'col-150px-chars' ],

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Action',
                'headerOptions' => [ 'class' => 'action-3-items' ],
            ],
        ],
    ]); ?>
</div>
