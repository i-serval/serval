<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = Yii::t('carousel', 'Create Slide');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Slides List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="carousel-create">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', compact('carousel_item_form')) ?>

</div>
