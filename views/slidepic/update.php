<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Slidepic */

$this->title = 'Update Slidepic: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Slidepics', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="slidepic-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
