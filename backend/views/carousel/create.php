<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\serval\carousel\CarouselRecord */

$this->title = 'Create Carousel Record';
$this->params['breadcrumbs'][] = ['label' => 'Carousel Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-record-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
