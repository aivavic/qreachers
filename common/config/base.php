<?php
$config  = [
    'name'           => '16on9',
    'vendorPath'     => dirname(dirname(__DIR__)) . '/vendor',
    'extensions'     => require(__DIR__ . '/../../vendor/yiisoft/extensions.php'),
    'sourceLanguage' => 'en-US',
    'language'       => 'ru-RU',
    'bootstrap'      => ['log'],
    'components'     => [

        'authManager' => [
            'class'           => 'yii\rbac\DbManager',
            'itemTable'       => '{{%rbac_auth_item}}',
            'itemChildTable'  => '{{%rbac_auth_item_child}}',
            'assignmentTable' => '{{%rbac_auth_assignment}}',
            'ruleTable'       => '{{%rbac_auth_rule}}'
        ],
        'cache' => [
            'class' => 'yii\caching\DummyCache',
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter'
        ],
        'glide' => [
            'class'        => 'trntv\glide\components\Glide',
            'sourcePath'   => '@storage/web/source',
            'cachePath'    => '@storage/cache',
            'urlManager'   => 'urlManagerStorage',
            'maxImageSize' => getenv('GLIDE_MAX_IMAGE_SIZE'),
            'signKey'      => getenv('GLIDE_SIGN_KEY')
        ],
        'mailer' => [
            'class'            => 'yii\swiftmailer\Mailer',
            'useFileTransport' => YII_ENV_DEV,
            'messageConfig'    => [
                'charset' => 'UTF-8',
                'from'    => getenv('ADMIN_EMAIL')
            ]
        ],
        'db' => [
            'class'             => 'yii\db\Connection',
            'dsn'               => getenv('DB_DSN'),
            'username'          => getenv('DB_USERNAME'),
            'password'          => getenv('DB_PASSWORD'),
            'tablePrefix'       => getenv('DB_TABLE_PREFIX'),
            'charset'           => 'utf8',
            'enableSchemaCache' => YII_ENV_PROD,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                'db'       => [
                    'class'  => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'except' => ['yii\web\HttpException:*', 'yii\i18n\I18N\*'],
                    'prefix' => function () {
                    $url = !Yii::$app->request->isConsoleRequest ? Yii::$app->request->getUrl()
                            : null;
                    return sprintf('[%s][%s]', Yii::$app->id, $url);
                },
                    'logVars'  => [],
                    'logTable' => '{{%system_log}}'
                ]
            ],
        ],
        'i18n' => [
            'translations' => [
                'app' => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
                '*'   => [
                    'class'    => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'fileMap'  => [
                        'common'   => 'common.php',
                        'backend'  => 'backend.php',
                        'frontend' => 'frontend.php',
                    ]
                ],
                // Uncomment this code to use DbMessageSource
                '*'   => [
                    'class'              => 'yii\i18n\DbMessageSource',
                    'sourceMessageTable' => '{{%i18n_source_message}}',
                    'messageTable'       => '{{%i18n_message}}',
                    'enableCaching'      => YII_ENV_DEV,
                    'cachingDuration'    => 3600
                ],
            ],
        ],
        'fileStorage' => [
            'class'      => '\trntv\filekit\Storage',
            'baseUrl'    => '@storageUrl/source',
            'filesystem' => [
                'class' => 'common\components\filesystem\LocalFlysystemBuilder',
                'path'  => '@storage/web/source'
            ],
            'as log'     => [
                'class'     => 'common\behaviors\FileStorageLogBehavior',
                'component' => 'fileStorage'
            ]
        ],
        'keyStorage' => [
            'class' => 'common\components\keyStorage\KeyStorage'
        ],
        'urlManagerBackend'  => \yii\helpers\ArrayHelper::merge(
            [
            'hostInfo' => Yii::getAlias('@backendUrl')
            ], require(Yii::getAlias('@backend/config/_urlManager.php'))
        ),
        'urlManagerFrontend' => \yii\helpers\ArrayHelper::merge(
            [
            'hostInfo' => Yii::getAlias('@frontendUrl')
            ], require(Yii::getAlias('@frontend/config/_urlManager.php'))
        ),
        'urlManagerStorage'  => \yii\helpers\ArrayHelper::merge(
            [
            'hostInfo' => Yii::getAlias('@storageUrl')
            ], require(Yii::getAlias('@storage/config/_urlManager.php'))
        ),
        'urlManagerApi'  => \yii\helpers\ArrayHelper::merge(
            [
            'hostInfo' => Yii::getAlias('@apiUrl')
            ], require(Yii::getAlias('@api/config/_urlManager.php'))
        )
    ],
    'params' => [
        'adminEmail'         => getenv('ADMIN_EMAIL'),
        'robotEmail'         => getenv('ROBOT_EMAIL'),
        'googleApiServerKey' => getenv('GOOGLE_API_SERVER_KEY'),
        'availableLocales'   => [
            'ru-RU' => 'Русский (РФ)',
            'en-US' => 'English (US)',
        //'uk-UA'=>'Українська (Україна)',
        //'es' => 'Español'
        ],
    ],
];

if (YII_ENV_PROD) {
    $config['components']['cache'] = [
        'class'     => 'yii\caching\FileCache',
        'cachePath' => '@common/runtime/cache'
    ];

    $config['components']['log']['targets']['email'] = [
        'class'   => 'yii\log\EmailTarget',
        'except'  => ['yii\web\HttpException:*'],
        'levels'  => ['error', 'warning'],
        'message' => ['from' => getenv('ROBOT_EMAIL'), 'to' => getenv('ADMIN_EMAIL')]
    ];
}

if (YII_ENV_DEV) {
    $config['bootstrap'][]    = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module'
    ];
}

return $config;
