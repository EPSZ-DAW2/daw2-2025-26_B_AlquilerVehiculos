<?php
use yii\helpers\Html;
use yii\helpers\Url;

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

$this->title = $this->title ?: 'Incidencias';

// Demo para render sin BD (el backend lo reemplazará)
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
                // Igual que el antiguo:
                // pendiente => busy, registrado => ok, otro => off
                $pillClass = ($estado === 'pendiente') ? 'busy' : (($estado === 'registrado') ? 'ok' : 'off');
              ?>
              <tr>
                <td><?= Html::encode($i['id'] ?? '-') ?></td>
                <td><?= Html::encode($i['contrato'] ?? '-') ?></td>
                <td><?= Html::encode($i['tipo'] ?? '-') ?></td>
                <td><?= Html::encode($i['fecha'] ?? '-') ?></td>
                <td><?= (float)($i['importe'] ?? 0) ?>€</td>
                <td>
                  <span class="pill <?= Html::encode($pillClass) ?>" style="position:static">
                    <?= Html::encode(ucfirst($estado)) ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

      <div style="padding:16px">
        <div class="actions">
          <a class="btn" href="<?= Html::encode(Url::to(['reserva/mis-reservas'])) ?>">Mis reservas</a>
          <a class="btn primary" href="<?= Html::encode(Url::to(['vehiculo/index'])) ?>">Ver flota</a>
        </div>

        <hr class="sep"/>

        <p class="small">
          En BD: incidencias -> contrato (FK) -> cliente (FK) para filtrar por sesión.
        </p>
      </div>
    </div>
  </section>
</section>
