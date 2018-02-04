<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\serval\helper\DateTimeHelper;
use common\components\datetimepicker\widget\DateTimePicker;

$yes_no_items = [
    'no' => Yii::t('serval', 'No'),
    'yes' => Yii::t('serval', 'Yes'),
]

?>

<div class="carousel-record-form" style="width: 720px;">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($carousel_form, 'title')->textInput() ?>

    <?= $form->field($carousel_form, 'description')->textarea(['rows' => '4']) ?>

    <?= $form->field($carousel_form, 'activate_at')
        ->widget(DateTimePicker::classname(), [
            'format' => DateTimeHelper::modifyFormat(Yii::$app->formatter->datetimeFormat, [':s' => '']),
            'pluginOptions' => [
                'showTodayButton' => true,
                'showClear' => true,
            ]
        ]); ?>

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
