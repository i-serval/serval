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

    public function actionIndex()
    {

        $search_model = new CarouselItemSearch();
        $data_provider = $search_model->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('search_model', 'data_provider'));

    }

    public function actionView($id)
    {

        if (($carousel_item = (new CarouselItemManager())->getModelByID($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('view', compact('carousel_item'));

    }

    public function actionCreate()
    {

        $carousel_item_form = new CarouselItemForm();

        if ($carousel_item_form->load(Yii::$app->request->post())) {

            if (($carousel_item_model = $carousel_item_form->save()) != null) {

                return $this->redirect(['view', 'id' => $carousel_item_model->id]);

            }

        }

        return $this->render('create', compact('carousel_item_form'));

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

        if (($carousel_item = (new CarouselItemManager())->getModelByID($id)) != null) {

            $carousel_item->delete();
            Yii::$app->session->setFlash('success', Yii::t('carousel', 'Slide deleted successfully'));

        } else {

            Yii::$app->session->setFlash('error', Yii::t('carousel', 'Slide not deleted'));

        }

        return $this->redirect(['index']);

    }

}
