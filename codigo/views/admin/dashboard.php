<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista debe recibir desde el controlador:

  $kpis = [
    'vehiculos' => 0,
    'usuarios' => 0,
    'reservas_pendientes' => 0,
    'incidencias_pendientes' => 0
  ];

  Tablas implicadas:
  - vehiculos
  - usuarios
  - reservas
  - multas_informes

  NOTA PARA BD:
  - Estos valores se obtienen con COUNT() en backend usando modelos (ActiveRecord).
  - Reservas pendientes: filtrar por estado_reserva='Pendiente' (o el estado que uséis).
  - Incidencias pendientes: filtrar por estado='Pendiente' (o similar).
*/

$kpis = $kpis ?? [
  'vehiculos' => 0,
  'usuarios' => 0,
  'reservas_pendientes' => 0,
  'incidencias_pendientes' => 0
];
?>

<section class="hero">
  <h1 class="h-title">Admin • Dashboard</h1>
  <p class="h-sub">Resumen general (solo presentación).</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>KPIs</h3>
      <span class="small">BD</span>
    </div>

    <div class="card-b">
      <div class="kv">
        <div class="box">
          <div class="k">Vehículos</div>
          <div class="v"><?= (int)($kpis['vehiculos'] ?? 0) ?></div>
        </div>
        <div class="box">
          <div class="k">Usuarios</div>
          <div class="v"><?= (int)($kpis['usuarios'] ?? 0) ?></div>
        </div>
        <div class="box">
          <div class="k">Reservas pendientes</div>
          <div class="v"><?= (int)($kpis['reservas_pendientes'] ?? 0) ?></div>
        </div>
        <div class="box">
          <div class="k">Incidencias pendientes</div>
          <div class="v"><?= (int)($kpis['incidencias_pendientes'] ?? 0) ?></div>
        </div>
      </div>

      <hr class="sep">

      <div class="actions">
        <!-- Enlaces a pantallas de admin (frontend). Si no existen aún, el backend las creará después. -->
        <a class="btn primary" href="<?= Url::to(['admin/vehiculos']) ?>">Gestionar vehículos</a>
        <a class="btn primary" href="<?= Url::to(['admin/usuarios']) ?>">Gestionar usuarios</a>
        <a class="btn primary" href="<?= Url::to(['admin/contratos']) ?>">Gestionar contratos</a>
        <a class="btn primary" href="<?= Url::to(['admin/incidencias']) ?>">Gestionar incidencias</a>
      </div>

      <hr class="sep">

      <p class="small">
        Este dashboard es solo presentación. La lógica y permisos se gestionan en backend.
      </p>
    </div>
  </section>
</section>
