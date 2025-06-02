<?php

use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseJson;
use yii\helpers\Html;


//use iutbay\yii2fontawesome\FontAwesome as FA;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Lokasi UMKM';
//$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/js/leaflet-0.7.3/leaflet.min.css"/>
<style>
    #left_box {
        height: 700px;
        width: 100%;
        border: thin solid black
    }

    #left_box:hover {
        border: 1px solid #003eff
    }

    #left_box_inner {
        margin: 5px 5px 5px
    }

    #map {
        margin: 0px 0px 10px;
        width: 100%;
        height: 630px
    }
</style>

<div class="user-map">

    <h1><?= Html::encode($this->title) ?></h1>


    <div id='left_box'>
        <div id='left_box_inner'>
            <div id='map'></div>
            <?php
            $data = ArrayHelper::map(app\models\Kecamatan::find()->all(), 'id', 'nama_kecamatan');
            echo Select2::widget([
                'id' => 'visible_kec',
                'name' => 'kecamatan',
                'data' => array_merge(['0' => 'Semua'], $data),
                'language' => 'en',
                'options' => ['multiple' => false],
                'addon' => [
                    'prepend' => [
                        'content' => Html::label('Pilih Kecamatan : ')
                    ]],
            ])
            ?>
        </div>
    </div>
    <br/>
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

        var lg_kec = new Array(23);
        for (var i = 1; i < lg_kec.length; i++) {
            lg_kec[i] = new L.LayerGroup();
        }
        var umkm = <?=BaseJson::encode($items);?>;
        for (var i = 0; i < umkm.length; i++) {
            L.marker([umkm[i].lat, umkm[i].long]).bindPopup("<h4><a href='view?id=" + umkm[i].id + "'>" + umkm[i].fullname + "</a></h4>").addTo(lg_kec[umkm[i].id_kecamatan]);
        }
        for (var i = 1; i < lg_kec.length; i++) {
            lg_kec[i].addTo(map);
        }

        L.control.layers(baseLayers).addTo(map);

        var visible_kec = document.getElementById("visible_kec");
        visible_kec.onchange = function () {
            for (var i = 1; i < lg_kec.length; i++) {
                map.removeLayer(lg_kec[i]);
            }
            if (parseInt(visible_kec.value) === 0) {
                for (var i = 1; i < lg_kec.length; i++) {
                    lg_kec[i].addTo(map);
                }
            } else {
                lg_kec[visible_kec.value].addTo(map);
            }
        };
    };
</script>