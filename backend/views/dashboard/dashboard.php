<?php

//    use scotthuangzl\googlechart\GoogleChart;
    use yii\helpers\Html;

    $this->title = 'Dashboard';

?>

<div class="page-title-wrapper">
    <h1><?=$this->title?></h1>
</div>

<?php /*
<div class="col-sm-12">

    <div class="col-md-6">

        <?=GoogleChart::widget( [
                'visualization' => 'AreaChart',
                'data' => $traffic_statistic->getViewsAmount(),
                'options' => [
                    'title' => 'Page views',
                    //'titleTextStyle' => ['color' => '#FF0000'],
                    'vAxis' => [
                        'title' => 'Users Count',
                        'gridlines' => [
                            'color' => 'blue'  //set grid line transparent
                        ]],
                    'hAxis' => ['title' => 'Days'],
                    'curveType' => 'function', //smooth curve or not
                    'legend' => ['position' => 'right'],
                    'height' => 300,
                ]
        ]);?>

    </div>

    <div class="col-md-6">

        <?=GoogleChart::widget([
                'visualization' => 'PieChart',
                'data' => $traffic_statistic->getPagesTrafic(),
                'options' => [
                    'title' => 'Tapal pages popularity',
                    'width' => 600,
                    'height' => 300,
                ]
            ]);

        ?>

    </div>

    <div class="col-md-6">

        <?=GoogleChart::widget( [
                'visualization' => 'AreaChart',

                'data' => $traffic_statistic->getUniqueViewsAmount(),

                'options' => [
                    'title' => 'Page Unique Views',
                    //'titleTextStyle' => ['color' => '#FF0000'],
                    'vAxis' => [
                        'title' => 'Users',
                        'gridlines' => [
                            'color' => 'blue'  //set grid line transparent
                        ]],
                    'series' => [
                        ['color' => 'red']
                    ],
                    'hAxis' => ['title' => 'Days'],
                    'curveType' => 'function', //smooth curve or not
                    'legend' => ['position' => 'right'],
                    'height' => 300,
                ]
        ]);?>

    </div>

    <div class="col-md-6" style="padding-top: 63px; padding-left: 165px">

        <?=GoogleChart::widget( [
                'visualization' => 'Gauge', 'packages' => 'gauge',
                'data' => [
                    ['Label', 'Value'],
                    ['Memory', $traffic_statistic->getMemoryUsage()],
                    ['CPU', $traffic_statistic->getCpuUsage()],
                    //array('Network', 68),
                ],
                'options' =>[
                    'width' => 350,
                    'height' => 350,
                    'redFrom' => 90,
                    'redTo' => 100,
                    'yellowFrom' => 80,
                    'yellowTo' => 90,
                    'minorTicks' => 5
                ]
            ]
        );?>

    </div>

</div>

<div style="clear: both;"></div>

<div style="margin-top: 15px; padding-left: 59px;">
    <?=Html::a('UPDATE DATA', ['/?update=true'], [ 'class' => 'btn btn-success btn-default' ])?>
</div>
 */
 ?>
