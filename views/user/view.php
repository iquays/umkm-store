<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

//use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->fullname;
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/js/leaflet-0.7.3/leaflet.min.css"/>

<style>
    #map {
        width: 100%;
        height: 630px
    }
</style>

<div class="user-view">

    <!--    <h1><?= Html::encode($this->title) ?></h1>-->


    <div class="jumbotron">
        <h1> <?= $model->fullname ?> </h1>
        <h2> <?= $model->bio ?> </h2>
    </div>
    <div class="row">
        <h2>Produk Kami: </h2>

        <?php Pjax::begin(); ?>
        <?php
        $ownedProducts = $dataProvider->models;
        foreach ($ownedProducts as $op) { ?>
            <div class="col-md-3 col-sm-6 col-xs-12" style="padding: 5px">
                <div class="product-grid">
                    <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $op['id'] ?>">
                        <?php
                        if (isset($op['productPictures'][0]['picture'])) {
                            echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . $op['id'] . '/' . $op['productPictures'][0]['picture'], ['alt' => $op['product_name'], 'class' => 'img-rounded product-grid-image']);
                        } else {
                            echo Html::img(Yii::$app->request->baseUrl . '/uploads/products/' . "empty_picture_thumbnail.jpg", ['alt' => 'Empty Picture', 'class' => 'img-rounded product-grid-image']);
                        }
                        ?>
                    </a>
                    <h4 style="text-align: center"><a
                            href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $op['id'] ?>"><?= $op['product_name'] ?></a>
                    </h4>
                    <p style="text-align: center"><?= $op['short_description'] ?></p>
                    <div style="text-align: center">
                        <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $op['id'] ?>"
                           class="btn btn-primary rupiah"><?= $op['price'] ?></a>
                        <a href="<?= Yii::$app->request->baseUrl . '/product/view?id=' . $op['id'] ?>"
                           class="btn btn-default">Stock: <?= $op['stock'] ?></a>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php Pjax::end(); ?>
    </div>
    <div class="row">
        <h2>Lokasi Kami:</h2>
        <div id="map">
        </div>
    </div>

</div>

<script src="<?= Yii::$app->request->baseUrl ?>/js/leaflet-0.7.3/leaflet.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/leaflet.ajax.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/Leaflet.Sleep.min.js"></script>

<script type="text/javascript">
    window.onload = function () {
        var osmMap = L.tileLayer('http://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 20
        });
        var Thunderforest_Landscape = L.tileLayer('http://{s}.tile.thunderforest.com/landscape/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://www.opencyclemap.org">OpenCycleMap</a>, &copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        var map = L.map('map', {
            layers: [osmMap],
            sleepTime: 750,
            wakeTime: 1500,
            sleepNote: false
        }).setView([-7.555613, 112.261291], 11);
        map.setMaxBounds([[-7.326583, 112.053238], [-7.786723, 112.460762]]); // Batas Wilayah Jombang

        var baseLayers = {"OSM Map": osmMap, "Landscape": Thunderforest_Landscape};

        var myStyle = {color: 'green', opacity: 0.5, fillOpacity: 0.05, weight: 4, clickable: false};
        var jombang = new L.GeoJSON.AJAX("<?=Yii::$app->request->baseUrl?>/map/jombang.geojson", {style: myStyle});
        jombang.addTo(map);


        L.control.layers(baseLayers).addTo(map);

        var hasLocation = (String(<?=$model->lat?>).length > 5);
        if (hasLocation) {
            marker = new L.marker([<?=$model->lat?>, <?=$model->long?>], {draggable: true}).bindPopup('<h4><?=$model->fullname?></h4></br><?=$model->address?>').addTo(map).openPopup();
        }

    };
</script>    