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
