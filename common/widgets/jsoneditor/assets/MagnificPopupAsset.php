<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace common\widgets\jsoneditor\assets;

use yii\web\AssetBundle;

class MagnificPopupAsset extends AssetBundle
{    
    public $baseUrl = '@backendUrl/js/magnific-popup';

    public $js = [        
        'jquery.magnific-popup.min.js'
    ];

    public $css = [        
        'magnific-popup.css'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
