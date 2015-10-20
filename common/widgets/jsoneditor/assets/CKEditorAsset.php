<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace common\widgets\jsoneditor\assets;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
    public $baseUrl = '@backendUrl/js/';

    public $js = [
        '//cdn.ckeditor.com/4.5.4/standard/ckeditor.js',
        'ckeditor.sample.init.js'

    ];
    public $css = [
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}