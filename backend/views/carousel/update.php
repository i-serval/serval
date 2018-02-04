<?php

use yii\helpers\Html;
use yii\jui\Sortable;

$this->title = Yii::t('carousel', 'Edit Slider Record');
$this->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Sliders List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('carousel', 'Edit');
?>
<div class="carousel-record-update">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <div class="flex-container" style="width: 1265px;">

        <div class="flex-item">
            <?= $this->render('_form', compact('carousel_form')) ?>
        </div>


        <div class="flex-item" style="padding-left: 35px">

            <p>
                <?= Html::a(Yii::t('carousel', 'Create New Slide'), ['/carousel/add-carousel-item', 'carousel_id' => $carousel_form->id], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('carousel', 'Attach Existing Slide'), ['/carousel/add-carousel-item', 'carousel_id' => $carousel_form->id], ['class' => 'btn btn-info']) ?>
            </p>

            <?php /* $this->render('blocks/carousel-items-list', ['carousel_items' => $carousel_items]); */ ?>


            <table>

                <tr>
                    <td>1</td><td>1</td>
                </tr>

                <tr>
                    <td>2</td><td>2</td>
                </tr>

            </table>


        </div>

    </div>

</div>
