<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista muestra el formulario de login.

  En backend:
  - Validar credenciales contra la tabla usuarios
  - Crear sesión usando Yii::$app->user (NO $_SESSION)
  - Redirigir según rol (Cliente / Admin)

  Tabla implicada:
  - usuarios (email, password, rol, ...)

  NOTA PARA BD:
  - El password debe almacenarse cifrado (hash).
  - La validación se hace en el modelo (no aquí).
*/
?>

<section class="hero">
  <h1 class="h-title">Acceso</h1>
  <p class="h-sub">Introduce tus credenciales.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card" style="max-width:420px;margin:auto">
    <div class="card-h">
      <h3>Login</h3>
    </div>

    <div class="card-b">
      <form>
        <div class="field">
          <div class="label">Email</div>
          <input type="email" placeholder="usuario@email.com">
        </div>

        <div class="field">
          <div class="label">Contraseña</div>
          <input type="password" placeholder="********">
        </div>

        <div class="actions">
          <button class="btn primary" disabled>Entrar</button>
          <a class="btn" href="<?= Url::to(['site/index']) ?>">Cancelar</a>
        </div>

        <p class="small" style="margin-top:12px">
          En backend: validar email/contraseña y crear sesión del usuario.
        </p>
      </form>
    </div>
  </section>
</section>
