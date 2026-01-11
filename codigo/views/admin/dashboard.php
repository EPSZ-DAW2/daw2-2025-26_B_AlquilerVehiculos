<?php
use yii\helpers\Html;

/*
  Migración directa desde admin/dashboard.php (antiguo).
  - Sin session_start
  - Sin include header_admin / footer (ya lo hace el layout admin.php)
*/

$this->title = "Admin - Dashboard";
$this->params['active'] = 'dashboard';

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  El controlador (o este mismo archivo si no hay MVC) debe cargar:

  1) KPIs:
     - vehiculos activos
     - reservas del día
     - incidencias abiertas

     Ejemplos SQL:
       SELECT COUNT(*) FROM vehiculos WHERE historico='en_flota';
       SELECT COUNT(*) FROM reservas WHERE fecha_inicio = CURDATE();
       SELECT COUNT(*) FROM incidencias WHERE estado IN ('pendiente','registrado');

  2) Últimas reservas:
     SELECT r.id, c.nombre, v.marca, v.modelo, r.fecha_inicio, r.fecha_fin, r.estado
     FROM reservas r
     JOIN clientes c ON c.id = r.id_cliente
     JOIN vehiculos v ON v.id = r.id_vehiculo
     ORDER BY r.id DESC
     LIMIT 10;
*/

$kpi = $kpi ?? [
  'vehiculos' => 42,
  'reservas_hoy' => 7,
  'incidencias_abiertas' => 2
];

$ultimas = $ultimas ?? [
  ['id'=>1203,'cliente'=>'Juan Pérez','vehiculo'=>'Toyota Yaris','inicio'=>'2026-01-06','fin'=>'2026-01-08','estado'=>'activa'],
  ['id'=>1201,'cliente'=>'María López','vehiculo'=>'BMW Serie 1','inicio'=>'2025-12-10','fin'=>'2025-12-12','estado'=>'pendiente'],
];
?>

<section class="hero">
  <h1 class="h-title">Dashboard</h1>
  <p class="h-sub">Resumen general del sistema (datos desde BD en versión final).</p>
</section>

<div class="kpi">
  <div class="box">
    <h4>Vehículos en flota</h4>
    <strong><?= (int)$kpi['vehiculos'] ?></strong>
  </div>
  <div class="box">
    <h4>Reservas hoy</h4>
    <strong><?= (int)$kpi['reservas_hoy'] ?></strong>
  </div>
  <div class="box">
    <h4>Incidencias abiertas</h4>
    <strong><?= (int)$kpi['incidencias_abiertas'] ?></strong>
  </div>
</div>

<div style="height:14px"></div>

<section class="card">
  <div class="card-h">
    <h3>Últimas reservas</h3>
    <span class="small">Actividad</span>
  </div>

  <div class="card-b" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Cliente</th>
          <th>Vehículo</th>
          <th>Inicio</th>
          <th>Fin</th>
          <th>Estado</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($ultimas as $r): ?>
          <?php
            $estado = $r['estado'] ?? 'pendiente';
            $pillClass = $estado === 'activa' ? 'ok' : ($estado === 'pendiente' ? 'busy' : 'off');
          ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= Html::encode($r['cliente']) ?></td>
            <td><?= Html::encode($r['vehiculo']) ?></td>
            <td><?= Html::encode($r['inicio']) ?></td>
            <td><?= Html::encode($r['fin']) ?></td>
            <td>
              <span class="pill <?= Html::encode($pillClass) ?>" style="position:static">
                <?= Html::encode(ucfirst($estado)) ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div style="padding:16px">
      <p class="small">
        En BD: este listado se obtiene con JOIN (reservas + clientes + vehículos).
      </p>
    </div>
  </div>
</section>
