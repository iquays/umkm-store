<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(['id' => 'sendMessageForm', 'enableAjaxValidation' => false]); ?>

    <?= $form->field($model, 'from')->textInput() ?>

    <?= $form->field($model, 'fromName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fromEmail')->textInput(['maxlength' => true]) ?>

    
    <?= Html::activeHiddenInput($model, 'to', $options = ['value' => $recipient['id']]) ?>
    
    <label class="control-label">To: </label>
    <h4><span class='label label-default'><?=$recipient['id']?></span></h4>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
