<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\serval\helper\GridViewHelper;
use backend\controllers\CarouselItemController;

$this->title = Yii::t('carousel', 'Slides');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('carousel', 'Add Slide'), ['create'], ['class' => 'btn btn-success']) . '   ' ?>
        <?php /* Html::tag('a', Html::encode('Open in frontend'), ['href' => Yii::$app->params['frontendDomain'], 'target' => '_blank', 'class' => 'btn btn-info']);*/ ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-titles-font-size-13px',
            'style' => 'max-width: 1100px;'
        ],
        'columns' => [

            [
                'class' => 'yii\grid\SerialColumn',
                'filterOptions' => ['class' => 'col-2-chars'],
            ],

            [
                'attribute' => 'id',
                'filterOptions' => ['class' => 'col-3-chars'],
            ],

            [
                'attribute' => 'title',
                'filterOptions' => ['class' => 'col-350px'],
            ],

            [
                'attribute' => 'description',
            ],
            [
                'attribute' => 'use_count',
                'format' => 'raw',
                'value' => function ($carousel_item) {

                    $content = '';

                    if ($carousel_item->use_count > 0) {

                        $content = GridViewHelper::wrapToTag($carousel_item->use_count, ['class' => 'font-size-24px']);
                        $content .= '<br />' . Html::a(Yii::t('carousel', 'Open List'),
                                ['carousel/list-by-item/', 'carousel_item_id' => $carousel_item->id],
                                ['target' => '_blank']
                            );

                    } else {

                        $content = GridViewHelper::wrapToTag($carousel_item->use_count, ['class' => 'font-size-24px']);
                    }

                    return $content;
                },

                'contentOptions' => ['class' => 'text-align-center vertical-align-middle'],
                'filterOptions' => ['class' => 'col-140px'],

            ],

            [
                'attribute' => 'image',
                'value' => function ($carousel_item) {
                    return Html::img($carousel_item->getImageUrl());
                },

                'format' => 'html',
                'filterOptions' => ['class' => 'col-200px'],
                'contentOptions' => ['class' => 'col-200px image-182px'],

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('grid-view', 'Action'),

                'template' => '{view}  {update}  {delete}',

                'buttons' => [

                    'delete' => function ($url, $carousel_item, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            ['/carousel-item/delete', 'id' => $carousel_item->id, CarouselItemController::REDIRECT_PARAMETER => Yii::$app->request->url],
                            ['title' => Yii::t('carousel', 'Sorting Items')]
                        );

                    },
                ],

                'filterOptions' => ['class' => 'action-3-items'],
            ],
        ],
    ]); ?>
</div>
