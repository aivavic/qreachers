<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error" hidden>

    <h1><?php echo Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?php echo nl2br(Html::encode($message)) ?>
    </div>

    <p>
        The above error occurred while the Web server was processing your request.
    </p>
    <p>
        Please contact us if you think this is a server error. Thank you.
    </p>

</div>


<section class="page404">

    <p>Ой ... Тут ничего нет и небыло.</p>

    <a href="/" class="btn btn-back animated">НА ГЛАВНУЮ</a>

</section>

<footer class="footer">
    <div class="container">

        <div class="row">

            <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">

                <div class="footer__copy">
                    <p>QREACHERS. 2015. В качестве продолжения предыдущей статьи о мировых тенденциях в использовании мобильной рекламы</p>
                </div>

            </div>

            <div class="col-lg-2 col-lg-offset-3 col-md-3 col-md-offset-2 col-sm-4 col-sm-offset-1 col-xs-4 col-xs-offset-0">

                <div class="footer__logo">
                    <a href="/"><img src="/img/logo-gp.jpg" alt="#"></a>
                </div>

            </div>

        </div>

    </div><!--.container-->
</footer>
