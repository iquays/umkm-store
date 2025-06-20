<?php

use yii\helpers\Html;
//use iutbay\yii2fontawesome\FontAwesome as FA;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . ' ' . $model->fullname . ' (' . $model->username . ')';
//$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
