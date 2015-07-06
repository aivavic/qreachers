<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

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
        <title><?php echo Html::encode($this->title) ?></title>
        <link rel="icon" type="image/png" href="/img/ico.png">
        <?php $this->head() ?>
        <?php echo Html::csrfMetaTags() ?>        
    </head>
    <body>  
        <?php $this->beginBody() ?>        

        <div class="main-container" style="display:none;">

            <?php require_once '_header.php'; ?>

            <?php require_once '_commonPartMainContainer.php'; ?>

            <?php echo $content ?>
            
        </div>
        
        <?php require_once '_footer.php'; ?>

        <?php $this->endBody() ?>
  
        <?php require_once '_loader.php'; ?>
    </body>
</html>
<?php $this->endPage() ?>
