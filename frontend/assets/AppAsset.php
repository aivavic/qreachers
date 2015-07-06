<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $js       = [
        'js/app/lib/app.js',
        'js/app/lib/logger.js',
        'js/app/lib/router.js',
        'js/app/lib/view.js',
        'js/app/lib/template.loader.js',
        'js/app/lib/app.js',
        'js/app/index.js',
    ];
    public $depends = [
        'frontend\assets\CommonAsset',
        'frontend\assets\FrontendAsset',
        'frontend\assets\HandlebarsAsset',        
        'frontend\assets\jquery\UrlParamsAsset'
    ];

}