<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 8:16 PM
 */

namespace frontend\assets\jquery;

use yii\web\AssetBundle;

class UrlParamsAsset extends AssetBundle
{
    public $sourcePath = '@bower/tb.jquery.url-params';
    public $js = [
        'dist/jquery.url-params.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];
}
