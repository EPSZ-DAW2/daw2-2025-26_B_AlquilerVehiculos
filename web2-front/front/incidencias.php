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
  En backend:
  - Obtener id_cliente desde sesión
  - Consultar incidencias asociadas a contratos del cliente

  Ejemplo SQL:
    SELECT i.id, i.id_contrato, i.tipo, i.fecha, i.importe, i.estado
    FROM incidencias i
    JOIN contratos c ON c.id = i.id_contrato
    WHERE c.id_cliente = ?
    ORDER BY i.fecha DESC;

  Guardar en $incidencias (array).
*/

$pageTitle = "Incidencias";
$active = "incidencias";

// Header común (calcula $BASE_URL y carga CSS)
include __DIR__ . "/../vistas/header_front.php";

$incidencias = $incidencias ?? [
  ['id'=>'I-2001','contrato'=>'C-0001','tipo'=>'Multa','fecha'=>'2025-12-11','importe'=>120,'estado'=>'pendiente'],
  ['id'=>'I-1998','contrato'=>'C-0000','tipo'=>'Informe policial','fecha'=>'2025-09-03','importe'=>0,'estado'=>'registrado'],
];
?>

<section class="hero">
  <h1 class="h-title">Incidencias</h1>
  <p class="h-sub">Multas e informes policiales asociados a tus contratos.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>Listado</h3>
      <span class="small"><?= count($incidencias) ?> registros</span>
    </div>

    <div class="card-b" style="padding:0">
      <table class="table">
        <thead>
          <tr>
            <th>#Incidencia</th>
            <th>#Contrato</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Importe</th>
            <th>Estado</th>
          </tr>
        </thead>

        <tbody>
          <?php if (empty($incidencias)): ?>
            <tr><td colspan="6">No hay incidencias registradas.</td></tr>
          <?php else: ?>
            <?php foreach ($incidencias as $i): ?>
              <?php
                $estado = $i['estado'] ?? 'pendiente';
                $pillClass = $estado === 'pendiente' ? 'busy' : ($estado === 'registrado' ? 'ok' : 'off');
              ?>
              <tr>
                <td><?= htmlspecialchars($i['id']) ?></td>
                <td><?= htmlspecialchars($i['contrato']) ?></td>
                <td><?= htmlspecialchars($i['tipo']) ?></td>
                <td><?= htmlspecialchars($i['fecha']) ?></td>
                <td><?= (float)$i['importe'] ?>€</td>
                <td>
                  <span class="pill <?= $pillClass ?>" style="position:static">
                    <?= htmlspecialchars(ucfirst($estado)) ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

      <div style="padding:16px">
        <div class="actions">
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/mis_reservas.php">Mis reservas</a>
          <a class="btn primary" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Ver flota</a>
        </div>

        <hr class="sep"/>

        <p class="small">
          En BD: incidencias -> contrato (FK) -> cliente (FK) para filtrar por sesión.
        </p>
      </div>
    </div>
  </section>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
