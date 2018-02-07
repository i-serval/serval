<?php

use yii\helpers\Html;

use backend\assets\DateTimePickerAsset;

$this->title = Yii::t('carousel', 'Add Slide');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slider'), 'url' => ['update', 'id' => $carousel->id]];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="carousel-record-create">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <h4>
        <b><?=Yii::t('carousel', 'Slider : ')?></b>"<?=$carousel->title?>"
    </h4>

    <?= $this->render('/carousel-item/_form', compact('carousel_item_form')) ?>

</div>
