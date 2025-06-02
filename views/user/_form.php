<?php

use app\models\Desa;
use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<link rel="stylesheet" href="<?= Yii::$app->request->baseUrl ?>/js/leaflet-0.7.3/leaflet.min.css"/>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => ['allowedFileExtensions' => ['jpg', 'gif', 'png'],
            'initialPreview' => [Html::img($model->getImageUrlThumbnail(), ['class' => 'file-preview-image', 'alt' => $model->avatar, 'title' => $model->avatar])],
            'showUpload' => false,
            'showCaption' => false,
            'showRemove' => false,
        ]]);
    ?>



    <?= $form->field($model, 'fullname')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'bio')->widget(TinyMce::className(), [
        'options' => ['rows' => 9],
        'clientOptions' => [
            'plugins' => ["textcolor link emoticons"],
            'menubar' => false,
            'statusbar' => false,
            'toolbar' => "undo redo | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | emoticons"
        ]
    ]); ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'id_desa')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Desa::find()->joinWith('idKecamatan')->where(['<', 'desa.id', 999])->all(), 'id', 'nama_desa', 'idKecamatan.nama_kecamatan'),
        'language' => 'en',
        'options' => ['placeholder' => 'Masukkan lokasi anda (desa/kelurahan)'],
    ])
    ?>

    <?= Html::activeHiddenInput($model, 'lat') ?>

    <?= Html::activeHiddenInput($model, 'long') ?>

    <b><i class="glyphicon-location"></i> Lokasi </b>(Klik pada peta untuk menandai lokasi baru, klik dan
    drag untuk memindah.)
    <div id='map'></div>
    </br> </br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-floppy"></i> Create' : '<i class="glyphicon glyphicon-floppy"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script src="<?= Yii::$app->request->baseUrl ?>/js/leaflet-0.7.3/leaflet.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/leaflet.ajax.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl ?>/js/Leaflet.Sleep.min.js"></script>

<style>
    #map {
        height: 400px
    }

    #map:hover {
        border: 1px solid #003eff
    }
</style>

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
        }).setView([-7.535613, 112.261291], 12);
        map.setMaxBounds([[-7.326583, 112.053238], [-7.786723, 112.460762]]); // Batas Wilayah Jombang

        var baseLayers = {"OSM Map": osmMap, "Landscape": Thunderforest_Landscape};

        L.control.layers(baseLayers).addTo(map);

        var myStyle = {color: 'green', opacity: 0.5, fillOpacity: 0.05, weight: 4, clickable: false};
        var jombang2 = new L.GeoJSON.AJAX("<?=Yii::$app->request->baseUrl?>/map/jombang.json", {style: myStyle});
        jombang2.addTo(map);

        var marker;

        function onMapClick(e) {
            $('#user-lat').attr('value', e.latlng.lat);   //set form value         
            $('#user-long').attr('value', e.latlng.lng);  //set form value          
            marker = new L.marker([e.latlng.lat, e.latlng.lng], {draggable: true}).addTo(map);
            marker.on('dragend', onMarkerDragend);
            map.off('click');
        }

        function onMarkerDragend(e) {
            $('#user-lat').attr('value', e.target._latlng.lat);
            $('#user-long').attr('value', e.target._latlng.lng);
            e.target.openPopup();
        }

        var hasLocation = (String(<?=$model->lat?>).length > 5);
        if (hasLocation) {
            marker = new L.marker([<?=$model->lat?>, <?=$model->long?>], {draggable: true}).bindPopup('<h4><?=$model->fullname?></h4></br><?=$model->address?>').addTo(map).openPopup()
                .on('dragend', onMarkerDragend);
        } else {
            map.on('click', onMapClick);
        }
    };
</script>
