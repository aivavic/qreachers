<?php

use yii\helpers\ArrayHelper;
?>

<?php if (Yii::$app->session->hasFlash('alert')): ?>
    <?php
    echo \yii\bootstrap\Alert::widget([
        'body'    => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
        'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
    ])
    ?>
<?php endif; ?>