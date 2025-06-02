<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Slidepic */

$this->title = 'Create Slidepic';
$this->params['breadcrumbs'][] = ['label' => 'Slidepics', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slidepic-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
