<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Edit User';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <div class="page-title-wrapper">
        <h1><?=$this->title?></h1>
    </div>

    <p>
        <?= Html::a('Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */?>
        &nbsp;
        <?= Html::a('Go to List', ['/user'], [ 'class' => 'btn btn-info' ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            [
                'attribute' => 'status',
                'value' => function( $user_info ) {
                    if( $user_info->status == 10 ){
                        return 'active';
                    }
                    return '';
                },
            ],
            [
                'attribute' => 'created_at',
                'value' => function( $user_info ) {
                        return date('d-m-Y', $user_info->created_at);
                    },
            ],
            [
                'attribute' => 'updated_at',
                'value' => function( $user_info ) {
                    return date('d-m-Y', $user_info->updated_at);
                },
            ],
        ],
    ]) ?>

</div>
