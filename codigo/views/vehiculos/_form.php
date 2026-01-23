<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Vehiculos $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="vehiculos-form">

		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'matricula')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

		<?= $form->field($model, 'id_categoria')->textInput() ?>

		<?= $form->field($model, 'estado')->dropDownList([ 'Activo' => 'Activo', 'Taller' => 'Taller', 'Alquilado' => 'Alquilado', 'Baja' => 'Baja', ], ['prompt' => '']) ?>

		<?= $form->field($model, 'fecha_baja_logica')->textInput() ?>

		<div class="form-group">
				<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
		</div>

		<?php ActiveForm::end(); ?>

</div>
