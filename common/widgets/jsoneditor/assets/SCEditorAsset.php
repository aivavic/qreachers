<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace common\widgets\jsoneditor\assets;

use yii\web\AssetBundle;

class SCEditorAsset extends AssetBundle
{    
    public $js = [        
        '//cdn.jsdelivr.net/sceditor/1.4.3/jquery.sceditor.bbcode.min.js',
        '//cdn.jsdelivr.net/sceditor/1.4.3/jquery.sceditor.xhtml.min.js'

    ];

    public $css = [
        //'//cdn.jsdelivr.net/sceditor/1.4.3/jquery.sceditor.default.min.css',
        //'//cdn.jsdelivr.net/sceditor/1.4.3/themes/default.min.css'
        '//cdn.jsdelivr.net/sceditor/1.4.3/themes/office.min.css',
        '//cdn.jsdelivr.net/sceditor/1.4.3/themes/office-toolbar.min.css'

    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
