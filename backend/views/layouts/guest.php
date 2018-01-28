<?php

/* layout for guest user ( use for display error for guest user) */


use backend\assets\ServalAsset;
use yii\helpers\Html;

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

    <?php $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => '/favicons/favicon.ico']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '32x32', 'href' => '/favicons/favicon-32x32.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '48x48', 'href' => '/favicons/favicon-48x48.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '96x96', 'href' => '/favicons/favicon-96x96.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '144x144', 'href' => '/favicons/favicon-144x144.png']); ?>

    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="fixed page-width flex-container" style="box-shadow: 0px 5px 13px 0px rgba(0,0,0,0.40);">
    <div class="logo-wrapper header-item">
        <h1 style="font-size:33px; margin-top: 0px; font-family: 'UbuntuBold'">
            <a class="text-decoration-off" href="/">
                <span style="font-weight: 800; color: #F48024; letter-spacing: 5px;">SERVAL</span>
            </a>
        </h1>
    </div>
    <div class="flex-item header-item"></div>
    <div class="flex-item header-item"></div>
    <div class="user-menu-flex header-item">
    </div>
</header>
<main style="padding-right:80px; padding-left: 80px;">
    <div class="content-wrapper">
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

        <?= Yii::$app->language?>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
