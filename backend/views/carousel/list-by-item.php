<?php

use yii\grid\GridView;
use common\models\serval\helper\GridViewHelper;
use common\models\serval\helper\DateTimeHelper;

$this->title = Yii::t('carousel', 'Sliders List By Slide Item');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="carousel-record-list-by-item">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <h4>
        <b><?= Yii::t('carousel', 'List For Slide : ') ?></b>"<?= $carousel_item->title ?>"
    </h4>

    <?= GridView::widget([
        'dataProvider' => $data_provider,
        'filterModel' => $search_model,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-titles-font-size-13px'
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
                'label' => Yii::t('carousel', 'Name'),
                'filterOptions' => ['class' => 'col-350px'],
            ],

            [
                'attribute' => 'description',
                'label' => Yii::t('carousel', 'Description'),
            ],

            [
                'attribute' => 'carousel_items_count',
                'label' => Yii::t('carousel', 'Slides Count'),
                'format' => 'html',
                'value' => function ($carousel) {

                    if ($carousel->carousel_items_count > 0) {

                        return GridViewHelper::wrapToTag($carousel->carousel_items_count, ['class' => 'green font-size-20px']);

                    }

                    return GridViewHelper::wrapToTag($carousel->carousel_items_count, ['class' => 'red font-size-20px']);

                },
                'filterOptions' => ['class' => 'col-91px'],
                'contentOptions' => ['class' => 'text-align-center vertical-align-middle'],
            ],

            [
                'attribute' => 'created_at',
                'label' => Yii::t('serval', 'Created'),
                'format' => 'html',
                'value' => function ($carousel) {
                    return GridViewHelper::DateTimeRowsWithIcons($carousel->created_at);
                },
                'filterOptions' => ['class' => 'col-data-time rows'],
            ],

            [
                'attribute' => 'updated_at',
                'label' => Yii::t('serval', 'Updated'),
                'format' => 'html',
                'value' => function ($carousel) {
                    return GridViewHelper::DateTimeRowsWithIcons($carousel->updated_at);
                },
                'filterOptions' => ['class' => 'col-data-time rows'],
            ],
            [
                'attribute' => 'last_activation_at',
                'label' => Yii::t('serval', 'Last Activation'),
                'format' => 'html',
                'value' => function ($carousel) {
                    return GridViewHelper::DateTimeRowsWithIcons($carousel->last_activation_at);
                },
                'filterOptions' => ['class' => 'col-data-time rows'],
            ],

            [
                'attribute' => 'activate_at',
                'label' => Yii::t('carousel', 'Activate at'),
                'format' => 'html',
                'value' => function ($carousel) {
                    return GridViewHelper::DateTimeRowsWithIcons($carousel->activate_at, $date_format = null, DateTimeHelper::getTimeFormatWithoutSeconds());//DateTimeHelper::getDatetimeWithoutSeconds($carousel->activate_at);
                },
                'filterOptions' => ['class' => 'col-data-time rows'],
            ],

            [
                'attribute' => 'is_active',
                'label' => Yii::t('carousel', 'is Active'),
                'filter' => ['no' => Yii::t('serval', 'No'), 'yes' => Yii::t('serval', 'Yes')],
                'format' => 'html',
                'filterInputOptions' => [
                    'class' => 'form-control grid-drop-down-font-13px',
                    'id' => null
                ],
                'value' => function ($carousel) {
                    return GridViewHelper::yesNo($carousel->is_active, ['class' => 'font-size-20px']);
                },
                'filterOptions' => ['class' => 'col-yes-no font-13px'],
                'contentOptions' => ['class' => 'text-align-center vertical-align-middle'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('grid-view', 'Action'),

                'template' => '{view}  {update}',

                'buttons' => [

                    'view' => function ($url, $carousel, $key) {

                        return '<a href="' . \yii\helpers\Url::to(['carousel/view', 'id' => $carousel->id]) . '" 
                                    title="' . Yii::t('carousel', 'View Slider') . '"
                                    target="blank"
                                    class="text-decoration-off"
                                    >
                                    <span class="glyphicon glyphicon-eye-open"></span>
                                 </a>';

                    },

                    'update' => function ($url, $carousel, $key) {

                        return '<a href="' . \yii\helpers\Url::to(['carousel/update', 'id' => $carousel->id]) . '" 
                                    title="' . Yii::t('carousel', 'Update') . '"
                                    target="blank"
                                    class="text-decoration-off"
                                    >
                                    <span class="glyphicon glyphicon-pencil"></span>
                                 </a>';

                    },

                ],

                'filterOptions' => ['class' => 'action-4-items'],
                'contentOptions' => ['class' => 'font-size-17px'],

            ],
        ],

    ]);
    ?>


</div>
