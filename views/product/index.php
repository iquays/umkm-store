<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Produk';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
            if (!(Yii::$app->user->identity->role == 'admin')) {
                echo Html::a('Tambah Iklan Produk', ['create'], ['class' => 'btn btn-success']);
            }
        ?>
    </p>

    <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'export' => false,
            'hover' => true,
            'rowOptions' => function ($model, $key, $index, $grid) {
                return ['data-id' => $model->id];
            },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

    //            'id',
                'product_code',
                'product_name',
                'price',
                'stock',
    //            'category_id',
                // 'description',
                // 'user_id',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end() ?>
    
    <?php
        $this->registerJs("
            $('td').click(function (e) {
                var id = $(this).closest('tr').data('id');
                if(e.target == this)
                    location.href = 'view?id=' + id;
            });
        "); 
    ?>

</div>
