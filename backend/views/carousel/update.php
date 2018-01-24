<?php

$this->title = Yii::t('carousel','Edit Slider Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel','Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('carousel', 'Edit');
?>
<div class="carousel-record-update">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', compact('carousel_form')) ?>

</div>
