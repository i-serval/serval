<?php

use yii\helpers\Html;
use backend\assets\carousel\SortableTableAsset;

SortableTableAsset::register($this);

$this->title = Yii::t('carousel', 'Sort Slider Items');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('carousel', 'Sort');

?>

<div class="carousel-record-update">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <h4><span class="label label-info"><?= Yii::t('carousel', 'click and drag to sort the items') ?></span></h4>

    <div class="carousel-sort-items slides-list-wrapper">
        <?= $this->render('blocks/carousel-items-list', ['carousel_items' => $carousel_items,
            'carousel_id' => $carousel_id, 'with_description' => true]); ?>
    </div>

</div>
