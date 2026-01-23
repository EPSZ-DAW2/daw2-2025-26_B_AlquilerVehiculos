<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Promociones $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="promociones-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'nombre_promo')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'codigo_descuento')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'porcentaje_descuento')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'es_para_estudiantes')->textInput() ?>

	<?= $form->field($model, 'fecha_limite')->textInput() ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
