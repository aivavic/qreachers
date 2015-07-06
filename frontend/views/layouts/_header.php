<?php

use yii\helpers\Url;
use common\models\Page;

$shortLocale = explode('-',Yii::$app->language)[0];
?>

<nav>
    <section class = "nav-logo">
        <a href = "<?= Url::to('/' . $shortLocale . '/page/view/home'); ?>" class=""><img src="<?= Url::to('@web/img/header-logo.png'); ?>"></a>
    </section>

    <?php require_once '_topMenu.php'; ?>

    <section class = "lang-box hidden-xs">
        <a href = "<?= Url::to(['/site/set-locale','locale'=>'ru-RU']); ?>" class = "lang-item <?= ('ru-RU' == Yii::$app->language)? 'lang-active':''; ?>"><?= Yii::t('frontend','Rus'); ?></a>        
        <a href = "<?= Url::to(['/site/set-locale','locale'=>'en-US']); ?>" class = "lang-item <?= ('en-US' == Yii::$app->language)? 'lang-active':''; ?>" style="display:none;"><?= Yii::t('frontend','Eng'); ?></a>
        <a href = "<?= Url::to(['/site/set-locale','locale'=>'uk-UA']); ?>" class = "lang-item <?= ('uk-UA' == Yii::$app->language)? 'lang-active':''; ?>" style="display:none;"><?= Yii::t('frontend','Ukr'); ?></a>
    </section>

    <div class="nav-drop visible-xs">
        <button class="burger cmn-toggle-switch cmn-toggle-switch__htla">
            <span></span>
        </button>
        <section class="dropdown">
            <div class="drop-wrap">
                <a href = "<?= Url::to('/' . $shortLocale . '/page/view/home'); ?>" class = "nav-item nav-active ajaxLink"><?= Yii::t('frontend', 'Home'); ?></a>
                <a href = "<?= Url::to('/' . $shortLocale . '/page/view/about'); ?>" class = "nav-item ajaxLink"><?= Yii::t('frontend', 'About'); ?></a>
                <a href = "<?= Url::to('/' . $shortLocale . '/page/view/portfolio'); ?>" class = "nav-item ajaxLink"><?= Yii::t('frontend', 'Portfolio'); ?></a>
                <a href = "<?= Url::to('/' . $shortLocale . '/page/view/news'); ?>" class = "nav-item ajaxLink"><?= Yii::t('frontend', 'News'); ?></a>
                <a href = "<?= Url::to('/' . $shortLocale . '/page/view/contact'); ?>" class = "nav-item ajaxLink"><?= Yii::t('frontend', 'Contact'); ?></a>
            </div>
            <section class="lang-box">
                <a href = "<?= Url::to(['/site/set-locale','locale'=>'ru-RU']); ?>" class = "lang-item <?= ('ru-RU' == Yii::$app->language)? 'lang-active':''; ?>"><?= Yii::t('frontend','Rus'); ?></a>
                <a style="display: none" href = "<?= Url::to(['/site/set-locale','locale'=>'uk-UA']); ?>" class = "lang-item <?= ('uk-UA' == Yii::$app->language)? 'lang-active':''; ?>"><?= Yii::t('frontend','Ukr'); ?></a>
                <a style="display:none;"href = "<?= Url::to(['/site/set-locale','locale'=>'en-US']); ?>" class = "lang-item <?= ('en-US' == Yii::$app->language)? 'lang-active':''; ?>"><?= Yii::t('frontend','Eng'); ?></a>
            </section>
        </section>
    </div>
    <div class = "clearfix"></div>
</nav>
<script>
    
</script>