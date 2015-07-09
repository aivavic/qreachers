<?php

use yii\helpers\Url;
use common\models\Page;

$shortLocale = explode('-',Yii::$app->language)[0];
?>
	<nav class="top">

		<div class="container">

			<div class="row">

				<div class="col-lg-4 col-md-7 col-sm-8 col-xs-9">

							<div class="top__logo animated fadeInUp">
								<a href="<?= Url::to('/' . $shortLocale . '/page/view/home'); ?>"><span></span></a>
							</div><!--.top__logo-->

							<a href="#" class="top__logo-full"></a>
                                                        
							<div class="top__lang animated fadeInDownBig">
								<ul class="list-unstyled">
									<li class = "<?= ('ru-RU' == Yii::$app->language)? 'current':''; ?>"><a href="<?= Url::to(['/site/set-locale','locale'=>'ru-RU']); ?>" class = "lang-item"><?= Yii::t('frontend','Rus'); ?></a></li>
									<li class = "<?= ('en-US' == Yii::$app->language)? 'current':''; ?>"><a href="<?= Url::to(['/site/set-locale','locale'=>'en-US']); ?>" class = "lang-item"><?= Yii::t('frontend','Eng'); ?></a></li>
								</ul>
							</div><!--.top__lang-->

				</div>

				<div class="col-lg-1 col-lg-offset-7 col-md-1 col-md-offset-4 col-sm-2 col-sm-offset-0 col-xs-3">

					<div class="top__menu-btn top__menu-btn--default">
						<div class="top__menu-btn-txt"><?= Yii::t('frontend','Menu'); ?></div>
						<div class="top__menu-btn-sandwich">
							<div class="top__menu-btn-sandwich1"></div>
							<div class="top__menu-btn-sandwich2"></div>
							<div class="top__menu-btn-sandwich3"></div>
						</div>
						<div class="top__menu-btn-close"></div>
					</div><!--.top__menu-btn-->

				</div>

			</div>

		</div><!--.container-->

	</nav><!--.top-->
        
        <?php require_once '_topMenu.php'; ?>