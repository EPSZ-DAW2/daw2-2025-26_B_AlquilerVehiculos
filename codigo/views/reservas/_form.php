<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_usuario')->textInput() ?>

    <?= $form->field($model, 'id_vehiculo')->textInput() ?>

    <?= $form->field($model, 'fecha_inicio')->textInput() ?>

    <?= $form->field($model, 'fecha_fin')->textInput() ?>

    <?= $form->field($model, 'coste_total')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'estado_reserva')->dropDownList([ 'Confirmada' => 'Confirmada', 'Finalizada' => 'Finalizada', 'Cancelada' => 'Cancelada', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'km_entrega')->textInput() ?>

    <?= $form->field($model, 'km_devolucion')->textInput() ?>

    <?= $form->field($model, 'observaciones_contrato')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
