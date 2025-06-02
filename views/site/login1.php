<?php
use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
use kartik\popover\PopoverX;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login1:</p>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'showLabels'=>false,
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); 
    
    PopoverX::begin([
    'size' => PopoverX::SIZE_MEDIUM,
    'placement' => PopoverX::ALIGN_BOTTOM_LEFT,
    'toggleButton' => ['label'=>'Login', 'class'=>'btn btn-default'],
    'header' => '<i class="glyphicon glyphicon-lock"></i> Enter credentials',
    'footer'=>Html::submitButton('Submit', ['class'=>'btn btn-sm btn-primary']) .
             Html::resetButton('Reset', ['class'=>'btn btn-sm btn-default'])
    ]);
    
    
    ?>
    
    

    <?= $form->field($model, 'username', ['inputOptions' => ['autofocus' => true]]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe', [
        'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    ])->checkbox() ?>

    

    <?php 
    PopoverX::end();
    ActiveForm::end(); ?>

</div>
