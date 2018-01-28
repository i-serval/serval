<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

$i18n = array_merge(
    require __DIR__ . '/../../common/config/i18n.php',
    require __DIR__ . '/../../common/config/i18n-local.php',
    require __DIR__ . '/i18n.php',
    require __DIR__ . '/i18n-local.php'
);

$params['i18n'] = $i18n;

return [
    'id' => 'servla-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',

    'bootstrap' => [
        'log',
        'formatter',
        'languagepicker',
    ],

    'modules' => [],
    'layout' => 'serval',                           //'layoutPath' => '@app/views/layouts-2'
    'language' => $i18n['language'],
    'timeZone' => $i18n['timeZone'],
    'defaultRoute' => 'dashboard',                  // default controller name

    'components' => [

        'request' => [
            'csrfParam' => '_csrf-backend',
            'baseUrl' => '',
        ],

        'user' => [
            'identityClass' => 'common\models\serval\user\UserIdentityRecord',
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

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\DbMessageSource',
                    'forceTranslation'=>true,
                ]
            ],
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],

        'languagepicker' => [
            'class' => 'common\components\languagepicker\Component',
            'languages' => $i18n['supportedLanguages'],
            'cookieName' => 'language',                          // Name of the cookie.
            'expireDays' => 365,                                 // The expiration time of the cookie is 64 days.
            'callback' => function() {
                if (!\Yii::$app->user->isGuest) {
                    $user = \Yii::$app->user->identity;
                    $user->language = \Yii::$app->language;
                    $user->save();
                }
            }
        ]

    ],

    'params' => $params,

];
