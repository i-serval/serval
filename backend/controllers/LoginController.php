<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\models\serval\user\UserLoginForm;
use yii\helpers\ArrayHelper;


class LoginController extends \backend\controllers\ServalController
{

    public $layout = 'login/login';

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                    ],
                ],
            ],

        ]);
    }

    // user login
    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new UserLoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();

        } else {

            return $this->render('login', ['model' => $model]);

        }

    }

}
