<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Slidepic */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="slidepic-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data'] ]); ?>
    
    <?php 
        if ($model->isNewRecord) {
            echo $form->field($model, 'image')->widget(FileInput::classname(), [
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],
                    'showUpload' => false,
                    'showCaption' => false,
                    'showRemove' => false,
            ]]);            
        } else {
            echo $form->field($model, 'image')->widget(FileInput::classname(), [
                'options'=>['accept'=>'image/*'],
                'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],
                    'initialPreview'=>[Html::img($model->getImageUrlThumbnail(), ['class'=>'file-preview-image', 'alt'=>$model->filename, 'title'=>$model->title])],
                    'showUpload' => false,
                    'showCaption' => false,
                    'showRemove' => false,
            ]]);                        
        }
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_description')->textInput(['maxlength' => true]) ?>

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
