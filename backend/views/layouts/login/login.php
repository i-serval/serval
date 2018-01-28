<?php

/* @var $this \yii\web\View */
/* @var $content string */

/* layout used only for login page */

use backend\assets\LoginAsset;
use yii\helpers\Html;

LoginAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php $this->registerLinkTag(['rel' => 'shortcut icon', 'type' => 'image/x-icon', 'href' => '/favicons/favicon.ico']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '32x32', 'href' => '/favicons/favicon-32x32.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '48x48', 'href' => '/favicons/favicon-48x48.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '96x96', 'href' => '/favicons/favicon-96x96.png']); ?>
    <?php $this->registerLinkTag(['rel' => 'icon', 'sizes' => '144x144', 'href' => '/favicons/favicon-144x144.png']); ?>

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>z
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
