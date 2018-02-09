<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


class ServalController extends \yii\web\Controller
{

    const REDIRECT_PARAMETER = 'redirect';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['error'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function init()
    {

        parent::init();

    }

    public function actionError()
    {

        $exception = Yii::$app->errorHandler->exception;

        if ($exception !== null) {

            if (yii::$app->user->isGuest) {

                $this->layout = 'guest';

            }

            return $this->render('error', [
                'exception' => $exception,
                'statusCode' => $exception->statusCode,
                'name' => $exception->getName(),
                'message' => $exception->getMessage()
            ]);

        } else {

            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));

        }

    }

    public function getRedirect()
    {

        return Yii::$app->request->get(self::REDIRECT_PARAMETER);

    }

    // remember current url(route+params) for target named as 'controller/action'

    /*    protected function rememberCurrentUrl($target_controller_and_action)
        {

            Url::remember(Yii::$app->request->url, $target_controller_and_action);

        }*/

    // extract rememberes url(route+params) for current route if exists remembered

    /*protected function getRememberedUrl($remove = true)
    {

        if (($url = Url::previous($this->getRoute())) != null) {

            if ($remove) {

                Url::remember(null, $this->getRoute());

            }

            return $url;
        }

        return null;

    }*/

}
