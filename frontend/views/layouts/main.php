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
		
		<script type="text/javascript">
		
			var ng_userAgent=navigator.userAgent,
				ng_appVersion=parseInt(navigator.appVersion),
				ng_platform=navigator.platform,
				br_name=null,
				br_version=null;
			
			var ua= navigator.userAgent, tem, 
			M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
			if(/trident/i.test(M[1])){
				tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
				br_name='MSIE';
				br_version=parseInt(tem[1]);
				
				console.log(br_name, br_version);
			}
			else if(M[1]=== 'Chrome'){
				tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
				if(tem!= null){
					br_name=tem.slice(1)[0];
					br_version=parseInt(tem[2]);
				}
				else{
					br_name=M[1];
					br_version=parseInt(M[2]);
				}
				
				console.log(br_name, br_version);
			}
			else{
				M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
				if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
				
				br_name=M[0];
				br_version=parseInt(M[1]);
				
				console.log(br_name, br_version);
			}
			
			
			if( (br_name=='Safari'&&br_version<8)||
				((br_name=='OPR'||br_name=='Opera')&&br_version<25)||
				(br_name=='Firefox'&&br_version<25)||
				(br_name=='MSIE'&&br_version<11)){
				location.href="/page/newbrowser.html";
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
