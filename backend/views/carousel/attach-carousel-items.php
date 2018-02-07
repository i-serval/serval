<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\serval\helper\GridViewHelper;
use backend\assets\carousel\AttachSlideAsset;

AttachSlideAsset::register($this);

$this->title = Yii::t('carousel', 'Attach Slides to Slider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slider'), 'url' => ['update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="carousel-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <h4>
        <b><?=Yii::t('carousel', 'Slider : ')?></b>"<?=$carousel->title?>"
    </h4>

    <?= GridView::widget([

        'dataProvider' => $data_provider,
        'filterModel' => $search_model,

        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-titles-font-size-13px',
            'style' => 'max-width: 1200px;',
            'id' => 'attach-detach-items',
            'data-carousel-id' => $carousel->id,
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

                'contentOptions' => ['class' => 'text-align-center vertical-align-middle use-count-value'],
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

                'attribute' => 'attach_status',
                'header' => Yii::t('grid-view', 'Attach/Detach'),
                'filter' => [

                    'attached' => Yii::t('carousel', 'Attached'),
                    'detached' => Yii::t('carousel', 'Detached')

                ],

                'filterInputOptions' => [
                    'class' => 'form-control grid-drop-down-font-13px',
                    'id' => null
                ],

                'value' => function ($carousel_item) {

                    $checked = false;

                    if ($carousel_item->is_used !== null) {
                        $checked = true;
                    }

                    return Html::checkbox('carousel-item-' . $carousel_item->id, $checked, ['class' => 'attach-detach-carousel-item']);

                },

                'format' => 'raw',
                'filterOptions' => ['class' => 'col-174px'],
                'contentOptions' => ['class' => 'vertical-align-middle text-align-center'],

            ],
        ],

    ]);

    ?>

</div>
