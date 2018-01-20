<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="page-title-wrapper">
        <h1><?=$this->title?></h1>
    </div>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => [ 'class'=>'number-col' ],
                'headerOptions' => [ 'class'=>'number-col' ],
            ],

            [
                'attribute' => 'id',
                'contentOptions' => [ 'class'=>'col-4-chars' ],
                'headerOptions' => [ 'class'=>'col-4-chars' ],
            ],
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
                'headerOptions' => [ 'class'=>'col-10-chars' ],
                'contentOptions' => [ 'class'=>'col-10-chars' ]
            ],
            [
                'attribute' => 'created_at',
                'value' => function( $user_info ) {
                        return date('d-m-Y', $user_info->created_at);
                    },
                'headerOptions' => [ 'class'=>'col-10-chars' ],
                'contentOptions' => [ 'class'=>'col-10-chars' ],
            ],
            [
                'attribute' => 'updated_at',
                'value' => function( $user_info ) {
                        return date('d-m-Y', $user_info->updated_at);
                    },
                'headerOptions' => [ 'class'=>'col-13-chars-t' ],
                'contentOptions' => [ 'class'=>'col-13-chars-t' ],

            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Action',
                'template' => '{view}{update}',
                'headerOptions' => [ 'class' => 'action-3-items' ],
            ],
        ],
    ]); ?>
</div>
