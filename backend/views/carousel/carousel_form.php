<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>

<div class="carousel-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($carousel, 'title')->textInput() ?>

    <?= $form->field($carousel, 'description')->textArea(['maxlength' => true]) ?>

    <?= $form->field($carousel, 'order')->textInput() ?>

    <?php

    $img_tag = ($carousel->image->getFileUrl() != null) ? Html::img($carousel->image->getFileUrl(), ['width' => '200px', 'height' => 'auto']) . '<br /><br />' : '';


    $input_options = ['template' => '
            
            <label class="control-label" for="articleform-description">Carousel Image ( 1125 x 600 px ):</label> <br />
            <div class="input-group">
                ' . $img_tag . '
                {input}
             </div>
                {hint}
                {error}'
    ] ?>
    <?= $form->field($carousel->image, 'file', $input_options)->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton($carousel->isNewRecord() ? 'Create' : 'Save', ['class' => $carousel->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
