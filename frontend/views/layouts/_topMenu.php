<?php
use \yii\helpers\Url;
use common\models\Page;

$shortLocale = explode('-',Yii::$app->language)[0];
?>

<a href = "<?= Url::to('/' . $shortLocale . '/page/view/home'); ?>" class = "nav-item nav-active hidden-xs ajaxLink"><?= Yii::t('frontend', 'Home'); ?></a>
<a href = "<?= Url::to('/' . $shortLocale . '/page/view/about'); ?>" class = "nav-item hidden-xs ajaxLink"><?= Yii::t('frontend', 'About'); ?></a>
<a href = "<?= Url::to('/' . $shortLocale . '/page/view/portfolio'); ?>" class = "nav-item hidden-xs ajaxLink"><?= Yii::t('frontend', 'Portfolio'); ?></a>
<a href = "<?= Url::to('/' . $shortLocale . '/page/view/news'); ?>" class = "nav-item hidden-xs ajaxLink"><?= Yii::t('frontend', 'News'); ?></a>
<a href = "<?= Url::to('/' . $shortLocale . '/page/view/contact'); ?>" class = "nav-item hidden-xs ajaxLink"><?= Yii::t('frontend', 'Contact'); ?></a>
    