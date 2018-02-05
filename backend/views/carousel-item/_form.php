<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="carousel-item-form">

    <?php

    $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data'
        ]
    ]);

    ?>

    <?= $form->field($carousel_item_form, 'title')->textInput() ?>

    <?= $form->field($carousel_item_form, 'description')->textArea(['rows' => 5]) ?>

    <?php

    $img_tag = ($carousel_item_form->getImageUrl() != null) ? Html::img($carousel_item_form->getImageUrl(), ['width' => '200px', 'height' => 'auto']) . '<br /><br />' : '';

    $input_options = ['template' => '
            
            <label class="control-label" for="articleform-description">Carousel Image ( 1125 x 600 px ):</label> <br />
            <div class="input-group">
                ' . $img_tag . '
                {input}
             </div>
                {hint}
                {error}'
    ] ?>
    <?= $form->field($carousel_item_form, 'carousel_image', $input_options)->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($carousel_item_form->isNewRecord() ? 'Create' : 'Save',
            ['class' => $carousel_item_form->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
