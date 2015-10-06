<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\JqueryAsset;
use yii\widgets\ActiveForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Session;
use yii\web\Response;

/* @var $this \yii\web\View */
/* @var $content string */

\frontend\assets\FrontendAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="fb:app_id" content="1671684663080056" />
        <title><?php echo Html::encode($this->title) ?></title>
        <link rel="icon" type="image/png" href="http://qreachers.com/favicon.ico">
		
		<script type="text/javascript" src="js/js/modernizr-custom.js"></script>
		<script type="text/javascript">
			if(!Modernizr.cssanimations||!Modernizr.backgroundsize||!Modernizr.boxsizing||!Modernizr.csstransforms||!Modernizr.csstransitions){
				location.href="/page/newbrowser.html";
				var body_obj=document.getElementsByTagName('html');
				body_obj.insertAdjacentHTML('<div class="deprecated-box"> 	<div class="align db-align"> 		<span class="icon icon-window"><img src="/img/deprecated/window.png" alt="" /></span> 		<div class="db-text"><span class="bold">Ваш браузер устарел.</span> Сайт будет работать некорректно<div class="br"></div>  Чтобы исправить проблему, пожалуйста, обновите браузер <br /> на более позднюю версию или воспользуйтесь другим браузером.</div> 		<hr /> 		<a class="icon icon-browser-wrap"><span class="icon-text">Chrome</span><span class="icon"><img src="/img/deprecated/br_chrome.png" alt="" /></span></a> 	</div> </div>  <style type="text/css">  .deprecated-box, .deprecated-box *{ -webkit-box-sizing:content-box; -moz-box-sizing:content-box; box-sizing:content-box;}  .deprecated-box{ position:absolute; left:0; top:0; width:100%; height:100%; background:#00567d; font:18px/30px "pantonregular", Arial, sans-serif; color:#fff;}  .db-align{ text-align:center; width:600px; position:absolute; left:50%; top:50%; margin:-202px 0 0 -300px;}  .bold{ color:#dfe039; font-family: "pantonbold";}  .icon{ display:inline-block;}  .icon-window{ margin-bottom:30px;}  hr{ display:block; width:66px; height:2px; margin: 36px auto 48px; background:#e0e139; border-width:2px 0; border-style:solid; border-color:#69975d;}  .icon-browser-wrap{ font:14px/20px "pantonregular"; text-decoration:none; color:#32c7fc;}  .icon-text{ display:inline-block;}  .icon-browser-wrap .icon-text{ display:block; margin-bottom:14px;}  .icon-browser-wrap:hover{ text-decoration:none; color:#fff;}  </style>            ');
			}

		</script>
		
        <?php $this->head() ?>
        <?php echo Html::csrfMetaTags() ?>        
    </head>
    <body>
        <div class="preloader animated">
            <div class="preloader__wrap">
                <div class="preloader__logo preloader__logo--spin animated"></div>
            </div>
            <div class="preloader__status animated"></div>
        </div>

        <?php $this->beginBody() ?>        

        <?php echo $content ?>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
