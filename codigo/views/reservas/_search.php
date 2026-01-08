<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReservasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_reserva') ?>

    <?= $form->field($model, 'id_usuario') ?>

    <?= $form->field($model, 'id_vehiculo') ?>

    <?= $form->field($model, 'fecha_inicio') ?>

    <?= $form->field($model, 'fecha_fin') ?>

    <?php // echo $form->field($model, 'coste_total') ?>

    <?php // echo $form->field($model, 'estado_reserva') ?>

    <?php // echo $form->field($model, 'km_entrega') ?>

    <?php // echo $form->field($model, 'km_devolucion') ?>

    <?php // echo $form->field($model, 'observaciones_contrato') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
