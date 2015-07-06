<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this \yii\web\View */
/* @var $content string */
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

        <?php echo $content ?>

        <?php $this->endBody() ?>

    </body>
</html>
<?php $this->endPage() ?>
