<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\serval\carousel\CarouselRecord */

$this->title = Yii::t('carousel', 'Create Slider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-record-create">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', compact('carousel_form')) ?>

</div>
