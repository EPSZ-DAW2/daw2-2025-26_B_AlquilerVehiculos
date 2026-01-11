<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  En backend:
  - Obtener id del cliente desde sesión (componente de usuario).
  - SELECT datos del cliente
  - Pasar resultado como $cliente a la vista.

  Controlador sugerido (Yii2):
  - GET  -> mostrar perfil
  - POST -> actualizar perfil en BD y volver con mensaje ok/error

  Mensajes:
  - $showOk    => Datos guardados correctamente.
  - $showError => Error al guardar los datos.

  NOTA:
  - No usar $_SESSION / $_GET en la vista.
*/

$this->title = $this->title ?: 'Mi perfil';

// Demo (sin BD) -> backend lo reemplazará
$cliente = $cliente ?? [
  'nombre' => 'Juan',
  'apellidos' => 'Pérez',
  'email' => 'juan@email.com',
  'telefono' => '600123456',
  'carnet_num' => 'X1234567',
  'carnet_caducidad' => '2030-12-31'
];

// Mensajes (los enviará el controlador)
$showOk = $showOk ?? false;
$showError = $showError ?? false;
?>

<section class="hero">
  <h1 class="h-title">Mi perfil</h1>
  <p class="h-sub">Actualiza tus datos personales.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>Datos personales</h3>
      <span class="small">POST</span>
    </div>

    <div class="card-b">
      <!-- =====================================================
           FORMULARIO ACTUALIZAR PERFIL (POST)
           En backend:
           - Validar sesión
           - UPDATE cliente
           - Redirigir con ok/error
           ===================================================== -->
      <?= Html::beginForm(Url::to(['user/perfil']), 'post') ?>

        <!-- CSRF -->
        <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

        <!-- id_cliente lo saca backend de sesión; este hidden es solo estructura -->
        <?= Html::hiddenInput('id_cliente', $idCliente ?? 0) ?>

        <div class="row2">
          <div class="field">
            <div class="label">Nombre</div>
            <input type="text" name="nombre" value="<?= Html::encode($cliente['nombre'] ?? '') ?>" required>
          </div>
          <div class="field">
            <div class="label">Apellidos</div>
            <input type="text" name="apellidos" value="<?= Html::encode($cliente['apellidos'] ?? '') ?>" required>
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Email</div>
            <input type="email" name="email" value="<?= Html::encode($cliente['email'] ?? '') ?>" required>
          </div>
          <div class="field">
            <div class="label">Teléfono</div>
            <input type="tel" name="telefono" value="<?= Html::encode($cliente['telefono'] ?? '') ?>">
          </div>
        </div>

        <hr class="sep"/>

        <div class="notice">
          <strong>Carnet de conducir</strong>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Número</div>
            <input type="text" name="carnet_num" value="<?= Html::encode($cliente['carnet_num'] ?? '') ?>" required>
          </div>
          <div class="field">
            <div class="label">Caducidad</div>
            <input type="date" name="carnet_caducidad" value="<?= Html::encode($cliente['carnet_caducidad'] ?? '') ?>" required>
          </div>
        </div>

        <?php if ($showOk): ?>
          <div class="notice">Datos guardados correctamente.</div>
        <?php endif; ?>

        <?php if ($showError): ?>
          <div class="notice">Error al guardar los datos.</div>
        <?php endif; ?>

        <div class="actions" style="margin-top:12px">
          <button class="btn primary" type="submit">Guardar</button>
          <a class="btn" href="<?= Html::encode(Url::to(['reserva/mis-reservas'])) ?>">Mis reservas</a>
        </div>

      <?= Html::endForm() ?>
    </div>
  </section>
</section>
