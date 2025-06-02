<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\ProductPicture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-picture-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <?php echo $form->field($model, 'image')->widget(FileInput::classname(), [
            'options'=>['accept'=>'image/*'],
            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],
                'initialPreview'=>[Html::img($model->getImageUrl(), ['class'=>'file-preview-image', 'alt'=>$model->picture, 'title'=>$model->picture])],
                'showUpload' => false,
                'showCaption' => false,
                'showRemove' => false,
        ]]);
    ?>
    
    
    <?= $form->field($model, 'product_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
