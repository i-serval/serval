<?php

use yii\helpers\Html;
use backend\controllers\CarouselController;

$is_show_description = false;
$is_show_detach_column = false;
$is_show_action_column = false;

if (isset($with_description) && $with_description == true) {
    $is_show_description = true;
}

if (isset($with_detach) && $with_detach == true) {
    $is_show_detach_column = true;
}

if (isset($with_action_column) && $with_action_column == true) {
    $is_show_action_column = true;
}

?>

<table id="slides-list" data-carousel-id="<?= $carousel->id ?>" class="table table-striped bg-white table-bordered">

    <thead class="green-thead">

    <tr>

        <td class="slides-list-id">
            <b><?= Yii::t('serval', 'ID') ?></b>
        </td>
        <td class="slides-list-order">
            <b><?= Yii::t('carousel', 'Display Order') ?></b>
        </td>
        <td class="slides-list-title">
            <b><?= Yii::t('carousel', 'Slide Title') ?></b>
        </td>

        <?php if ($is_show_description == true) { ?>

            <td class="slides-list-description">
                <b><?= Yii::t('carousel', 'Slide Description') ?></b>
            </td>

        <?php } ?>

        <td class="slides-list-image">
            <b><?= Yii::t('carousel', 'Slide Image') ?></b>
        </td>

        <?php if ($is_show_detach_column == true) { ?>

            <td class="slides-list-detach">
                <b><?= Yii::t('carousel', 'Detach') ?></b>
            </td>

        <?php } ?>

        <?php if ($is_show_action_column == true) { ?>

            <td class="slides-list-detach">
                <b><?= Yii::t('carousel', 'Action') ?></b>
            </td>

        <?php } ?>

    </tr>

    </thead>

    <tbody>

    <?php foreach ($carousel->carousel_items_sorted as $carousel_item) { ?>
        <tr data-id="<?= $carousel_item->id ?>">

            <td>
                <?= $carousel_item->id ?>
            </td>

            <td data-order="<?= $carousel_item->order ?>"
                class="text-align-center vertical-align-middle slides-list-order">

                <?= Html::tag('span', $carousel_item->order, ['class' => 'font-size-24px']); ?>

            </td>

            <td>
                <?= $carousel_item->title ?>
            </td>

            <?php if ($is_show_description == true) { ?>

                <td>
                    <?= $carousel_item->description ?>
                </td>

            <?php } ?>

            <td>
                <?= Html::img($carousel_item->image->getFileUrl(), ['style' => 'width:200px; height:auto;']) ?>
            </td>

            <?php if ($is_show_detach_column == true) { ?>

                <td class="slides-list-detach-content">
                    <?php

                    echo Html::a('<span class="glyphicon glyphicon-remove"></span>',
                        ['carousel/detach-carousel-item', 'carousel_id' => $carousel->id, 'carousel_item_id' => $carousel_item->id],
                        ['title' => Yii::t('carousel', 'Detach Slide'), 'class' => 'slides-list-detach-link']
                    );

                    ?>
                </td>

            <?php } ?>

            <?php if ($is_show_action_column == true) { ?>

                <td class="slides-list-action">
                    <?php

                    echo  Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                        ['carousel-item/view', 'id' => $carousel_item->id],
                        ['title' => Yii::t('carousel', 'View Slide')]
                    );
                    echo " ";
                    echo Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                        ['carousel-item/update', 'id' => $carousel_item->id, CarouselController::REDIRECT_PARAMETER => Yii::$app->request->url ],
                        ['title' => Yii::t('carousel', 'Edit Slide')]
                    );

                    ?>
                </td>

            <?php } ?>

        </tr>
    <?php } ?>

    </tbody>

</table>
