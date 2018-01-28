<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Add User';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-form">

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 're_password')->passwordInput()->label(Yii::t('yii', 'Retype password')) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord() ? 'Create' : 'Save', ['class' => $model->isNewRecord() ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>

