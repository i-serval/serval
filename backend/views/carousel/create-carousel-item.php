<?php

use yii\helpers\Html;

use backend\assets\DateTimePickerAsset;

/* @var $this yii\web\View */
/* @var $model common\models\serval\carousel\CarouselRecord */

$this->title = Yii::t('carousel', 'Add Slide');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slider'), 'url' => ['view', 'id' => $carousel_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-record-create">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?= $this->render('/carousel-item/_form', compact('carousel_item_form')) ?>

</div>
