<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista debe recibir desde el controlador:

  1) $cliente (datos del usuario autenticado):
  $cliente = [
    'nombre' => '...',
    'email' => '...',
    'num_carnet_conducir' => '...'
  ];

  2) $reserva (resumen de la reserva/contrato):
  $reserva = [
    'id_reserva' => 123,
    'fecha_inicio' => '2026-01-10',
    'fecha_fin' => '2026-01-12',
    'estado_reserva' => 'Pendiente',
    'coste_total' => 120.00
  ];

  3) $vehiculo (vehículo asociado):
  $vehiculo = [
    'marca' => 'Toyota',
    'modelo' => 'Yaris',
    'categoria' => 'Compacto',
    'precio_dia' => 35
  ];

  Tablas implicadas:
  - reservas
  - usuarios
  - vehiculos
  - categorias

  NOTA PARA BD:
  - Obtener la reserva del usuario (por id o la última pendiente).
  - JOIN reservas -> vehiculos -> categorias y reservas -> usuarios.
  - El coste_total debe calcularse en servidor (no fiarse del cliente).
*/

// DEMO FRONTEND (para render sin BD)
$cliente = $cliente ?? [
  'nombre' => 'Cliente Demo',
  'email' => 'cliente@demo.com',
  'num_carnet_conducir' => 'X1234567',
];

$vehiculo = $vehiculo ?? [
  'marca' => 'Vehículo',
  'modelo' => 'Demo',
  'categoria' => '---',
  'precio_dia' => 0,
];

$reserva = $reserva ?? [
  'id_reserva' => 0,
  'fecha_inicio' => '',
  'fecha_fin' => '',
  'estado_reserva' => 'Pendiente',
  'coste_total' => 0,
];

// Opcional: mostrar desglose IVA (si vuestra BD lo guarda o se calcula)
$subtotal = $subtotal ?? null;
$iva = $iva ?? null;
?>

<section class="hero">
  <h1 class="h-title">Contrato</h1>
  <p class="h-sub">Resumen del alquiler.</p>
</section>

<section class="split">
  <section class="card">
    <div class="card-h">
      <h3>Datos del cliente</h3>
    </div>
    <div class="card-b">
      <div class="notice">
        <strong>Nombre:</strong> <?= Html::encode($cliente['nombre'] ?? '-') ?><br>
        <strong>Email:</strong> <?= Html::encode($cliente['email'] ?? '-') ?><br>
        <strong>Carnet:</strong> <?= Html::encode($cliente['num_carnet_conducir'] ?? '-') ?>
      </div>

      <hr class="sep">

      <h3 style="margin:0 0 10px">Vehículo</h3>
      <div class="notice">
        <strong><?= Html::encode(($vehiculo['marca'] ?? '').' '.($vehiculo['modelo'] ?? '')) ?></strong><br>
        <span class="small"><?= Html::encode($vehiculo['categoria'] ?? '-') ?></span><br>
        <span class="small">Precio/día: <?= Html::encode($vehiculo['precio_dia'] ?? 0) ?> €</span>
      </div>

      <hr class="sep">

      <h3 style="margin:0 0 10px">Reserva</h3>
      <table class="table">
        <tbody>
          <tr>
            <th>ID Reserva</th>
            <td><?= Html::encode($reserva['id_reserva'] ?? '-') ?></td>
          </tr>
          <tr>
            <th>Inicio</th>
            <td><?= Html::encode($reserva['fecha_inicio'] ?? '-') ?></td>
          </tr>
          <tr>
            <th>Fin</th>
            <td><?= Html::encode($reserva['fecha_fin'] ?? '-') ?></td>
          </tr>
          <tr>
            <th>Estado</th>
            <td><?= Html::encode($reserva['estado_reserva'] ?? '-') ?></td>
          </tr>
        </tbody>
      </table>

      <hr class="sep">

      <div class="notice">
        <?php if ($subtotal !== null && $iva !== null): ?>
          <strong>Subtotal:</strong> <?= Html::encode($subtotal) ?> €<br>
          <strong>IVA:</strong> <?= Html::encode($iva) ?> €<br>
          <strong>Total:</strong> <strong><?= Html::encode($reserva['coste_total'] ?? 0) ?> €</strong>
        <?php else: ?>
          <strong>Total:</strong> <strong><?= Html::encode($reserva['coste_total'] ?? 0) ?> €</strong>
          <div class="small">En BD: si no hay subtotal/iva, basta con coste_total.</div>
        <?php endif; ?>
      </div>

      <div class="actions" style="margin-top:14px">
        <a class="btn" href="<?= Url::to(['vehiculo/index']) ?>">Volver a flota</a>
        <a class="btn good" href="<?= Url::to(['user/perfil']) ?>">Perfil</a>
      </div>

      <p class="small" style="margin-top:10px">
        En BD: la confirmación/cancelación de reserva se gestiona actualizando <strong>reservas.estado_reserva</strong>.
      </p>
    </div>
  </section>

  <aside class="card">
    <div class="card-h">
      <h3>Notas</h3>
    </div>
    <div class="card-b">
      <div class="notice">
        <strong>BD:</strong> validar disponibilidad por fechas para el mismo vehículo.<br>
        Usar comprobación completa de solapamiento (no BETWEEN simple).
      </div>
      <hr class="sep">
      <div class="small">
        Esta pantalla es solo presentación (frontend).<br>
        La lógica de creación/confirmación se hace en backend con modelos.
      </div>
    </div>
  </aside>
</section>
