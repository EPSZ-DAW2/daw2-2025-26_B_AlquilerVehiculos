<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Iniciar Sesión';
?>

<div class="auth-wrap">
		<section class="card">
				<div class="card-h">
						<h3>🔐 <?= Html::encode($this->title) ?></h3>
						<span class="small">Bienvenido de nuevo</span>
				</div>

				<div class="card-b">
						<p style="color:var(--muted); margin-bottom:20px;">
								Introduce tus credenciales para acceder al panel.
						</p>

						<?php $form = ActiveForm::begin([
								'id' => 'login-form',
								'fieldConfig' => [
										'template' => "<div class=\"field\">{label}\n{input}\n{error}</div>",
										'labelOptions' => ['class' => 'label'],
										'inputOptions' => ['class' => ''],
										'errorOptions' => ['class' => 'help-block', 'style' => 'color:var(--danger)'],
								],
						]); ?>

						<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Usuario o Email']) ?>

						<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Tu contraseña']) ?>

						<?= $form->field($model, 'rememberMe')->checkbox([
								'template' => "<div style='margin:10px 0;'>{input} <span style='color:var(--muted)'>{label}</span></div>",
						]) ?>

						<div class="actions" style="margin-top: 20px;">
								<?= Html::submitButton('Entrar', ['class' => 'btn primary', 'style' => 'width:100%']) ?>
						</div>

						<?php ActiveForm::end(); ?>

						<hr class="sep">

						<div style="text-align: center;">
								<p class="small">¿Aún no tienes cuenta?</p>
								<a href="<?= Url::to(['site/register']) ?>" class="btn good" style="width:100%">
										Crear cuenta nueva
								</a>
						</div>
				</div>
		</section>
</div>