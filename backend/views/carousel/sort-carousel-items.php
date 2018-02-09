<?php

use yii\helpers\Html;
use backend\assets\carousel\SortableTableAsset;

SortableTableAsset::register($this);

$this->title = Yii::t('carousel', 'Sort Slider Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slider'), 'url' => ['update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = Yii::t('carousel', 'Sort');

?>

<div class="carousel-record-update">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <h4>
        <b><?= Yii::t('carousel', 'Slider : ') ?></b>"<?= $carousel->title ?>"
    </h4>

    <div class="carousel-sort-items slides-list-wrapper">
        <div class="alert alert-info">
            <strong><?= Yii::t('carousel', 'Click and drag to sort the items') ?> !</strong>
        </div>
        <?= $this->render('blocks/carousel-items-list', ['carousel' => $carousel, 'with_description' => true]); ?>
    </div>

</div>
