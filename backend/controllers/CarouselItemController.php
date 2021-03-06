<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use backend\assets\carousel\CarouselAsset;
use backend\models\serval\carousel\form\CarouselItemForm;
use backend\models\serval\carousel\CarouselItemManager;
use backend\models\serval\carousel\search\CarouselItemSearch;


class CarouselItemController extends \backend\controllers\ServalController
{

    public function init()
    {
        parent::init();
        CarouselAsset::register($this->view);
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Data')];
    }

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

        $carousel_item = (new CarouselItemManager())->getModelByID($id);

        $carousel_item_form = new CarouselItemForm();
        $carousel_item_form->setAttributes($carousel_item->getAttributes());
        $carousel_item_form->id = $carousel_item->id;
        $carousel_item_form->carousel_item_instance = clone $carousel_item;

        if ($carousel_item_form->load(Yii::$app->request->post())) {

            if ($updated_carousel_item = $carousel_item_form->update($carousel_item)) {

                Yii::$app->session->setFlash('success', Yii::t('carousel', 'Slide updated successfully'));

                return $this->redirect($this->getRedirect() ?? ['view', 'id' => $updated_carousel_item->id]);
            }
        }

        return $this->render('update', compact('carousel_item_form'));


    }

    public function actionDelete($id)
    {

        if (($carousel_item = (new CarouselItemManager())->getModelByID($id)) != null && $carousel_item->delete()) {

            Yii::$app->session->setFlash('success', Yii::t('carousel', 'Slide deleted successfully'));

        } else {

            Yii::$app->session->setFlash('error', Yii::t('carousel', 'Slide not deleted'));

        }

        return $this->redirect($this->getRedirect() ?? ['index']);

    }

    public function actionUpdateOrder($carousel_id) // use via ajax
    {

        $carousel_id = (int)$carousel_id;

        $update_data = json_decode(Yii::$app->request->post('update_data'), true);
        (new CarouselItemManager())->updateSlidesOrder($update_data, $carousel_id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'result' => 'successs',
        ];

    }

}
