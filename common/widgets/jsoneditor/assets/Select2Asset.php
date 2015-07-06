<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace common\widgets\jsoneditor\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{    
    public $js = [        
       '//cdn.jsdelivr.net/select2/3.4.8/select2.min.js'
    ];

    public $css = [
       '//cdn.jsdelivr.net/select2/3.4.8/select2.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
