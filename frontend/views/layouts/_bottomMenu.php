<?php

use \yii\helpers\Url;
use \common\models\Page;

$shortLocale = explode('-',Yii::$app->language)[0];
?>
<section class="footer-nav">
    <a href = "<?= Url::to('/' . $shortLocale . '/page/view/home'); ?>" class = "nav-item nav-active hidden-xs ajaxLink"><?= Yii::t('frontend', 'Home'); ?></a>
    <a href = "<?= Url::to('/' . $shortLocale . '/page/view/about' ); ?>" class = "nav-item nav-active hidden-xs ajaxLink"><?= Yii::t('frontend', 'About'); ?></a>
    <a href = "<?= Url::to('/' . $shortLocale . '/page/view/news' ); ?>" class = "nav-item nav-active hidden-xs ajaxLink"><?= Yii::t('frontend', 'News'); ?></a>
    <a href = "<?= Url::to('/' . $shortLocale . '/page/view/contact'); ?>" class = "nav-item nav-active hidden-xs ajaxLink"><?= Yii::t('frontend', 'Contact'); ?></a>
    <a href = "<?= Url::to('/' . $shortLocale . '/page/view/portfolio'); ?>" class = "nav-item nav-active hidden-xs ajaxLink"><?= Yii::t('frontend', 'Portfolio'); ?></a>
</section>
