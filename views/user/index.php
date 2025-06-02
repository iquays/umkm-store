<?php

use yii\helpers\Html;
use yii\helpers\Url;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar UMKM (Users)';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Buat User', ['create'], ['class' => 'btn btn-success']) ?>
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
                'username',
    //            'auth_key',
    //            'password_hash',
    //            'password_reset_token',
                'email:email',
                'fullname',
                // 'status',
                // 'created_at',
                // 'updated_at',
                // 'website',
                // 'bio:ntext',
                // 'address',
                // 'desa',
                // 'lat',
                // 'long',
                // 'avatar',
                // 'filename',
                // 'role',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    <?php Pjax::end(); ?>
    
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
