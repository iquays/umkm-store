<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\BeritaCategory */

$this->title = 'Create Berita Category';
$this->params['breadcrumbs'][] = ['label' => 'Berita Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="berita-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
