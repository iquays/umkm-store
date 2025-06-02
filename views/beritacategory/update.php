<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BeritaCategory */

$this->title = 'Update Berita Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Berita Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->category_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="berita-category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
