<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuarios-form card" style="padding:20px;">

		<?php $form = ActiveForm::begin(); ?>

		<div class="row2">
				<?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'placeholder' => 'Nombre Completo']) ?>
				<?= $form->field($model, 'dni')->textInput(['maxlength' => true, 'placeholder' => 'DNI']) ?>
		</div>

		<div class="row2">
				<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
				<?= $form->field($model, 'edad')->input('number') ?>
		</div>

		<div class="row2">
				<?= $form->field($model, 'rol')->dropDownList([ 'Admin' => 'Admin', 'Cliente' => 'Cliente' ], ['prompt' => 'Selecciona Rol...']) ?>
				
				<?= $form->field($model, 'password')->passwordInput(['maxlength' => true, 'value' => '', 'placeholder' => 'Dejar vacío para no cambiar']) ?>
		</div>

		<div class="form-group" style="margin-top:20px;">
				<?= Html::submitButton('Guardar Usuario', ['class' => 'btn primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>

</div>