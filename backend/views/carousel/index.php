<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\serval\helper\DateTimeHelper;
use common\models\serval\helper\GridViewHelper;

$this->title = Yii::t('carousel', 'Sliders List');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="carousel-record-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('carousel', 'Create Slider'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
                'contentOptions' => ['class' => 'text-align-center'],
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
                'contentOptions' => ['class' => 'text-align-center'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('grid-view', 'Action'),
                'filterOptions' => ['class' => 'action-3-items'],
            ],
        ],
    ]); ?>
</div>
