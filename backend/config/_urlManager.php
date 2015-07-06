<?php
return [
    'class'           => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName'  => false,
    'rules'           => [
        ['pattern' => 'frontend/web/<path:.+>', 'route' => 'site/redir'],        

    ]
];
