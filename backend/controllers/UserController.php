<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\serval\user\UserRecord;
use backend\models\serval\user\UserSearch;
use backend\models\serval\user\UserCreateForm;


class UserController extends \backend\controllers\ServalController
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

    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {

        $user_form = new UserCreateForm();

        $user_form->setScenario('create');

        if ($user_form->load(Yii::$app->request->post())) {

            if ($user = $user_form->save()) {

                return $this->redirect(['view', 'id' => $user->id]);

            }
        }

        return $this->render('create', [
            'model' => $user_form,
        ]);

    }

    public function actionUpdate($id)
    {

        $user = $this->findModel($id);

        $user_form = new UserCreateForm();
        $user_form->setAttributes($user->getAttributes());
        $user_form->id = $user->id;

        if ($user_form->load(Yii::$app->request->post())) {

            if ($updated_user = $user_form->update($user)) {

                return $this->redirect(['view', 'id' => $updated_user->id]);

            }

        }


        return $this->render('update', [
            'model' => $user_form,
        ]);

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = UserRecord::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
