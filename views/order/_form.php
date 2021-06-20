<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'customer_id')->dropdownList($customers) ?>

    <?= $form->field($model, 'sale_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency_id')->dropdownList($currencies) ?>

    <?= $form->field($model, 'status')->dropdownList(['0'=>'Pending', '1'=>'Complete']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
