<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = Yii::t('carousel', 'Edit Slide');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slides List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="carousel-update">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', [
        'carousel_item_form' => $carousel_item_form,
    ]) ?>

</div>
