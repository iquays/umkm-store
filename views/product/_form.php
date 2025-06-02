<?php

use dosamigos\tinymce\TinyMce;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\money\MaskMoney;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

//use yii\widget\ActiveForm;

//use kartik\builder\TabularForm;
//use yii\data\ActiveDataProvider;
//use kartik\grid\GridView;

//use dosamigos\fileupload\FileUploadUI;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>


<?php
$initialPreview = [];
$initialPreviewConfig = [];
if (!$model->isNewRecord) {
    foreach ($model->productPictures as $pp) {
        $initialPreview [] = Html::img($pp->getImageUrl(), ['style' => 'height:160px', 'class' => 'file-preview-image']);
        $initialPreviewConfig[] = ['url' => Yii::$app->homeUrl . 'productpicture/delete?id=' . $pp->id, 'caption' => $pp->picture];
    }
}
?>


    <div class="product-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $model->isNewRecord ? $form->field($model, 'id')->hiddenInput(['value' => $product_id])->label(false) : \NULL ?>
        <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
            'data' => $category,
            'theme' => Select2::THEME_KRAJEE,
            'language' => 'en',
            'options' => ['placeholder' => 'Pilih kategori produk anda ...', 'style' => 'width:60%;'],
        ])
        ?>
        <?= $form->field($model, 'product_name')->textInput(['maxlength' => 50]) ?>
        <?= $form->field($model, 'price')->widget(MaskMoney::classname()) ?>
        <?= $form->field($model, 'stock')->textInput() ?>
        <?= $form->field($model, 'short_description')->widget(TinyMce::className(), [
            'options' => ['rows' => 2],
            'clientOptions' => [
                'plugins' => ["textcolor link emoticons"],
                'menubar' => false,
                'statusbar' => false,
                'toolbar' => "undo redo | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | emoticons"
            ]
        ]); ?>
        <?= $form->field($model, 'description')->widget(TinyMce::className(), [
            'options' => ['rows' => 9],
            'clientOptions' => [
                'plugins' => ["textcolor link emoticons"],
                'menubar' => false,
                'statusbar' => false,
                'toolbar' => "undo redo | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | emoticons"
            ]
        ]); ?>

        <?= Html::label('Gambar Produk') ?>
        <?=
        FileInput::widget([
            'id' => 'inputProductPicture',
            'name' => 'file[]',
            'options' => [
                'multiple' => true,
            ],
            'pluginOptions' => [
                $model->isNewRecord ? NULL : 'initialPreview' => $initialPreview,
                $model->isNewRecord ? NULL : 'initialPreviewConfig' => $initialPreviewConfig,
                'resizeImage' => TRUE,
                'maxImageHeight' => 512,
                'maxImageWidth' => 768,
                'resizePreference' => 'height',
                'resizeImageQuality' => 0.70,
                'allowedFileTypes' => ['image'],
//                'allowedFileExtensions' => ['jpg', 'gif', 'png'],
                'uploadUrl' => Url::to(['product/upload']),
                'uploadExtraData' => [
                    'product_id' => $model->isNewRecord ? $product_id : $model->id,
                ],
                'maxFileCount' => 7,
                'overwriteInitial' => false
            ]
        ]);
        ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '<i class="glyphicon glyphicon-plus"></i> Create' : '<i class="glyphicon glyphicon-floppy-save"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary',
                'onclick' => "$('#inputProductPicture').fileinput('upload');"]) ?>
        </div>

        <?php ActiveForm::end(); ?>


    </div>


<?php
$this->registerJsFile(Yii::$app->homeUrl . 'js/canvas-to-blob.min.js', ['position' => $this::POS_BEGIN], 'BLOB');
?>