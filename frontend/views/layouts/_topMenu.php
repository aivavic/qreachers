<?php
use \yii\helpers\Url;

$shortLocale = explode('-',Yii::$app->language)[0];
?>
	<nav class="main_menu">

		<div class="main_menu__in">

			<div class="main_menu__wrap">

				<div class="main_menu__links animated">
					<ul class="list-unstyled">
						<li><a href="<?= Url::to('/' . $shortLocale . '/page/view/potfolio'); ?>" class = "ajaxLink"><?= Yii::t('frontend','Cases') ?></a></li>
						<li><a href="<?= Url::to('/' . $shortLocale . '/page/view/about'); ?>" class = "ajaxLink"><?= Yii::t('frontend','About') ?></a></li>
						<li><a href="<?= Url::to('/' . $shortLocale . '/page/view/services'); ?>" class = "ajaxLink"><?= Yii::t('frontend','Services') ?></a></li>
						<li><a href="<?= Url::to('/' . $shortLocale . '/page/view/clients'); ?>" class = "ajaxLink"><?= Yii::t('frontend','Clients') ?></a></li>
						<li><a href="<?= Url::to('/' . $shortLocale . '/page/view/news'); ?>" class = "ajaxLink"><?= Yii::t('frontend','Blog') ?></a></li>
						<li><a href="<?= Url::to('/' . $shortLocale . '/page/view/contact'); ?>" class = "ajaxLink"><?= Yii::t('frontend','Contact') ?></a></li>
					</ul>
				</div><!--.main_menu__links-->


				<div class="main_menu__socials socials-blue">
					<ul class="list-unstyled">
						<li class="fb animated"><a href="#">Facebook</a></li>
						<li class="sh animated"><a href="#">Slideshare</a></li>
						<li class="yt animated"><a href="#">Youtube</a></li>
						<li class="vm animated"><a href="#">Vimeo</a></li>
					</ul>
				</div><!--.main_menu__socials-->

			</div>

		</div><!--.main_menu__in-->

	</nav><!--.main_menu-->