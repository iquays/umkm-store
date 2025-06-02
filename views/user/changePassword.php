<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChangePasswordForm */
/* @var $form ActiveForm */

$this->title = 'Ganti Password';

?>
<div class="changePassword">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Silakan isi kolom berikut ini untuk mengganti password:</p>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'newPassword')->passwordInput() ?>
    <?= $form->field($model, 'verifyPassword')->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Ganti Password', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    <br>

</div><!-- changePassword -->
