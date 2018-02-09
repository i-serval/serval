<?php

namespace backend\controllers;

use Yii;
use backend\models\serval\carousel\CarouselItemManager;
use backend\models\serval\carousel\search\CarouselSearch;
use backend\models\serval\carousel\search\CarouselItemAttachSearch;
use backend\models\serval\carousel\search\CarouselByItemSearch;
use backend\models\serval\carousel\form\CarouselForm;
use backend\models\serval\carousel\CarouselManager;
use backend\models\serval\carousel\form\CarouselItemForm;
use backend\assets\carousel\CarouselAsset;
use yii\web\NotFoundHttpException;

class CarouselController extends \backend\controllers\ServalController
{

    public function init()
    {
        parent::init();

        CarouselAsset::register($this->view);
        $this->view->params['breadcrumbs'][] = ['label' => Yii::t('carousel', 'Data')];

    }

    public function actionIndex()
    {

        $search_model = new CarouselSearch();
        $data_provider = $search_model->search(Yii::$app->request->queryParams);

        return $this->render('index', compact('search_model', 'data_provider'));

    }

    public function actionView($id)
    {

        if (($carousel = (new CarouselManager())->getModelByIDWithSlides($id)) === null) {
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

        $carousel = (new CarouselManager())->getModelByIDWithSlides($id);

        $carousel_form = new CarouselForm();
        $carousel_form->setAttributes($carousel->getAttributes());
        $carousel_form->id = $carousel->id;

        if ($carousel_form->load(Yii::$app->request->post())) {

            if ($updated_carousel = $carousel_form->update($carousel)) {

                Yii::$app->session->setFlash('success', Yii::t('serval', 'Record updated successfully'));

                return $this->redirect(['view', 'id' => $updated_carousel->id]);
            }
        }

        return $this->render('update', ['carousel_form' => $carousel_form, 'carousel' => $carousel]);

    }

    public function actionDelete($id)
    {

        if (($carousel = (new CarouselManager())->getModelByID($id)) != null) {

            $carousel->delete();
            Yii::$app->session->setFlash('success', Yii::t('carousel', 'Slider deleted successfully'));

        } else {

            Yii::$app->session->setFlash('error', Yii::t('carousel', 'Slider not deleted'));

        }

        return $this->redirect(['index']);

    }

    public function actionAddCarouselItem($carousel_id)
    {

        $carousel_item_form = new CarouselItemForm();

        $carousel_manager = new CarouselManager();
        $carousel = $carousel_manager->getModelByID($carousel_id);

        if ($carousel_item_form->load(Yii::$app->request->post())) {

            if (($carousel_item_model = $carousel_item_form->save()) != null) {

                $carousel->link('carousel_items', $carousel_item_model); // link carousel to new carousel item

                $carousel_manager->setDefaultOrderForItem($carousel->id, $carousel_item_model->id); // set defaul order value into link table after link

                Yii::$app->session->setFlash('success', Yii::t('serval', 'New Slide saved successfully'));

                return $this->redirect($this->getRedirect() ?? '/carousel-item');

            }

        }

        return $this->render('create-carousel-item', compact('carousel_item_form', 'carousel'));

    }

    public function actionSortCarouselItems($carousel_id)
    {

        if (($carousel = (new CarouselManager())->getModelByIDWithSlides($carousel_id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $this->render('sort-carousel-items', ['carousel' => $carousel]);

    }

    public function actionAttachCarouselItems($carousel_id)
    {

        $search_model = new CarouselItemAttachSearch();
        $search_model->search_carousel_id = $carousel_id;

        $data_provider = $search_model->search(Yii::$app->request->queryParams);
        $carousel = (new CarouselManager())->getModelByID($carousel_id);

        return $this->render('attach-carousel-items', compact('search_model', 'data_provider', 'carousel'));

    }

    public function actionDetachCarouselItem() // use via ajax
    {

        $carousel = (new CarouselManager())->getModelByID(json_decode(Yii::$app->request->post('carousel_id'), true));
        $carousel_item = (new CarouselItemManager())->getModelByID(json_decode(Yii::$app->request->post('carousel_item_id'), true));

        $carousel->unlink('carousel_items', $carousel_item, true);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'result' => 'successs',
        ];

    }

    public function actionAttachCarouselItem() // use via ajax
    {

        $carousel_manager = new CarouselManager();

        $carousel = $carousel_manager->getModelByID(json_decode(Yii::$app->request->post('carousel_id'), true));
        $carousel_item = (new CarouselItemManager())->getModelByID(json_decode(Yii::$app->request->post('carousel_item_id'), true));

        $carousel->link('carousel_items', $carousel_item);

        $carousel_manager->setDefaultOrderForItem($carousel->id, $carousel_item->id); // set defaul order value into link table after link

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return [
            'result' => 'successs',
        ];

    }

    public function actionPreview($carousel_id)
    {

        if (($carousel = (new CarouselManager())->getModelByIDWithSlides($carousel_id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $this->layout = 'guest';

        return $this->render('preview', ['carousel_items' => $carousel->carousel_items_sorted,
                'carousel_id' => $carousel_id]
        );

    }

    public function actionListByItem($carousel_item_id)
    {

        $search_model = new CarouselByItemSearch();
        $search_model->carousel_item_id = $carousel_item_id;
        $data_provider = $search_model->search(Yii::$app->request->queryParams);

        $carousel_item = (new CarouselItemManager())->getModelByID($carousel_item_id);

        return $this->render('list-by-item', compact('search_model', 'data_provider', 'carousel_item'));

    }

}
