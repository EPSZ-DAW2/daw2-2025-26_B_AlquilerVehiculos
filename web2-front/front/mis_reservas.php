<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  - Obtener id_cliente desde sesión
  - SELECT reservas JOIN vehiculos
  - Pasar resultado como $reservas
*/

$pageTitle = "Mis reservas";
$active = "mis_reservas";

// Header común (calcula $BASE_URL)
include __DIR__ . "/../vistas/header_front.php";

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
              $estado = $r['estado'];
              $pillClass = $estado === 'activa' ? 'ok' : 'busy';
            ?>
            <tr>
              <td><?= htmlspecialchars($r['id']) ?></td>
              <td><?= htmlspecialchars($r['vehiculo']) ?></td>
              <td><?= htmlspecialchars($r['inicio']) ?></td>
              <td><?= htmlspecialchars($r['fin']) ?></td>
              <td><?= (float)$r['total'] ?>€</td>
              <td>
                <span class="pill <?= $pillClass ?>" style="position:static">
                  <?= htmlspecialchars(ucfirst($estado)) ?>
                </span>
              </td>
              <td>
                <a class="btn good" href="<?= htmlspecialchars($BASE_URL) ?>/front/contrato.php?id=<?= urlencode($r['id']) ?>">
                  Ver
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <div style="padding:16px">
        <div class="actions">
          <a class="btn primary" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Nueva reserva</a>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/incidencias.php">Incidencias</a>
        </div>
      </div>
    </div>
  </section>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
