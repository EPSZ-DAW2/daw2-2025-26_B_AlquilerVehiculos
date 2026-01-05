<?php


session_start();
$pageTitle = "Admin - Incidencias";
$active = "incidencias";
include __DIR__ . "/../vistas/header_admin.php";

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Alta / edición:
    - INSERT INTO incidencias (id_contrato, tipo, fecha, importe, descripcion, estado, referencia)
    - UPDATE incidencias SET ... WHERE id = ?

  Listado recomendado:
    SELECT i.id, i.id_contrato, cli.nombre, i.tipo, i.fecha, i.importe, i.estado
    FROM incidencias i
    JOIN contratos c ON c.id = i.id_contrato
    JOIN clientes cli ON cli.id = c.id_cliente
    ORDER BY i.fecha DESC;

  Estados típicos:
    - pendiente
    - registrado
    - resuelto
*/

$incidencias = $incidencias ?? [
  ['id'=>'I-2001','contrato'=>'C-0001','cliente'=>'Juan Pérez','tipo'=>'Multa','fecha'=>'2025-12-11','importe'=>120,'estado'=>'pendiente'],
  ['id'=>'I-1998','contrato'=>'C-0000','cliente'=>'María López','tipo'=>'Informe','fecha'=>'2025-09-03','importe'=>0,'estado'=>'registrado'],
];
?>

<section class="hero">
  <h1 class="h-title">Incidencias</h1>
  <p class="h-sub">Registrar y consultar incidencias asociadas a contratos.</p>
</section>

<section class="card">
  <div class="card-h">
    <h3>Registrar / Editar incidencia</h3>
    <span class="small">POST</span>
  </div>

  <div class="card-b">
    <!-- =====================================================
         FORMULARIO GUARDAR (POST)
         Controlador sugerido: /controladores/admin/incidencia_guardar.php

         En backend (BD):
         - Validar contrato existente (FK)
         - INSERT / UPDATE
         ===================================================== -->
    <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/admin/incidencia_guardar.php" method="post">

      <!-- ID opcional (si se rellena, se interpreta como edición) -->
      <div class="field">
        <div class="label">ID incidencia (solo para editar)</div>
        <input name="id_incidencia" placeholder="Ej. I-2001">
      </div>

      <div class="row2">
        <div class="field">
          <div class="label">ID Contrato</div>
          <input name="id_contrato" required>
        </div>

        <div class="field">
          <div class="label">Tipo</div>
          <select name="tipo" required>
            <option value="multa">Multa</option>
            <option value="informe">Informe policial</option>
          </select>
        </div>
      </div>

      <div class="row2">
        <div class="field">
          <div class="label">Fecha</div>
          <input type="date" name="fecha" required>
        </div>

        <div class="field">
          <div class="label">Importe (€)</div>
          <input type="number" min="0" step="0.01" name="importe" value="0">
        </div>
      </div>

      <div class="field">
        <div class="label">Descripción</div>
        <textarea name="descripcion" rows="4" required></textarea>
      </div>

      <div class="row2">
        <div class="field">
          <div class="label">Estado</div>
          <select name="estado" required>
            <option value="pendiente">Pendiente</option>
            <option value="registrado">Registrado</option>
            <option value="resuelto">Resuelto</option>
          </select>
        </div>

        <div class="field">
          <div class="label">Referencia (opcional)</div>
          <input name="referencia" placeholder="Nº expediente, etc.">
        </div>
      </div>

      <div class="actions">
        <button class="btn primary" type="submit">Guardar</button>
      </div>

      <hr class="sep"/>
      <p class="small">En BD: validar contrato y registrar incidencia con FK.</p>
    </form>
  </div>
</section>

<div style="height:14px"></div>

<section class="card">
  <div class="card-h">
    <h3>Listado de incidencias</h3>
    <span class="small"><?= count($incidencias) ?> registros</span>
  </div>

  <div class="card-b" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>#Incidencia</th>
          <th>#Contrato</th>
          <th>Cliente</th>
          <th>Tipo</th>
          <th>Fecha</th>
          <th>Importe</th>
          <th>Estado</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($incidencias as $i): ?>
          <?php
            $estado = $i['estado'] ?? 'pendiente';
            $pillClass = $estado === 'pendiente' ? 'busy' : ($estado === 'registrado' ? 'ok' : 'off');
          ?>
          <tr>
            <td><?= htmlspecialchars($i['id']) ?></td>
            <td><?= htmlspecialchars($i['contrato']) ?></td>
            <td><?= htmlspecialchars($i['cliente']) ?></td>
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
      </tbody>
    </table>

    <div style="padding:16px">
      <p class="small">
        En BD: este listado se obtiene con JOIN (incidencias + contratos + clientes).
      </p>
    </div>
  </div>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
