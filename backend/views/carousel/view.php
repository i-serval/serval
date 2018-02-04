<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\serval\helper\GridViewHelper;

/* @var $this yii\web\View */
/* @var $model common\models\serval\carousel\CarouselRecord */

$this->title = Yii::t('carousel', 'Slider View');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-record-view">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="flex-container" style="width: 1265px;">

        <div class="flex-item">
            <p>
                <?= Html::a(Yii::t('serval', 'Edit'), ['update', 'id' => $carousel->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('serval', 'Delete'), ['delete', 'id' => $carousel->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
            <?= DetailView::widget([
                'model' => $carousel,
                'options' => [
                    'class' => 'table table-striped table-bordered detail-view',
                    'style' => 'width:625px;',
                ],
                'attributes' => [

                    [
                        'attribute' => 'id',
                        'captionOptions' => ['style' => 'width:180px;'],
                    ],
                    'title',
                    'description',

                    [
                        'attribute' => 'carousel_items_count',
                        'label' => Yii::t('carousel', 'Slides Count'),
                        'format' => 'html',
                        'value' => function ($carousel) {

                            $count = count($carousel->carousel_items);
                            if ($count > 0) {

                                return GridViewHelper::wrapToTag($count, ['class' => 'green font-size-20px']);

                            }

                            return GridViewHelper::wrapToTag($count, ['class' => 'red font-size-20px']);

                        },

                    ],

                    [
                        'attribute' => 'created_at',
                        'value' => function ($carousel) {
                            return GridViewHelper::DateTimeRowsWithIcons($carousel->created_at);
                        },
                        'format' => 'html'
                    ],

                    [
                        'attribute' => 'updated_at',
                        'value' => function ($carousel) {
                            return GridViewHelper::DateTimeRowsWithIcons($carousel->updated_at);
                        },
                        'format' => 'html'
                    ],

                    [
                        'attribute' => 'last_activation_at',
                        'value' => function ($carousel) {
                            return GridViewHelper::DateTimeRowsWithIcons($carousel->last_activation_at);
                        },
                        'format' => 'html'
                    ],

                    [
                        'attribute' => 'activate_at',
                        'value' => function ($carousel) {
                            return GridViewHelper::DateTimeRowsWithIcons($carousel->activate_at);
                        },
                        'format' => 'html'
                    ],

                    [
                        'attribute' => 'is_active',
                        'format' => 'html',
                        'value' => function ($carousel) {
                            return GridViewHelper::yesNo($carousel->is_active);
                        },
                    ]
                ],
            ]) ?>

        </div>

        <div class="flex-item" style="padding-left: 15px" >

            <p>
                <?= Html::a(Yii::t('carousel', 'Create New Slide'), ['/carousel/add-carousel-item', 'carousel_id' => $carousel->id],  ['class' => 'btn btn-success' ] )?>
                <?= Html::a(Yii::t('carousel', 'Attach Existing Slide'), ['/carousel/add-carousel-item', 'carousel_id' => $carousel->id], ['class' => 'btn btn-info']) ?>
            </p>

            <?= $this->render('blocks/carousel-items-list', ['carousel_items'=>$carousel->carousel_items]); ?>

        </div>

    </div>

</div>
