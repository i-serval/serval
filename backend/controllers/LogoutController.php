<?php

namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;


class LogoutController extends \backend\controllers\ServalController
{

    public function behaviors()
    {

        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ]
            ]
        ]);

    }

    // user logout
    public function actionIndex()
    {

        Yii::$app->user->logout();

        return $this->goHome();

    }

}
