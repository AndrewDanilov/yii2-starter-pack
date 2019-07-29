<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\models\Organization;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Spaceless;
use andrewdanilov\SiteYears\SiteYears;
use andrewdanilov\yandexmetrika\YandexMetrika;
use frontend\assets\AppAsset;
use frontend\widgets\LocalitySelect;
use frontend\widgets\LocalitySelectForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta content="<?= Html::encode($this->title) ?>" property="og:title" />
	<meta content="width=device-width, initial-scale=1" name="viewport" />

	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.4.7/webfont.js" type="text/javascript"></script>
	<script type="text/javascript">WebFont.load({google: {families: ["Fira Sans:300,300italic,regular,italic,500,500italic:latin,cyrillic", "Fira Sans Condensed:300,regular,500:latin,cyrillic"]}});</script>
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js" type="text/javascript"></script>
	<![endif]-->
	<script type="text/javascript">!function (o, c) {
			var n = c.documentElement, t = " w-mod-";
			n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n.className += t + "touch")
		}(window, document);</script>

	<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />

	<meta charset="<?= Yii::$app->charset ?>">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<?php $this->head() ?>
</head>
<body class="body">
<?php $this->beginBody() ?>
<?php Spaceless::begin() ?>

<div class="section-top">
	<div class="container w-clearfix">
		<a href="<?= Url::to(['/']) ?>" class="logo w-nav-brand">
			<img src="<?= Yii::$app->params['site.logo'] ?>" alt="" class="logo-image">
		</a>
		<div data-collapse="none" data-animation="default" data-duration="400" class="nav-user-menu w-nav">
			<nav role="navigation" class="w-nav-menu">
				<div class="top-menu-item">
					<div class="top-icon"><i class="fa fa-map-marker-alt"></i></div>
					<?= LocalitySelect::widget() ?>
				</div>
				<div class="top-menu-item">
					<div class="top-icon"><i class="fa fa-user"></i></div>
					<?php if (Yii::$app->user->isGuest) { ?>
						<a href="<?= Url::to(['/user/login']) ?>" class="top-menu-item-link">Войти</a>
						<div class="top-menu-item-text">/</div>
						<a href="<?= Url::to(['/user/register']) ?>" class="top-menu-item-link">Регистрация</a>
					<?php } else { ?>
						<a href="<?= Url::to(['/user/profile']) ?>" class="top-menu-item-link">Личный кабинет</a>
					<?php } ?>
				</div>
				<div class="top-menu-item">
					<?php if (Organization::hasUserOrganization()) { ?>
						<div class="top-icon"><i class="fa fa-pen"></i></div>
						<a href="<?= Url::to(['/organization/info']) ?>" class="top-menu-item-link">Моя организация</a>
					<?php } else { ?>
						<div class="top-icon"><i class="fa fa-plus"></i></div>
						<a href="<?= Url::to(['/organization/edit']) ?>" class="top-menu-item-link">Добавить организацию</a>
					<?php } ?>
				</div>
			</nav>
		</div>
	</div>
</div>
<div class="section-menu">
	<div class="container">
		<div data-collapse="medium" data-animation="default" data-duration="400" class="nav-main-menu w-nav">
			<nav role="navigation" class="main-menu-wrapper w-nav-menu">
				<a href="<?= Url::to(['/']) ?>" class="main-menu-link w-nav-link">Главная</a>
				<div data-hover="1" data-delay="0" class="w-dropdown">
					<div class="main-menu-link dropdown w-dropdown-toggle">
						<div><?= Yii::$app->params['menu.catalogLabel'] ?></div>
						<div class="dropdown-icon main"></div>
					</div>
					<nav class="main-menu-dropdown-list w-dropdown-list">
						<?php foreach ($this->params['parent_categories_list'] as $parent_item) { ?>
							<div data-hover="1" data-delay="0" class="main-submenu-dropdown w-dropdown">
								<div class="main-menu-sublink dropdown w-dropdown-toggle">
									<div><?= $parent_item['name'] ?></div>
									<div class="dropdown-icon"></div>
								</div>
								<nav class="main-menu-dropdown-sublist w-dropdown-list">
									<?php foreach ($parent_item['items'] as $item) { ?>
										<a href="<?= Url::to(['/catalog/index', 'category' => $item['alias']]) ?>" class="main-menu-sublink w-dropdown-link"><?= $item['name'] ?></a>
									<?php } ?>
								</nav>
							</div>
						<?php } ?>
					</nav>
				</div>
				<a href="<?= Url::to(['/custompages/default/category', 'id' => 1]) ?>" class="main-menu-link w-nav-link">Полезные статьи</a>
				<a href="<?= Url::to(['/site/partners']) ?>" class="main-menu-link w-nav-link">Сотрудничество</a>
			</nav>
			<div class="w-nav-button">
				<div class="icon w-icon-nav-menu"></div>
			</div>
		</div>
	</div>
</div>

<?= $content; ?>

<div class="section-footer">
	<div class="container w-clearfix">
		<div class="copyright">Все права защищены © <?= SiteYears::widget(['startYear' => 2017]) ?> <?= Yii::$app->params['siteName'] ?></div>
		<div data-collapse="none" data-animation="default" data-duration="400" class="nav-footer w-nav">
			<div class="w-container">
				<nav role="navigation" class="nav-footer-menu w-nav-menu">
					<!--a href="<?= Url::to(['/site/help']) ?>" class="nav-footer-link w-nav-link">Помощь</a-->
					<a href="<?= Url::to(['/site/policy']) ?>" class="nav-footer-link w-nav-link">Политика конфиденциальности</a>
					<a href="<?= Url::to(['/site/partners']) ?>" class="nav-footer-link w-nav-link">Сотрудничество</a>
				</nav>
			</div>
		</div>
	</div>
</div>
<div class="hidden">
	<div id="locality-select-modal" class="container">
		<?= LocalitySelectForm::widget() ?>
	</div>
</div>

<!--[if lte IE 9]>
<script src="//cdnjs.cloudflare.com/ajax/libs/placeholders/3.0.2/placeholders.min.js"></script><![endif]-->

<?= YandexMetrika::widget(['id' => 54466267]) ?>

<?php Spaceless::end(); ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
