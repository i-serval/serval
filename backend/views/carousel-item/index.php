<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = Yii::t('carousel','Slides');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('carousel','Add Slide'), ['create'], ['class' => 'btn btn-success']) . '   ' ?>
        <?php /* Html::tag('a', Html::encode('Open in frontend'), ['href' => Yii::$app->params['frontendDomain'], 'target' => '_blank', 'class' => 'btn btn-info']);*/ ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'number-col'],
            ],

            [
                'attribute' => 'id',
                'contentOptions' => ['class' => 'col-4-chars'],
            ],
            'title',
            'description',

            [
                'attribute' => 'image',
                'value' => function ($carousel_item) {

                    return Html::img($carousel_item->getImageUrl(), ['width' => '150px', 'height' => 'auto']);


                },
                'format' => 'html',
                'contentOptions' => ['class' => 'col-150px-chars'],

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'headerOptions' => ['class' => 'action-3-items'],
            ],
        ],
    ]); ?>
</div>
