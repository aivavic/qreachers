<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $message string */
/* @var $exception Exception */
?>


<h1> <?php echo nl2br(Html::encode($message)); ?> </h1>

<script>
    setTimeout(function() {
        window.close();
    },2000);
</script>


