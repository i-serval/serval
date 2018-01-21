<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


class ServalController extends Controller
{

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

}
