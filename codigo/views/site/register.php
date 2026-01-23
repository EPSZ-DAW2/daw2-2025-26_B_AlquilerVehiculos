<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\RegistroForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Registro de Usuario';
?>

<div class="auth-wrap" style="max-width: 500px;">
		<section class="card">
				<div class="card-h">
						<h3>👤 Crear cuenta</h3>
						<span class="small">Datos personales</span>
				</div>

				<div class="card-b">
						
						<?php $form = ActiveForm::begin([
								'id' => 'register-form',
								'fieldConfig' => [
										'template' => "<div class=\"field\">{label}\n{input}\n{error}</div>",
										'labelOptions' => ['class' => 'label'],
										'errorOptions' => ['class' => 'help-block', 'style' => 'color:var(--danger); font-size:12px; margin-top:2px'],
								],
						]); ?>

						<div class="row2">
								<?= $form->field($model, 'nombre')->textInput(['placeholder' => 'Tu nombre']) ?>
								<?= $form->field($model, 'edad')->input('number', ['placeholder' => 'Ej: 22']) ?>
						</div>

						<?= $form->field($model, 'email')->input('email', ['placeholder' => 'correo@ejemplo.com']) ?>
						
						<?= $form->field($model, 'dni')->textInput(['placeholder' => 'DNI / NIF']) ?>

						<div class="row2">
								<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Contraseña']) ?>
								<?= $form->field($model, 'password_repeat')->passwordInput(['placeholder' => 'Repetir']) ?>
						</div>

						<div class="actions" style="margin-top: 20px;">
								<?= Html::submitButton('Registrarse', ['class' => 'btn primary', 'style' => 'width:100%']) ?>
						</div>

						<?php ActiveForm::end(); ?>

						<hr class="sep">
						<div style="text-align: center;">
								<a href="<?= Url::to(['site/login']) ?>" class="btn">Volver al Login</a>
						</div>
				</div>
		</section>
</div>