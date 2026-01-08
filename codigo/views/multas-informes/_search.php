<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\MultasInformesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="multas-informes-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_informe') ?>

    <?= $form->field($model, 'id_reserva') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'fecha_incidencia') ?>

    <?= $form->field($model, 'importe_multa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
