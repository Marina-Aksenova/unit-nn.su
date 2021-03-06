<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'language' => 'ru',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\Module',
            'defaultRoute' => 'index',
        ],
        'cabinet' => [
            'class' => 'app\modules\cabinet\Module',
            'defaultRoute' => 'index',
        ],
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'mZ20cLY_N1WMmGtsypfeak5qM_HOzyW5',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'page/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'shop' => 'page/shop',
                'about' => 'page/about',
                'promo' => 'page/promo',
                'price' => 'page/price',
                'contact' => 'site/contact',
                'contacts' => 'page/contacts',
                'delivery' => 'page/delivery',
                'sale' => 'page/sale',
                'order' => 'site/order',
                'cabinet/history' => 'cabinet/index/history',
                'cabinet/personal' => 'cabinet/index/personal',

                // Module
                '<module:[a-zA-Z0-9-_]+>/<controller:[a-zA-Z-_]+>/<action:[a-zA-Z-_]+>/<id:\d+>' => '<module>/<controller>/<action>',

                // Controller
                '<controller:[a-zA-Z-_]+>/<action:[a-zA-Z-_]+>/<id:\d+>' => '<controller>/<action>',
            ],
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
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
