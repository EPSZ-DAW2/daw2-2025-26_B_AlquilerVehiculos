<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\PromocionesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="promociones-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<?= $form->field($model, 'id_promocion') ?>

	<?= $form->field($model, 'nombre_promo') ?>

	<?= $form->field($model, 'codigo_descuento') ?>

	<?= $form->field($model, 'porcentaje_descuento') ?>

	<?= $form->field($model, 'es_para_estudiantes') ?>

	<?php // echo $form->field($model, 'fecha_limite') ?>

	<div class="form-group">
		<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
