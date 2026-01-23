<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ExtrasSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="extras-search">

	<?php $form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

	<?= $form->field($model, 'id_extra') ?>

	<?= $form->field($model, 'concepto') ?>

	<?= $form->field($model, 'precio') ?>

	<?= $form->field($model, 'tipo_calculo') ?>

	<div class="form-group">
		<?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
		<?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
