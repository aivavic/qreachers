<?php

use common\widgets\DbText;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
?>

<footer style="display:none;">
    <div class="wrapper">
        <?= DbText::widget(['key' => 'frontend.layout.footer.contacts.' . Yii::$app->language]); ?>
        <?php require_once '_bottomMenu.php'; ?>
    </div>
</footer>

<div class="loader"><img src="/img/big-left-hover.png"><img src="/img/big-right-hover.png"><img src="/img/fb-hover.png"><img src="/img/youtube-hover.png"><img src="/img/vimeo-hover.png"><img src="/img/watch-hover.png"></div>