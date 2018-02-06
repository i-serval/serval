<?php

use yii\helpers\Html;
use backend\assets\carousel\SortableTableAsset;
use backend\assets\carousel\DetachSlideAsset;

SortableTableAsset::register($this);
DetachSlideAsset::register($this);

$this->title = Yii::t('carousel', 'Edit Slider Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('carousel', 'Edit');

?>

<div class="carousel-record-update">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', compact('carousel_form')) ?>

    <?php if (isset($carousel_form->id)) { ?>

        <hr/>

        <p>
            <?= Html::a(Yii::t('carousel', 'Create New Slide'), ['/carousel/add-carousel-item', 'carousel_id' => $carousel_form->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('carousel', 'Attach Existing Slide'), ['/carousel/attach-carousel-items', 'carousel_id' => $carousel_form->id], ['class' => 'btn btn-info']) ?>
        </p>

        <h4><span class="label label-info"><?= Yii::t('carousel', 'click and drag to sort the items') ?></span></h4>

        <div class="carousel-update slides-list-wrapper">
            <?= $this->render('blocks/carousel-items-list', ['carousel_items' => $carousel_items,
                'carousel_id' => $carousel_form->id,
                'with_detach' => true
            ]); ?>
        </div>

    <?php } ?>


</div>
