<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\serval\carousel\CarouselRecord */

$this->title = Yii::t('carousel', 'Slider View' );
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List' ), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-record-view">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <p>
        <?= Html::a(Yii::t('serval', 'Edit' ), ['update', 'id' => $carousel->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('serval', 'Delete' ), ['delete', 'id' => $carousel->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $carousel,
        'attributes' => [
            'id',
            'title',
            'description',
            'created',
            'updated',
            'activate_at',
            'is_active',
        ],
    ]) ?>

</div>

<div>
    <?= Html::a(Yii::t('serval', 'Add Slide' ), ['/carousel/add-carousel-item', 'carousel_id' => $carousel->id], ['class' => 'btn btn-success']) ?>
</div>
