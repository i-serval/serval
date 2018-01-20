<?php

namespace backend\controllers;

use Yii;
use common\models\CarouselForm;
use common\models\Carousel;
use common\models\CarouselSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\controllers\ServalController;


class CarouselController extends ServalController
{

    public function behaviors()
    {

        return  ArrayHelper::merge( parent::behaviors(), [

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
        $searchModel = new CarouselSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView( $id )
    {
        return $this->render( 'view', [
            'model' => $this->findModel( $id ),
        ]);
    }


//------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------
//------------------------------------------------------------------------------------------------------------------------------

    public function actionCreate()
    {

        $carousel_form = new CarouselForm();
        $carousel_form->setScenario('create');

        if ( $carousel_form->load( Yii::$app->request->post() ) && $carousel_form->save() ) {

            return $this->redirect( ['view', 'id' => $carousel_form->carousel_id ] );

        } else {

            return $this->render( 'create', [
                'carousel_form' => $carousel_form,
            ]);
        }
    }

//------------------------------------------------------------------------------------------------------------------------------

    public function actionUpdate( $id )
    {
        $carousel = $this->findModel( $id );

        $carousel_form = new CarouselForm( );
        $carousel_form->setAttributes( $carousel->getAttributes() );
        $carousel_form->setScenario('update');

        $carousel_form->id = $carousel->id;
        $carousel_form->image_file = $carousel->image;
        $carousel_form->image_id = $carousel->image_id;

        if ( $carousel_form->load( Yii::$app->request->post() ) && $carousel_form->update() ) {

            return $this->redirect( [ 'view', 'id' => $carousel_form->carousel_id ] );

        } else {

            $carousel_form->id = $carousel->id;
            $carousel_form->image_file = $carousel->image;

            return $this->render('update', [
                'carousel_form' => $carousel_form,
            ]);

        }
    }


    //------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------------------------------------------------------


    public function actionDelete( $id )
    {

        $carousel_item = Carousel::find()
            ->with('image')
            ->Where( ['id' => $id ] )
            ->one();

        $carousel_item->delete();

        return $this->redirect( ['index'] );

    }

    protected function findModel($id)
    {
        if (($model = Carousel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
