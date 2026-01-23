<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Contratos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="contratos-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'id_reserva')->textInput() ?>

	<?= $form->field($model, 'fecha_firma')->textInput() ?>

	<?= $form->field($model, 'estado_contrato')->dropDownList([ 'Vigente' => 'Vigente', 'Finalizado' => 'Finalizado', 'Cancelado' => 'Cancelado', 'Prorrogado' => 'Prorrogado', ], ['prompt' => '']) ?>

	<?= $form->field($model, 'fecha_devolucion_real')->textInput() ?>

	<?= $form->field($model, 'km_entrega')->textInput() ?>

	<?= $form->field($model, 'km_devolucion')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
