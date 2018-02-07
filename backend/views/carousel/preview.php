<?php

$this->title = Yii::t('carousel', 'Slider Preview');

?>

<div class="carousel-preview" style="width: 1125px; margin: auto;">

    <div class="page-title-wrapper">
        <h1><?= $this->title ?></h1>
    </div>

    <?php if(count($carousel_items) <= 0){ echo '<h3 class="red">SLIDER EMPTY</h3>'; return null;}?>

    <!-- Attention slider run without call  jQuery('#carousel').carousel(); // run bootstrap carousel !-->

    <div id="carousel" class="carousel slide" data-interval="7000" data-ride="carousel">

        <ol class="carousel-indicators">

            <?php for ($i = 0; $i < count($carousel_items); $i++) { ?>

                <li data-target="#carousel" data-slide-to="<?= $i ?>" class="<?= ($i == 0) ? 'active' : ''; ?>"></li>

            <?php } ?>

        </ol>

        <div class="carousel-inner">

            <?php foreach ($carousel_items as $index => $carousel_item) { ?>

                <div class="item <?= ($index == 0) ? 'active' : ''; ?> ">
                    <img width="1125" height="600" src="<?= $carousel_item->getImageUrl() ?>"
                         class="attachment-full size-full wp-post-image" alt="">
                    <div class="carousel-caption">
                        <h4><?= $carousel_item->title ?></h4>
                        <p><?= $carousel_item->description ?></p>
                    </div>
                </div>


            <?php } ?>

        </div>

        <a class="left carousel-control" href="#carousel" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="right carousel-control" href="#carousel" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>


</div>
