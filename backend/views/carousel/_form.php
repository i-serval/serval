<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

?>

<?php

$yes_no_items = [
    0 => Yii::t('serval', 'No'),
    1 => Yii::t('serval', 'Yes'),
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

    <?= $form->field($carousel_form, 'activate_at')
        ->widget(\yii\jui\DatePicker::classname(), [
            'language' => explode('-', Yii::$app->language)[0],
            'dateFormat' => 'php:d-m-Y 00:00:00',
        ])
        ->label($carousel_form->getAttributeLabel('activate_at') . ' : '); ?>

    <?php

    if ($carousel_form->id !== null) {

        echo $form->field($carousel_form, 'is_active')
            ->dropDownList($yes_no_items, ['prompt' => Yii::t('serval', 'Select...'), 'class' => 'form-control yes-no-drop-down ']);

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
