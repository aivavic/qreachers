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
		
			var ng_userAgent=navigator.userAgent,
				ng_appVersion=parseInt(navigator.appVersion),
				ng_platform=navigator.platform;
				
			/*alert(ng_userAgent);
			alert(ng_appVersion);
			alert(ng_platform);*/
		
			/*if((ng_platform.indexOf('Win')>-1&&ng_userAgent.indexOf('Safari')>-1)||
				(ng_userAgent.indexOf('Safari')>-1&&ng_appVersion<8)||
				(ng_userAgent.indexOf('OPR')>-1&&ng_appVersion<25)||
				(ng_userAgent.indexOf('Firefox')>-1&&ng_appVersion<25)||
				(ng_userAgent.indexOf('MSIE')>-1&&ng_appVersion<11))
				location.href="/page/newbrowser.html";*/
				
			console.log(ng_userAgent);
			console.log(ng_appVersion);
			console.log(ng_platform);
			
			/*if(!Modernizr.cssanimations||!Modernizr.backgroundsize||!Modernizr.boxsizing||!Modernizr.csstransforms||!Modernizr.csstransitions){
				location.href="/page/newbrowser.html";
			}*/

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
