<?php


session_start();

$pageTitle = "Admin - Vehículos";
$active = "vehiculos";
include __DIR__ . "/../vistas/header_admin.php";

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Listado:
    SELECT id, marca, modelo, categoria, precio_dia, estado, historico
    FROM vehiculos
    ORDER BY id DESC;

  Alta / Editar:
    - Si viene id => UPDATE
    - Si no viene id => INSERT

  Baja lógica:
    UPDATE vehiculos SET historico='baja' WHERE id = ?

  NOTA:
  - Evitar borrar físicamente si hay contratos históricos asociados.
*/


$vehiculos = $vehiculos ?? [
  ['id'=>1,'marca'=>'Toyota','modelo'=>'Yaris','categoria'=>'Compacto','precio_dia'=>35,'estado'=>'activo','historico'=>'en_flota'],
  ['id'=>2,'marca'=>'Nissan','modelo'=>'Qashqai','categoria'=>'SUV','precio_dia'=>55,'estado'=>'alquilado','historico'=>'en_flota'],
  ['id'=>3,'marca'=>'BMW','modelo'=>'Serie 1','categoria'=>'Lujo','precio_dia'=>79,'estado'=>'taller','historico'=>'baja'],
];
?>

<section class="hero">
  <h1 class="h-title">Vehículos</h1>
  <p class="h-sub">Gestión de flota (alta, edición y baja lógica).</p>
</section>

<section class="card">
  <div class="card-h">
    <h3>Alta / Editar vehículo</h3>
    <span class="small">POST</span>
  </div>

  <div class="card-b">
    <!-- =====================================================
         FORMULARIO GUARDAR (POST)
         Controlador sugerido: /controladores/admin/vehiculo_guardar.php

         En backend (BD):
         - Si viene id => UPDATE
         - Si no viene id => INSERT
         ===================================================== -->
    <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/admin/vehiculo_guardar.php" method="post">

      <!-- id opcional: si se rellena, se interpreta como edición -->
      <div class="field">
        <div class="label">ID (solo para editar)</div>
        <input type="number" name="id" min="1" placeholder="Ej. 3">
      </div>

      <div class="row3">
        <div class="field">
          <div class="label">Marca</div>
          <input name="marca" required>
        </div>

        <div class="field">
          <div class="label">Modelo</div>
          <input name="modelo" required>
        </div>

        <div class="field">
          <div class="label">Categoría</div>
          <select name="categoria" required>
            <option value="">Seleccionar</option>
            <option value="Compacto">Compacto</option>
            <option value="SUV">SUV</option>
            <option value="Familiar">Familiar</option>
            <option value="Lujo">Lujo</option>
          </select>
        </div>
      </div>

      <div class="row3">
        <div class="field">
          <div class="label">Precio / día (€)</div>
          <input type="number" min="0" step="0.01" name="precio_dia" required>
        </div>

        <div class="field">
          <div class="label">Estado</div>
          <select name="estado" required>
            <option value="activo">Activo</option>
            <option value="taller">Taller</option>
            <option value="alquilado">Alquilado</option>
          </select>
        </div>

        <div class="field">
          <div class="label">Histórico</div>
          <select name="historico" required>
            <option value="en_flota">En flota</option>
            <option value="baja">Baja (soft delete)</option>
          </select>
        </div>
      </div>

      <div class="actions">
        <button class="btn primary" type="submit">Guardar</button>
      </div>

      <hr class="sep"/>

      <p class="small">
        En BD: se recomienda baja lógica para conservar contratos históricos.
      </p>
    </form>
  </div>
</section>

<div style="height:14px"></div>

<section class="card">
  <div class="card-h">
    <h3>Listado de vehículos</h3>
    <span class="small"><?= count($vehiculos) ?> registros</span>
  </div>

  <div class="card-b" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Marca</th>
          <th>Modelo</th>
          <th>Categoría</th>
          <th>Precio/día</th>
          <th>Estado</th>
          <th>Histórico</th>
          <th>Acción</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($vehiculos as $v): ?>
          <tr>
            <td><?= (int)$v['id'] ?></td>
            <td><?= htmlspecialchars($v['marca']) ?></td>
            <td><?= htmlspecialchars($v['modelo']) ?></td>
            <td><?= htmlspecialchars($v['categoria']) ?></td>
            <td><?= (float)$v['precio_dia'] ?>€</td>
            <td><?= htmlspecialchars($v['estado']) ?></td>
            <td><?= htmlspecialchars($v['historico']) ?></td>
            <td>
              <!-- =================================================
                   BAJA (POST)
                   Controlador sugerido: /controladores/admin/vehiculo_baja.php
                   En BD: UPDATE historico='baja'
                   ================================================= -->
              <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/admin/vehiculo_baja.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= (int)$v['id'] ?>">
                <button class="btn danger" type="submit">Baja</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
