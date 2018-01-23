<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('carousel', 'Carousel Records');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="carousel-record-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('carousel', 'Create Carousel'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => [ 'class'=>'col-4-chars' ],
            ],

            [
                'attribute' => 'title',
                'label' => Yii::t('carousel','Name'),
                'contentOptions' => [ 'class'=>'col-550px' ],
            ],

            [
                'attribute' => 'description',
                'label' => Yii::t('carousel','Description'),
            ],

            [
                'attribute' => 'created',
                'label' => Yii::t('serval','Created'),
                'value' =>function( $carousel )
                {
                    return Yii::$app->formatter->asDate( $carousel->created, 'php:d-m-Y H:i:s');
                },
                'contentOptions' => [ 'class'=>'col-13-chars' ],
            ],

            [
                'attribute' => 'updated',
                'label' => Yii::t('serval','Updated'),
                'value' =>function( $carousel )
                {
                    return Yii::$app->formatter->asDate( $carousel->updated, 'php:d-m-Y H:i:s');
                },
                'contentOptions' => [ 'class'=>'col-13-chars' ],
            ],

            [
                'attribute' => 'activate_at',
                'label' => Yii::t('carousel','Activate at'),
                'value' =>function( $carousel )
                {
                    if( $carousel->activate_at != null ) {
                        return Yii::$app->formatter->asDate($carousel->activate_at, 'php:d-m-Y H:i:s');
                    }

                    return '-';
                },
                'contentOptions' => [ 'class'=>'col-13-chars' ],
            ],

            [
                'attribute' => 'is_active',
                'label' => Yii::t('carousel','is Active'),
                'value' =>  function( $carousel )
                {
                    return ( $carousel->is_active == 1 ) ? '<span class="green">' . Yii::t('serval','Yes') . '</span>' : '<span class="red"> ' . Yii::t('serval','No') . '</span>';
                },
                'filter' => ['0'=> Yii::t('serval','No'), '1' => Yii::t('serval','Yes') ],
                'format' => 'html',
                'contentOptions' => [ 'class'=>'col-80px' ],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=> Yii::t('grid-view','Action'),
                'headerOptions' => [ 'class' => 'action-3-items' ],
            ],
        ],
    ]); ?>
</div>
