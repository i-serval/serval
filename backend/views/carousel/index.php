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
        'columns' => [

            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'headerOptions' => ['class' => 'col-4-chars'],
                'filterOptions' => ['class' => 'col-4-chars'],
                'contentOptions' => ['class' => 'col-4-chars'],
            ],

            [
                'attribute' => 'title',
                'label' => Yii::t('carousel', 'Name'),
                'contentOptions' => ['class' => 'col-550px'],
            ],

            [
                'attribute' => 'description',
                'label' => Yii::t('carousel', 'Description'),
            ],

            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'label' => Yii::t('serval', 'Created'),
                'contentOptions' => ['class' => 'col-data-time seconds'],
            ],

            [
                'attribute' => 'updated_at',
                'label' => Yii::t('serval', 'Updated'),
                'format' => 'datetime',
                'contentOptions' => ['class' => 'col-data-time seconds'],
            ],

            [
                'attribute' => 'activate_at',
                'label' => Yii::t('carousel', 'Activate at'),
                'value' => function ($carousel) {
                    return DateTimeHelper::getDatetimeWithoutSeconds($carousel->activate_at);
                },
                'contentOptions' => ['class' => 'col-data-time'],
            ],

            [
                'attribute' => 'is_active',
                'label' => Yii::t('carousel', 'is Active'),
                'value' => function ($carousel) {
                    return GridViewHelper::yesNo($carousel->is_active);
                },
                'filter' => ['no' => Yii::t('serval', 'No'), 'yes' => Yii::t('serval', 'Yes')],
                'format' => 'html',
                'contentOptions' => ['class' => 'col-yes-no'],
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('grid-view', 'Action'),
                'headerOptions' => ['class' => 'action-3-items'],
            ],
        ],
    ]); ?>
</div>
