<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista debe recibir desde el controlador un array $incidencias.

  Estructura esperada:
  $incidencias = [
    [
      'id_incidencia' => 10,
      'id_reserva' => 25,
      'tipo' => 'Multa',            // o 'Informe'
      'fecha' => '2026-01-05',
      'importe' => 120.00,
      'estado' => 'Pendiente',      // Pendiente / Resuelta / Registrada...
      'descripcion' => '...'        // opcional
    ],
    ...
  ];

  Tablas implicadas:
  - multas_informes
  - reservas

  NOTA PARA BD:
  - Listar incidencias del usuario autenticado.
  - Se obtiene con JOIN:
      multas_informes -> reservas
    filtrando por reservas.id_usuario.
*/

$incidencias = $incidencias ?? []; // demo para render
?>

<section class="hero">
  <h1 class="h-title">Incidencias</h1>
  <p class="h-sub">Multas e informes relacionados con tus reservas.</p>
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
            <th>ID</th>
            <th>Reserva</th>
            <th>Tipo</th>
            <th>Fecha</th>
            <th>Importe</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($incidencias)): ?>
            <tr>
              <td colspan="6">No hay incidencias registradas.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($incidencias as $i): ?>
              <?php
                $estado = $i['estado'] ?? '';
                $pillClass = 'ok';
                if (stripos($estado, 'pend') !== false) $pillClass = 'busy';
                if (stripos($estado, 'baja') !== false) $pillClass = 'off';
              ?>
              <tr>
                <td><?= Html::encode($i['id_incidencia'] ?? '-') ?></td>
                <td><?= Html::encode($i['id_reserva'] ?? '-') ?></td>
                <td><?= Html::encode($i['tipo'] ?? '-') ?></td>
                <td><?= Html::encode($i['fecha'] ?? '-') ?></td>
                <td><?= Html::encode($i['importe'] ?? 0) ?> €</td>
                <td>
                  <span class="pill <?= Html::encode($pillClass) ?>" style="position:static;">
                    <?= Html::encode($estado ?: '-') ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>

      <div style="padding:16px">
        <div class="actions">
          <a class="btn" href="<?= Url::to(['vehiculo/index']) ?>">Flota</a>
          <a class="btn good" href="<?= Url::to(['reserva/contrato']) ?>">Contrato</a>
          <a class="btn" href="<?= Url::to(['user/perfil']) ?>">Perfil</a>
        </div>

        <hr class="sep">
        <p class="small">
          En BD: JOIN <strong>multas_informes</strong> con <strong>reservas</strong> filtrando por el usuario.
        </p>
      </div>
    </div>
  </section>
</section>
