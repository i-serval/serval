<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//use yii\jui\DatePicker;
use backend\widgets\datetime\DateTimePicker;

?>

<?php
$yes_no_items = [
    'no' => Yii::t('serval', 'No'),
    'yes' => Yii::t('serval', 'Yes'),
]
?>

<div class="carousel-record-form">

    <?php

    $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        ],
        'options' => [
            'class' => 'col-sm-6',
        ]
    ]);

    ?>

    <?= $form->field($carousel_form, 'title')->textInput() ?>

    <?= $form->field($carousel_form, 'description')->textarea(['rows' => '4']) ?>

    <?php

    $img_tag = 'some tag';
    $input_options = ['template' => '
            
            <label class="control-label" for="articleform-description">Carousel Image ( 1125 x 600 px ):</label> <br />
            <div class="input-group">
                ' . $img_tag . '
                {input}
             </div>
                {hint}
                {error}'
    ] ?>

    <?= $form->field($carousel_form, 'activate_at_date', DateTimePicker::getActivFieldOptions())
        ->widget(DateTimePicker::classname(), [
            'language' => explode('-', Yii::$app->language)[0],
            'dateFormat' => 'php:d-m-Y 00:00:00',

        ])
        ->label($carousel_form->getAttributeLabel('activate_at') . ' : '); ?>


    <?php /*$form->field($carousel_form, 'activate_at_date')
        ->widget(DatePicker::classname(), [
            'language' => explode('-', Yii::$app->language)[0],
            ////'dateFormat' => 'php:d-m-Y 00:00:00',

        ])
        ->label($carousel_form->getAttributeLabel('activate_at') . ' : '); */ ?>



    <?php

    if ($carousel_form->id !== null) {

        echo $form->field($carousel_form, 'is_active')
            ->dropDownList($yes_no_items, ['class' => 'form-control yes-no-drop-down ']);

    }

    ?>

    <div class="form-group">
        <?= Html::submitButton(
            $carousel_form->isNewRecord() ? Yii::t('serval', 'Create') : Yii::t('serval', 'Save'),
            ['class' => $carousel_form->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
