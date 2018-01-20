<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Carousel */

$this->title = 'Create Carousel Item';
//$this->params['breadcrumbs'][] = ['label' => 'Carousels', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carousel-create">

    <div class="page-title-wrapper">
        <h1><?=$this->title?></h1>
    </div>

    <?= $this->render('carousel_form', [
        'carousel_form' => $carousel_form,
    ]) ?>

</div>
