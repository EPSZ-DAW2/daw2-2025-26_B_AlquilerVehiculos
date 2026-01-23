<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Categorias $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="categorias-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'nombre_grupo')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'precio_dia')->textInput(['maxlength' => true]) ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
