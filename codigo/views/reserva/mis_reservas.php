<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  - Obtener id_cliente desde sesión (backend)
  - SELECT reservas JOIN vehiculos
  - Pasar resultado como $reservas a esta vista

  Estructura esperada:
  $reservas = [
    ['id'=>'R-1203','vehiculo'=>'Toyota Yaris','inicio'=>'2026-01-06','fin'=>'2026-01-08','total'=>84.70,'estado'=>'activa'],
    ...
  ];
*/

$this->title = $this->title ?: 'Mis reservas';

// Demo para render sin BD (el backend lo reemplazará)
$reservas = $reservas ?? [
  ['id'=>'R-1203','vehiculo'=>'Toyota Yaris','inicio'=>'2026-01-06','fin'=>'2026-01-08','total'=>84.70,'estado'=>'activa'],
  ['id'=>'R-1201','vehiculo'=>'BMW Serie 1','inicio'=>'2025-12-10','fin'=>'2025-12-12','total'=>191.18,'estado'=>'pendiente'],
];
?>

<section class="hero">
  <h1 class="h-title">Mis reservas</h1>
  <p class="h-sub">Historial de reservas del cliente.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>Listado</h3>
      <span class="small"><?= count($reservas) ?> reservas</span>
    </div>

    <div class="card-b" style="padding:0">
      <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Vehículo</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Contrato</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($reservas as $r): ?>
            <?php
              $estado = $r['estado'] ?? 'pendiente';
              // Igual que el antiguo: activa => ok, resto => busy
              $pillClass = ($estado === 'activa') ? 'ok' : 'busy';
            ?>
            <tr>
              <td><?= Html::encode($r['id'] ?? '-') ?></td>
              <td><?= Html::encode($r['vehiculo'] ?? '-') ?></td>
              <td><?= Html::encode($r['inicio'] ?? '-') ?></td>
              <td><?= Html::encode($r['fin'] ?? '-') ?></td>
              <td><?= (float)($r['total'] ?? 0) ?>€</td>
              <td>
                <span class="pill <?= Html::encode($pillClass) ?>" style="position:static">
                  <?= Html::encode(ucfirst($estado)) ?>
                </span>
              </td>
              <td>
                <a class="btn good"
                   href="<?= Html::encode(Url::to(['reserva/contrato', 'id' => $r['id'] ?? null])) ?>">
                  Ver
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div style="padding:16px">
        <div class="actions">
          <a class="btn primary" href="<?= Html::encode(Url::to(['vehiculo/index'])) ?>">Nueva reserva</a>
          <a class="btn" href="<?= Html::encode(Url::to(['incidencia/index'])) ?>">Incidencias</a>
        </div>
      </div>
    </div>
  </section>
</section>
