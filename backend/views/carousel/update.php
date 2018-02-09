<?php

use yii\helpers\Html;
use backend\assets\carousel\SortableTableAsset;
use backend\assets\carousel\DetachSlideAsset;
use backend\controllers\CarouselController;

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
            <?= Html::a(Yii::t('carousel', 'Add New Slide'), ['/carousel/add-carousel-item', 'carousel_id' => $carousel->id, CarouselController::REDIRECT_PARAMETER => Yii::$app->request->url], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('carousel', 'Attach Existing Slide'), ['/carousel/attach-carousel-items', 'carousel_id' => $carousel->id], ['class' => 'btn btn-info']) ?>
        </p>

        <div class="carousel-update slides-list-wrapper">
            <div class="alert alert-info">
                <strong><?= Yii::t('carousel', 'Click and drag to sort the items') ?> !</strong>
            </div>
            <?= $this->render('blocks/carousel-items-list', ['carousel' => $carousel,'with_detach' => true, 'with_action_column' => true ]); ?>
        </div>

    <?php } ?>


</div>
