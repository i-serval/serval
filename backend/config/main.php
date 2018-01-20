<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

 return [
     'id' => 'servla-backend',
     'basePath' => dirname(__DIR__),
     'controllerNamespace' => 'backend\controllers',
     'bootstrap' => ['log'],
     'modules' => [],
     'layout' => 'serval',   //'layoutPath' => '@app/views/layouts-2'
     'timeZone' => 'Europe/Kiev',
     'defaultRoute' => 'dashboard',  // default controller name

     'components' => [

         'request' => [
             'csrfParam' => '_csrf-backend',
             'baseUrl' => '',
         ],

         'user' => [
             'identityClass' => 'common\models\ServalUser',
             'enableAutoLogin' => true,
             'identityCookie' => [
                 'name' => '_identity-backend',
                 'httpOnly' => true
             ],
             'loginUrl' => ['login'],
         ],

         'session' => [
             'name' => 'serval-backend', // this is the name of the session cookie used for login on the backend
         ],

         'log' => [
             'traceLevel' => YII_DEBUG ? 3 : 0,
             'targets' => [
                 [
                     'class' => 'yii\log\FileTarget',
                     'levels' => ['error', 'warning'],
                 ],
             ],
         ],

         'errorHandler' => [
             'errorAction' => 'serval/error',
         ],

         'urlManager' => [
             'enablePrettyUrl' => true,
             'showScriptName' => false,
             'rules' => [],
         ],

     ],

     'params' => $params,
];
