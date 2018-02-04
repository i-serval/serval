<?php

namespace backend\controllers;

use Yii;
use backend\models\serval\carousel\CarouselSearch;
use backend\models\serval\carousel\CarouselForm;
use backend\models\serval\carousel\CarouselManager;
use backend\models\serval\carousel\CarouselItemForm;
use yii\web\NotFoundHttpException;

class CarouselController extends \backend\controllers\ServalController
{

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

        return $this->render('update', ['carousel_form' => $carousel_form,
            'carousel_items' => $carousel->carousel_items]
        );

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

        if ($carousel_item_form->load(Yii::$app->request->post())) {

            if (($carousel_item_model = $carousel_item_form->save()) != null) {

                $carousel = (new CarouselManager())->getModelByID($carousel_id);
                $carousel->link('carousel_items', $carousel_item_model);

                return $this->redirect(['view', 'id' => $carousel_id]);

            }

        }

        return $this->render('create-carousel-item', compact('carousel_item_form', 'carousel_id'));


    }

}
