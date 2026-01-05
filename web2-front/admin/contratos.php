<?php
session_start();

$pageTitle = "Admin - Contratos";
$active = "contratos";
include __DIR__ . "/../vistas/header_admin.php";

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Listado recomendado (JOIN):
    SELECT c.id, cli.nombre, v.marca, v.modelo, c.fecha_inicio, c.fecha_fin, c.total, c.estado
    FROM contratos c
    JOIN clientes cli ON cli.id = c.id_cliente
    JOIN vehiculos v ON v.id = c.id_vehiculo
    ORDER BY c.id DESC;

  Estados típicos:
    - pendiente
    - activa
    - finalizada
    - cancelada

  Acciones posibles (si el enunciado lo requiere):
    - Cambiar estado (UPDATE)
    - Cancelar (UPDATE estado='cancelada')
*/

$contratos = $contratos ?? [
  ['id'=>'C-0001','cliente'=>'Juan Pérez','vehiculo'=>'Toyota Yaris','inicio'=>'2026-01-06','fin'=>'2026-01-08','total'=>84.70,'estado'=>'activa'],
  ['id'=>'C-0000','cliente'=>'María López','vehiculo'=>'BMW Serie 1','inicio'=>'2025-12-10','fin'=>'2025-12-12','total'=>191.18,'estado'=>'pendiente'],
  ['id'=>'C-0998','cliente'=>'Carlos Ruiz','vehiculo'=>'Nissan Qashqai','inicio'=>'2025-09-01','fin'=>'2025-09-06','total'=>332.75,'estado'=>'finalizada'],
];
?>

<section class="hero">
  <h1 class="h-title">Contratos / Reservas</h1>
  <p class="h-sub">Gestión de reservas y contratos (datos desde BD).</p>
</section>

<section class="card">
  <div class="card-h">
    <h3>Listado</h3>
    <span class="small"><?= count($contratos) ?> registros</span>
  </div>

  <div class="card-b" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>#Contrato</th>
          <th>Cliente</th>
          <th>Vehículo</th>
          <th>Inicio</th>
          <th>Fin</th>
          <th>Total</th>
          <th>Estado</th>
          <th>Acción</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($contratos as $c): ?>
          <?php
            $estado = $c['estado'] ?? 'pendiente';
            $pillClass = $estado === 'activa' ? 'ok' : ($estado === 'pendiente' ? 'busy' : 'off');
          ?>
          <tr>
            <td><?= htmlspecialchars($c['id']) ?></td>
            <td><?= htmlspecialchars($c['cliente']) ?></td>
            <td><?= htmlspecialchars($c['vehiculo']) ?></td>
            <td><?= htmlspecialchars($c['inicio']) ?></td>
            <td><?= htmlspecialchars($c['fin']) ?></td>
            <td><?= (float)$c['total'] ?>€</td>
            <td>
              <span class="pill <?= $pillClass ?>" style="position:static">
                <?= htmlspecialchars(ucfirst($estado)) ?>
              </span>
            </td>
            <td>
              <!-- =================================================
                   ACCIÓN (POST)
                   Controlador sugerido: /controladores/admin/contrato_estado.php

                   En backend (BD):
                   - UPDATE contratos SET estado=? WHERE id=?
                   - Validar reglas (no activar si vehículo no disponible)
                   ================================================= -->
              <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/admin/contrato_estado.php" method="post" style="display:inline;">
                <input type="hidden" name="id_contrato" value="<?= htmlspecialchars($c['id']) ?>">
                <input type="hidden" name="nuevo_estado" value="cancelada">
                <button class="btn danger" type="submit">Cancelar</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div style="padding:16px">
      <p class="small">
        En BD: este listado se obtiene con JOIN (contratos + clientes + vehículos).
      </p>
    </div>
  </div>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
