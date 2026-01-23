<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = 'Mi Perfil';
?>

<section class="hero">
	<h1 class="h-title">Mi Perfil</h1>
	<p class="h-sub">Actualiza tus datos personales y contraseña.</p>
</section>

<section class="grid" style="grid-template-columns:1fr; max-width: 800px; margin: 0 auto;">
	<section class="card">
		<div class="card-h">
			<h3>👤 Datos Personales</h3>
			<span class="small">Editar información</span>
		</div>

		<div class="card-b">
			
			<?php if (Yii::$app->session->hasFlash('success')): ?>
				<div class="notice" style="border-color: var(--ok); color: var(--ok); margin-bottom: 20px;">
						<?= Yii::$app->session->getFlash('success') ?>
				</div>
			<?php endif; ?>

			<?php $form = ActiveForm::begin([
					'id' => 'perfil-form',
					'fieldConfig' => [
							'template' => "<div class=\"field\">{label}\n{input}\n{error}</div>",
							'labelOptions' => ['class' => 'label'],
							'inputOptions' => ['class' => 'form-control'],
					],
			]); ?>

				<div class="row2">
					<?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Tu nombre completo']) ?>
					<?= $form->field($model, 'edad')->input('number') ?>
				</div>

				<div class="row2">
					<?= $form->field($model, 'email')->input('email') ?>
					<?= $form->field($model, 'dni')->textInput() ?>
				</div>

				<hr class="sep"/>

				<div class="notice">
					<strong>Seguridad</strong><br>
					Deja el campo contraseña vacío si no quieres cambiarla.
				</div>

				<div class="row2">
							<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Nueva contraseña (opcional)', 'value' => ''])->label('Cambiar Contraseña') ?>
				</div>

				<div class="actions" style="margin-top:20px">
					<?= Html::submitButton('Guardar Cambios', ['class' => 'btn primary', 'style' => 'width: 100%; justify-content: center;']) ?>
				</div>

			<?php ActiveForm::end(); ?>
			
		</div>
	</section>
</section>