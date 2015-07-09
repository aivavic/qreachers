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
class CommonAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';    

    public $js       = [
        /*'js/lib/jquery-ui.min.js',
        'js/lib/jquery.bxslider.min.js',
        'js/lib/preload.js',
        'js/lib/isotope.pkgd.min.js',
        'js/lib/imagesloaded.pkgd.min.js',
        'https://maps.googleapis.com/maps/api/js?v=3.exp',
        'js/lib/owl.carousel.min.js',
        'js/lib/facebook.sdk.js',
        'js/lib/twitter.widget.js',*/        
        'http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js',
        'js/js/jquery.html5Loader.min.js',
        'js/lib/preload.js',
        'bootstrap/js/bootstrap.min.js',
        'js/js/wow.min.js',
        'js/js/jquery.nav.js',
        'js/js/jquery.flexslider-min.js',
        'js/lib/jquery.bxslider.min.js', #old widget
        'js/js/jquery.validate.min.js',
        'js/js/additional-methods.min.js',
        'js/js/design.js',
        'js/lib/facebook.sdk.js',
        'js/lib/twitter.widget.js',
        'js/lib/isotope.pkgd.min.js',
        
        'js/common.js'
    ];
    public $depends = [
        'frontend\assets\FrontendAsset',
        'yii\web\JqueryAsset'
    ];

}