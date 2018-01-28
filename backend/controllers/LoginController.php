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

            $this->synchronizeLanguageAfterLogin();

            return $this->goBack();

        } else {

            return $this->render('login', ['model' => $model]);

        }

    }

    protected function synchronizeLanguageAfterLogin()
    {

        $current_cookie_lang = Yii::$app->languagepicker->getLanguage();

        $current_user_lang = Yii::$app->user->identity->language;

        if( $current_user_lang !== null ) { // if user have not null lang set lang to cookie

            Yii::$app->languagepicker->saveLanguageIntoCookie($current_user_lang);

        } else { // if user lang is null set lang from cookie to user.

            $user = Yii::$app->user->identity;
            $user->language = $current_cookie_lang;
            $user->save();

        }

    }

}
