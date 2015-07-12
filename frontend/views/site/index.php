<?php

use yii\helpers\Url;
use common\models\Page;
?>

<?php
Page::switchToUrlLocale();
?>

<?php require_once Yii::getAlias('@webroot/js/app/templates/app.html') ?>

<?php

$js = 'app.config = ' . json_encode(Yii::$app->keyStorage->getAllArray()) . ';'
    . 'app.config.frontend_app_debug = "' . YII_DEBUG . '";'
    . 'app.config.frontend_app_web_url = "' . Yii::getAlias('@web') . '";'
    . 'app.config.frontend_app_frontend_url = "' . Yii::getAlias('@frontendUrl') . '";'
    . 'app.config.frontend_app_locale = "' . Yii::$app->language . '";'    
    . 'app.config.frontend_app_facebook_app_id = "' . getenv('FACEBOOK_APP_ID') . '";'
    . 'app.config.frontend_app_site_type = "' . Yii::getAlias('@siteType') . '";'
    . 'app.config.frontend_app_api_url = "' . Yii::getAlias('@apiUrl') . '";';


$this->registerJs($js, \yii\web\View::POS_END);

//yii\helpers\VarDumper::dump(common\models\Page::getMetaTags(), 11, 1); die();

foreach (Page::getMetaTags() as $tag) {
    $this->registerMetaTag($tag);
}

\frontend\assets\AppAsset::register($this);
?>

