<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  SEGURIDAD (OBLIGATORIO EN BACKEND)
  ================================
  En Yii2:
  - Proteger la ruta en AdminController
  - Validar rol=admin
*/

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

  Acciones posibles:
    - Cambiar estado (UPDATE)
    - Cancelar (UPDATE estado='cancelada')
*/

$this->title = 'Admin - Contratos';

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
            <td><?= Html::encode($c['id']) ?></td>
            <td><?= Html::encode($c['cliente']) ?></td>
            <td><?= Html::encode($c['vehiculo']) ?></td>
            <td><?= Html::encode($c['inicio']) ?></td>
            <td><?= Html::encode($c['fin']) ?></td>
            <td><?= (float)$c['total'] ?>€</td>
            <td>
              <span class="pill <?= Html::encode($pillClass) ?>" style="position:static">
                <?= Html::encode(ucfirst($estado)) ?>
              </span>
            </td>
            <td>
              <!-- =================================================
                   ACCIÓN (POST)
                   En Yii2: apuntar a una acción del AdminController.
                   Ejemplo: admin/contrato-estado
                   En backend (BD):
                   - UPDATE contratos SET estado=? WHERE id=?
                   - Validar reglas (no activar si vehículo no disponible)
                   ================================================= -->
              <?= Html::beginForm(Url::to(['admin/contrato-estado']), 'post', ['style' => 'display:inline;']) ?>
                <?= Html::hiddenInput('id_contrato', $c['id']) ?>
                <?= Html::hiddenInput('nuevo_estado', 'cancelada') ?>
                <button class="btn danger" type="submit">Cancelar</button>
              <?= Html::endForm() ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div style="padding:16px">
      <p class="small">
        En BD: este listado se obtiene con JOIN (contratos + clientes + vehículos).
      </p>

      <div class="actions">
        <a class="btn" href="<?= Html::encode(Url::to(['admin/dashboard'])) ?>">Volver al dashboard</a>
      </div>
    </div>
  </div>
</section>
