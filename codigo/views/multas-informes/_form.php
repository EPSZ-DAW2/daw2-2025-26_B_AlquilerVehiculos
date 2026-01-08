<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MultasInformes $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="multas-informes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_reserva')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_incidencia')->textInput() ?>

    <?= $form->field($model, 'importe_multa')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
