<?php

/* @var $this \yii\web\View */
/* @var $content string */

/* main app layout */

use backend\assets\ServalAsset;
use yii\helpers\Html;
use backend\components\menu\widget\ServalMenu;
use backend\components\dropdown\widget\UserDropDown;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;
use common\widgets\Alert;

ServalAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <?php
    $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => '/favicons/favicon.ico']);
    $this->registerLinkTag(['rel' => 'icon', 'sizes' => '32x32', 'href' => '/favicons/favicon-32x32.png']);
    $this->registerLinkTag(['rel' => 'icon', 'sizes' => '48x48', 'href' => '/favicons/favicon-48x48.png']);
    $this->registerLinkTag(['rel' => 'icon', 'sizes' => '96x96', 'href' => '/favicons/favicon-96x96.png']);
    $this->registerLinkTag(['rel' => 'icon', 'sizes' => '144x144', 'href' => '/favicons/favicon-144x144.png']);
    ?>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="fixed page-width flex-container">
    <div class="logo-wrapper header-item">
        <a class="text-decoration-off" href="/">
            <img src="/img/serval-logo.png"
                 style="width: 42px; height: 42px; margin-top: -4px; margin-left: -12px; float: left;"/>
            <h1 style="font-size:33px; margin-top: 0px; font-family: 'UbuntuBold'">
                <span style="font-weight: 800; color: #F48024; letter-spacing: 5px;">SERVAL</span>
            </h1>
        </a>
    </div>
    <div class="flex-item header-item"></div>
    <div class="flex-item header-item"></div>
    <div class="user-menu-flex header-item">
        <?= UserDropDown::widget([
            'options' => [
                'id' => 'user-dropdown-menu-btn',
                'tag' => 'div',
                'label' => 'Hi, ' . Yii::$app->user->identity->name,
            ],
            'items' => [
                [
                    'url' => '/user/view?id=' . Yii::$app->user->identity->id,
                    'label' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;Profile',
                ],
                [
                    'url' => '/logout',
                    'label' => '<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;Logout',
                ]
            ]
        ]); ?>
    </div>
</header>

<nav>
    <?= ServalMenu::widget(); ?>
</nav>

<main class="page-width">
    <div class="content-wrapper">
        <?= Breadcrumbs::widget([
            'homeLink' => false,
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
    <div class="fake-footer"></div>
</main>
<footer>
    <?php
    $copyright_year = 2017;

    if (date('Y') > $copyright_year) {
        $copyright_year .= '-' . date('Y');
    }
    ?>
    <div class="foter-content">
        Copyright &copy; <?= $copyright_year ?> <a class="link-copyright" href="http://google.com" target="_blank"
                                                   title="Google">Serval</a>. All rights reserved.

        <?= \lajax\languagepicker\widgets\LanguagePicker::widget([
            'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
            'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
        ]); ?>

    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
