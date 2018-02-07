<?php

use yii\helpers\Html;

$this->title = Yii::t('carousel', 'Sliders List');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="carousel-record-index">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('carousel', 'Create Slider'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= $this->render('blocks/carousel-list', ['search_model' => $search_model, 'data_provider' => $data_provider ]); ?>

</div>
