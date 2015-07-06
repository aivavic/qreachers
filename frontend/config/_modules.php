<?php
return [
    /*'user'    => [
        'class' => 'frontend\modules\user\Module'
    ],*/
    'sitemap' => require(__DIR__ . '/_sitemap.php'),
    'social'  => [
        // the module class
        'class'    => 'kartik\social\Module',
        // the global settings for the facebook plugins widget
        'facebook' => [
            'appId'  => 'FACEBOOK_APP_ID',
            'secret' => 'FACEBOOK_APP_SECRET',
        ],
        // the global settings for the twitter plugins widget
        'twitter'  => [
            'screenName' => 'TWITTER_SCREEN_NAME'
        ],
    ],
];
