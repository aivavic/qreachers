<?php

namespace backend\assets;
use yii\web\AssetBundle;

class CustomImperaviRedactorPluginAsset extends AssetBundle
{
    public $baseUrl = '@backendUrl/js/imperavi/plugins';
    public $js = [
        'blocklist/blocklist.js'
    ];
    public $css = [
        'blocklist/styles.css'
    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];
}