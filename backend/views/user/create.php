<?php

use yii\helpers\Html;

$this->title = 'Add User';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="page-title-wrapper">
        <h1><?=$this->title?></h1>
    </div>
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
