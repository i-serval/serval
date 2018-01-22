<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\serval\carousel\CarouselItemForm;
use backend\models\serval\carousel\CarouselItemManager;
use backend\models\serval\carousel\CarouselItemSearch;


class CarouselItemController extends \backend\controllers\ServalController
{

    public function behaviors()
    {

        return ArrayHelper::merge(parent::behaviors(), [

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ]
            ]
        ]);

    }

    public function actionIndex()
    {

        $search_model = new CarouselItemSearch();
        $data_provider = $search_model->search( Yii::$app->request->queryParams );

        return $this->render('index', compact('search_model','data_provider') );

    }

    public function actionView($id)
    {

        if (($carousel = (new CarouselItemManager())->getModelByID($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', compact('carousel'));

    }

    public function actionCreate()
    {

        $carousel_form = new CarouselItemForm();

        if ($carousel_form->load(Yii::$app->request->post()) && $carousel_form->save()) {

            return $this->redirect(['view', 'id' => $carousel_form->carousel->id]);

        }

        return $this->render('create', compact('carousel_form'));

    }

    public function actionUpdate($id)
    {

        var_dump("update");
        die();
        $carousel = CarouselRecord::findOne($id);
        var_dump($carousel);

        die();

        if ($carousel->load(Yii::$app->request->post()) && $carousel->save()) {

            return $this->redirect(['view', 'id' => $carousel->id]);

        } else {

            return $this->render('update', [
                'carousel' => $carousel,
            ]);

        }
    }

    public function actionDelete($id)
    {

        $model = (new CarouselItemManager())->getModelByID($id);

        if( $model !== null){
            $model->delete();
        }

        return $this->redirect(['index']);

    }

}
