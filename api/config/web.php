<?php
$config = [
    'homeUrl'             => Yii::getAlias('@apiUrl'),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute'        => 'sitemap/default/index',
    'layout'              => false,
    'modules'             => require(__DIR__ . '/_modules.php'),
    'components'          => [
        /* 'errorHandler' => [
          'errorAction' => 'site/error'
          ], */
        'request' => [
            'cookieValidationKey' => getenv('API_COOKIE_VALIDATION_KEY')
        ],
        'user'    => [
            'class'         => 'yii\web\User',
            'identityClass' => 'api\models\ApiUserIdentity',
        ]
    ],
    'as corsFilter'       => [
        'class' => \yii\filters\Cors::className(),
        'cors'  => [
            // allow access to
            'Origin' => array_merge([Yii::getAlias('@frontendUrl')] ,explode(',', Yii::getAlias('@frontendUrls')) ),
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class'      => 'yii\gii\Module',
        'generators' => [
            'crud' => [
                'class'           => 'yii\gii\generators\crud\Generator',
                'messageCategory' => 'api'
            ]
        ]
    ];
}

if (YII_ENV_PROD) {
    // Maintenance mode
    $config['bootstrap']                 = ['maintenance'];
    $config['components']['maintenance'] = [
        'class'   => 'common\components\maintenance\Maintenance',
        'enabled' => function ($app) {
            return $app->keyStorage->get('api_maintenance') === 'true';
        }
    ];
}

return $config;
