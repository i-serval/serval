<?php
use yii\helpers\Html;
?>

<table class="table table-striped table-bordered table-condensed" style="width: 625px;">
    <thead style="background-color: #d9edf7">
    <tr>
        <td style="width: 20px;">
            <b><?= Yii::t('serval', 'ID') ?></b>
        </td>
        <td style="width: 405px;">
            <b><?= Yii::t('carousel', 'Slide Title') ?></b>
        </td>
        <td style="width: 200px;">
            <b><?= Yii::t('carousel', 'Slide Image') ?></b>
        </td>
    </tr>
    </thead>
    <?php foreach ($carousel_items as $carousel_item) { ?>
        <tbody>
        <tr>
            <td>
                <?= $carousel_item->id ?>
            </td>
            <td>
                <?= $carousel_item->title ?>
            </td>
            <td>
                <?= Html::img($carousel_item->image->getFileUrl(), ['style' => 'width:200px; height:auto;']) ?>
            </td>
        </tr>
        </tbody>
    <?php } ?>
</table>