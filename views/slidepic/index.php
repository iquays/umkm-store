<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Gambar Slideshow';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slidepic-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Tambah Gambar Slideshow', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'hover' => true,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->id];
        },        
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'filename',
            'title',
            'short_description',
            'picture',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php
        $this->registerJs("
            $('td').click(function (e) {
                var id = $(this).closest('tr').data('id');
                if(e.target == this)
                    location.href = 'update?id=' + id;
            });
        "); 
    ?>
    
</div>
