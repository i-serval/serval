<?php

namespace backend\controllers;

use Yii;
use common\models\CarouselForm;

use common\models\CarouselSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\controllers\ServalController;

use common\models\serval\carousel\Carousel;


class CarouselController extends ServalController
{

    public function behaviors()
    {

        return  ArrayHelper::merge( parent::behaviors(), [

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
        /*$searchModel = new CarouselSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/

        echo "_______index";
    }

    public function actionView( $id )
    {
        $carousel = (new Carousel())->loadByID( $id );

        return $this->render( 'view', [
            'carousel' => $carousel,
        ]);
    }

    public function actionCreate()
    {

        $carousel = new Carousel();

        if ( $carousel->load( Yii::$app->request->post() ) && $carousel->save() ) {

            return $this->redirect( ['view', 'id' => $carousel->id ] );

        } else {

            return $this->render( 'create', [
                'carousel' => $carousel,
            ]);

        }

    }

    public function actionUpdate( $id )
    {

        $carousel = (new Carousel())->loadByID( $id );

        if ( $carousel->load( Yii::$app->request->post() ) && $carousel->save() ) {

            return $this->redirect( [ 'view', 'id' => $carousel->id ] );

        } else {

            return $this->render('update', [
                'carousel' => $carousel,
            ]);

        }
    }

    public function actionDelete( $id )
    {

        (new Carousel())->loadByID( $id )->delete();

        return $this->redirect( ['index'] );

    }

}
