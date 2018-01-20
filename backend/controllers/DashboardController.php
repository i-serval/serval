<?php
namespace backend\controllers;

use Yii;
use yii\filters\VerbFilter;
use backend\controllers\ServalController;
use yii\helpers\ArrayHelper;
use backend\models\TrafficStatistics;


class DashboardController extends ServalController
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

        if( Yii::$app->request->get('update' ) == true ) {

          // $traffic_statistic = new TrafficStatistics();
           //$traffic_statistic->updateStatistics();

           //return $this->redirect( ['/'] );

        }

        //$traffic_statistic = new TrafficStatistics();
        //$traffic_statistic = $traffic_statistic->getTrafficStatistics();

        return $this->render( 'dashboard', [
                        /*'globals' => print_r($GLOBALS ,1 ),
                        'server_table_rows' => $_SERVER,
                        'get_table_rows' => $_GET,
                        'post_table_rows' => $_POST,
                        'files_table_rows' => $_FILES,
                        'cookie_table_rows' => $_COOKIE,
                        'session' => print_r($_SESSION ,1 ),
                        'request_table_rows' => $_REQUEST,
                        'env_table_rows' => $_ENV,*/

                       // 'traffic_statistic' => $traffic_statistic,
                    ]
                );

    }

}
