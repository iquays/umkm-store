<?php

use app\models\BeritaCategory;
use kartik\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Berita */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="berita-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(BeritaCategory::find()->orderBy('title')->asArray()->all(), 'category_id', 'title'),
        'options' => ['placeholder' => 'Pilih Kategori'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>

    <?php
    //    echo $form->field($model, 'text')->widget(\yii\redactor\widgets\Redactor::className(), [
    //            'clientOptions' => [
    //                'minHeight' => 400,
    //                'imageResizable' => true,
    //                'imagePosition' => true,
    //                'plugins' => [
    //                    'fullscreen'
    //                ]
    //            ]
    //        ]
    //    )
    ?>

    <?php
    echo $form->field($model, 'text')->widget(vova07\imperavi\Widget::className(), [
        'settings' => [
            'minHeight' => 200,
            'imageUpload' => yii\helpers\Url::to(['/berita/image-upload']),
            'imageResizable' => true,
//                'imagePosition' => true,
            'plugins' => [
                'fullscreen'
            ]
        ]
    ]);
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
