<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista debe recibir desde el controlador:

  $usuario = [
    'id_usuario' => 1,
    'nombre' => '...',
    'email' => '...',
    'rol' => 'Cliente',
    'num_carnet_conducir' => '...'
    // (campos extra opcionales si BD los añade después)
    // 'apellidos' => '...',
    // 'telefono' => '...',
    // 'dni' => '...',
    // 'carnet_caducidad' => '...'
  ];

  Tablas implicadas:
  - usuarios

  NOTA PARA BD:
  - Esta pantalla muestra datos del usuario autenticado (por id_usuario).
  - Si se permite edición, backend hará UPDATE con ActiveRecord.
*/

// DEMO FRONTEND
$usuario = $usuario ?? [
  'id_usuario' => 0,
  'nombre' => 'Cliente Demo',
  'email' => 'cliente@demo.com',
  'rol' => 'Cliente',
  'num_carnet_conducir' => 'X1234567',
  'apellidos' => '',
  'telefono' => '',
  'dni' => '',
  'carnet_caducidad' => '',
];
?>

<section class="hero">
  <h1 class="h-title">Mi perfil</h1>
  <p class="h-sub">Datos de la cuenta.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>Información</h3>
    </div>

    <div class="card-b">
      <div class="notice">
        <strong>ID:</strong> <?= Html::encode($usuario['id_usuario'] ?? '-') ?><br>
        <strong>Rol:</strong> <?= Html::encode($usuario['rol'] ?? '-') ?>
      </div>

      <hr class="sep">

      <form>
        <div class="row2">
          <div class="field">
            <div class="label">Nombre</div>
            <input type="text" value="<?= Html::encode($usuario['nombre'] ?? '') ?>" disabled>
          </div>
          <div class="field">
            <div class="label">Apellidos</div>
            <input type="text" value="<?= Html::encode($usuario['apellidos'] ?? '') ?>" disabled>
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Email</div>
            <input type="email" value="<?= Html::encode($usuario['email'] ?? '') ?>" disabled>
          </div>
          <div class="field">
            <div class="label">Teléfono</div>
            <input type="tel" value="<?= Html::encode($usuario['telefono'] ?? '') ?>" disabled>
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">DNI</div>
            <input type="text" value="<?= Html::encode($usuario['dni'] ?? '') ?>" disabled>
          </div>
          <div class="field">
            <div class="label">Nº carnet conducir</div>
            <input type="text" value="<?= Html::encode($usuario['num_carnet_conducir'] ?? '') ?>" disabled>
          </div>
        </div>

        <div class="field">
          <div class="label">Caducidad carnet</div>
          <input type="date" value="<?= Html::encode($usuario['carnet_caducidad'] ?? '') ?>" disabled>
        </div>

        <hr class="sep">

        <div class="actions">
          <a class="btn" href="<?= Url::to(['vehiculo/index']) ?>">Flota</a>
          <a class="btn good" href="<?= Url::to(['reserva/contrato']) ?>">Contrato</a>
          <a class="btn" href="<?= Url::to(['incidencia/index']) ?>">Incidencias</a>
        </div>

        <p class="small" style="margin-top:10px">
          En BD: si se habilita edición, backend actualizará la tabla <strong>usuarios</strong>.
        </p>
      </form>
    </div>
  </section>
</section>
