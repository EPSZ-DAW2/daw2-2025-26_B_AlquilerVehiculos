<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Controlador sugerido: /controladores/registro.php  (POST)

  En backend:
  1) Validar campos (nombre, email, password, carnet, fechas)
  2) Comprobar si el email existe:
       SELECT id FROM usuarios WHERE email = ?
  3) Insertar usuario/cliente:
       INSERT INTO usuarios (...) VALUES (...)
     - Guardar contraseña con password_hash
  4) Insertar carnet (misma tabla o tabla aparte)
  5) Redirigir a login (en la versión antigua era ?ok=1)

  Error:
  - Mostrar error (en la versión antigua era ?error=1)

  NOTA:
  - En Yii2 no usamos $_GET en la vista.
  - El controlador debe pasar:
      $showError (equivalente a ?error=1)
*/

$this->title = 'Registro';

// Flag enviado por el controlador (equivalente a ?error=1 del front antiguo)
$showError = $showError ?? false;
?>

<section class="auth-wrap">
  <section class="card">
    <div class="card-h">
      <h3>Crear cuenta</h3>
      <span class="small">Registro cliente</span>
    </div>

    <div class="card-b">
      <form action="<?= Html::encode(Url::to(['site/registro'])) ?>" method="post">
        <!-- CSRF (Yii2) -->
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <div class="row2">
          <div class="field">
            <div class="label">Nombre</div>
            <input type="text" name="nombre" required>
          </div>
          <div class="field">
            <div class="label">Apellidos</div>
            <input type="text" name="apellidos" required>
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Email</div>
            <input type="email" name="email" required>
          </div>
          <div class="field">
            <div class="label">Teléfono</div>
            <input type="tel" name="telefono" placeholder="Opcional">
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Contraseña</div>
            <input type="password" name="password" required>
          </div>
          <div class="field">
            <div class="label">Repetir contraseña</div>
            <input type="password" name="password2" required>
          </div>
        </div>

        <hr class="sep"/>

        <div class="notice">
          <strong>Carnet de conducir</strong><br/>
          Backend: validar que <em>caducidad</em> sea posterior a <em>expedición</em>.
        </div>

        <div class="row2" style="margin-top:12px">
          <div class="field">
            <div class="label">Número de carnet</div>
            <input type="text" name="carnet_num" required>
          </div>
          <div class="field">
            <div class="label">Fecha de expedición</div>
            <input type="date" name="carnet_expedicion" required>
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Fecha de caducidad</div>
            <input type="date" name="carnet_caducidad" required>
          </div>
          <div class="field">
            <div class="label">DNI (opcional)</div>
            <input type="text" name="dni">
          </div>
        </div>

        <?php if ($showError): ?>
          <div class="notice">Error: revisa los datos o el email ya está registrado.</div>
        <?php endif; ?>

        <div class="actions" style="margin-top:12px">
          <button class="btn primary" type="submit">Registrar</button>
          <a class="btn" href="<?= Html::encode(Url::to(['site/login'])) ?>">Ya tengo cuenta</a>
        </div>

        <hr class="sep"/>

        <p class="small">
          En BD: contraseña siempre cifrada (<strong>password_hash</strong>).
        </p>
      </form>
    </div>
  </section>
</section>
