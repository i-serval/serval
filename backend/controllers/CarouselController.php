<?php

namespace backend\controllers;

use Yii;
use common\models\serval\carousel\CarouselRecord;
use backend\models\serval\carousel\CarouselSearch;
use backend\models\serval\carousel\CarouselForm;
use backend\models\serval\carousel\CarouselManager;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CarouselController extends \backend\controllers\ServalController
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $search_model = new CarouselSearch();
        $data_provider = $search_model->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('search_model', 'data_provider'));
    }

    public function actionView($id)
    {

        if (($carousel = (new CarouselManager())->getModelByID($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', compact('carousel'));

    }

    public function actionCreate()
    {
        $carousel_form = new CarouselForm();

        if ($carousel_form->load(Yii::$app->request->post())) {

            if ($carousel = $carousel_form->save()) {

                Yii::$app->session->setFlash('success', Yii::t('serval', 'New record saved successfully'));

                return $this->redirect(['view', 'id' => $carousel->id]);
            }
        }

        return $this->render('create', compact('carousel_form'));
    }

    public function actionUpdate($id)
    {
        $carousel = (new CarouselManager())->getModelByID($id);

        $carousel_form = new CarouselForm();
        $carousel_form->setAttributes($carousel->getAttributes());
        $carousel_form->id = $carousel->id;

        if ($carousel_form->load(Yii::$app->request->post())) {

            if ($updated_carousel = $carousel_form->update($carousel)) {

                Yii::$app->session->setFlash('success', Yii::t('serval', 'Record updated successfully'));

                return $this->redirect(['view', 'id' => $updated_carousel->id]);
            }
        }

        return $this->render('update', compact('carousel_form'));

     }

    public function actionDelete($id)
    {
        $carousel = (new CarouselManager())->getModelByID($id);

        if( $carousel !== null){
            $carousel->delete();
        }

        Yii::$app->session->setFlash('success', Yii::t('serval', 'Record deleted successfully'));

        return $this->redirect(['index']);
    }

}
