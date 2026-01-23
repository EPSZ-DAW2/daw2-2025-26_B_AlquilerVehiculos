<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Extras $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="extras-form">

	<?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'concepto')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'precio')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'tipo_calculo')->dropDownList([ 'Por Dia' => 'Por Dia', 'Fijo' => 'Fijo', ], ['prompt' => '']) ?>

	<div class="form-group">
		<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

</div>
