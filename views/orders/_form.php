<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-create">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($productsList, ['prompt' => 'Select Product']) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
