<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\serval\helper\GridViewHelper;
use backend\assets\carousel\AttachSlideAsset;

AttachSlideAsset::register($this);

$this->title = Yii::t('carousel', 'Attach Slides to Slider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slider'), 'url' => ['update', 'id' => $carousel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="carousel-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <h4>
        <span class="label label-info"><?= Yii::t('carousel', 'Click on table row for attach/detach item') ?></span>
    </h4>

    <?= GridView::widget([

        'dataProvider' => $data_provider,
        'filterModel' => $search_model,

        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-titles-font-size-13px',
            'style' => 'max-width: 1100px;',
            'id' => 'attach-detach-items',
            'data-carousel-id' => $carousel_id,
        ],

        'rowOptions' => function ($carousel_item, $key, $index, $grid) {
            return ['data-carousel-item-id' => $carousel_item->id];
        },

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
                'format' => 'html',
                'value' => function ($carousel_item) {

                    $content = '';

                    if ($carousel_item->use_count > 0) {

                        $content = GridViewHelper::wrapToTag($carousel_item->use_count, ['class' => 'font-size-24px']);
                        $content .= '<br />' . Html::a(Yii::t('carousel', 'View Sliders'), ['carousel/list/', 'carousel_item_id' => $carousel_item->id]);

                    } else {

                        $content = GridViewHelper::wrapToTag($carousel_item->use_count, ['class' => 'font-size-24px']);
                    }

                    return $content;
                },

                'contentOptions' => ['class' => 'text-align-center vertical-align-middle use-count-value'],
                'filterOptions' => ['class' => 'col-160px'],

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
                'attribute' => 'attach_status',
                'header' => Yii::t('grid-view', 'Attach/Detach'),
                'filter' => [

                    'attached' => Yii::t('carousel', 'Attached'),
                    'detached' => Yii::t('carousel', 'Detached')

                ],
                'value' => function ($carousel_item) {

                    $checked = false;

                    if ($carousel_item->is_used !== null) {
                        $checked = true;
                    }

                    return Html::checkbox('carousel-item-' . $carousel_item->id, $checked, ['class' => 'attach-detach-carousel-item']);
                    return "sdfsdfsdfsf";

                },

                'format' => 'raw',
                'filterOptions' => ['class' => 'action-3-items'],
                'contentOptions' => ['class' => 'vertical-align-middle text-align-center'],

            ],
        ],

    ]);

    ?>

</div>
