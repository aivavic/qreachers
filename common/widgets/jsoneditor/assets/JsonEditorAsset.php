<?php
/**
 * Created by PhpStorm.
 * User: zein
 * Date: 7/3/14
 * Time: 3:14 PM
 */

namespace common\widgets\jsoneditor\assets;

use yii\web\AssetBundle;

class JsonEditorAsset extends AssetBundle
{
    public $sourcePath = '@bower/json-editor/dist';
    public $js = [
        //'jsoneditor.min.js'
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
        'common\widgets\jsoneditor\assets\SCEditorAsset',
        'common\widgets\jsoneditor\assets\Select2Asset',
        'common\widgets\jsoneditor\assets\MagnificPopupAsset'

    ];
}
