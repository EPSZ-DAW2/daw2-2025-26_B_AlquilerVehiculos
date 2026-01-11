<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Controlador sugerido: /controladores/login.php  (POST)

  En backend:
  1) Recibir email y password
  2) Buscar usuario en BD:
       SELECT * FROM usuarios WHERE email = ?
  3) Verificar contraseña:
       password_verify($password, $hash_bd)
  4) Crear sesión (en Yii2: componente de usuario / identity):
       Yii::$app->user->login(...)
  5) Redirigir a flota:
       vehiculo/index

  Error:
  - Mostrar error (en la versión antigua era ?error=1)

  NOTA:
  - En Yii2 no usamos $_GET en la vista.
  - El controlador debe pasar:
      $showOk (equivalente a ?ok=1)
      $showError (equivalente a ?error=1)
*/

$this->title = 'Iniciar sesión';

// Estos flags los enviará el controlador (equivalentes a ?ok y ?error del front antiguo)
$showOk = $showOk ?? false;
$showError = $showError ?? false;
?>

<section class="auth-wrap">
  <section class="card">
    <div class="card-h">
      <h3>Iniciar sesión</h3>
      <span class="small">Cliente</span>
    </div>

    <div class="card-b">
      <form action="<?= Html::encode(Url::to(['site/login'])) ?>" method="post">
        <!-- CSRF (Yii2) -->
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div class="field">
          <div class="label">Email</div>
          <input type="email" name="email" placeholder="email@dominio.com" required>
        </div>

        <div class="field">
          <div class="label">Contraseña</div>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <?php if ($showOk): ?>
          <div class="notice">Cuenta creada correctamente. Ya puedes iniciar sesión.</div>
        <?php endif; ?>

        <?php if ($showError): ?>
          <div class="notice">Error: credenciales incorrectas o usuario no existe.</div>
        <?php endif; ?>

        <div class="actions" style="margin-top:12px">
          <button class="btn primary" type="submit">Entrar</button>
          <a class="btn" href="<?= Html::encode(Url::to(['site/registro'])) ?>">Crear cuenta</a>
        </div>

        <hr class="sep"/>

        <p class="small">
          Backend: almacenar contraseñas con <strong>password_hash</strong>
          y verificar con <strong>password_verify</strong>.
        </p>
      </form>
    </div>
  </section>
</section>
