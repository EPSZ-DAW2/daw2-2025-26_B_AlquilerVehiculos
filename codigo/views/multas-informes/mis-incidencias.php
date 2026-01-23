<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\MultasInformes[] $incidencias */

$this->title = 'Mis Incidencias';
?>

<section class="hero">
  <h1 class="h-title">Incidencias y Multas</h1>
  <p class="h-sub">Historial de multas, informes de daños o notificaciones en tus alquileres.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
	<div class="card-h">
	  <h3>Listado</h3>
	  <span class="small"><?= count($incidencias) ?> registros encontrados</span>
	</div>

	<div class="card-b" style="padding:0">
	  
	  <?php if (empty($incidencias)): ?>
		<div style="padding:40px; text-align:center; color:var(--muted)">
			<p style="font-size:1.1em">👏 ¡Todo limpio!</p>
			<p>No tienes ninguna multa o incidencia registrada.</p>
		</div>
	  <?php else: ?>
		
		<div style="overflow-x:auto">
		  <table class="table">
			<thead>
			  <tr>
				<th>#ID</th>
				<th>Reserva / Coche</th>
				<th>Descripción (Tipo)</th>
				<th>Fecha</th>
				<th>Importe</th>
				<th>Acciones</th>
			  </tr>
			</thead>

			<tbody>
			  <?php foreach ($incidencias as $incidencia): ?>
				<?php
				  $coche = $incidencia->reserva && $incidencia->reserva->vehiculo 
					  ? $incidencia->reserva->vehiculo->marca . ' ' . $incidencia->reserva->vehiculo->modelo
					  : 'Vehículo no disponible';

				  $tieneMulta = $incidencia->importe_multa > 0;
				  $colorImporte = $tieneMulta ? 'var(--danger)' : 'var(--text)';
				?>
				<tr>
				  <td><span style="color:var(--muted)">#<?= $incidencia->id_informe ?></span></td>
				  
				  <td>
					<div style="font-weight:bold"><?= Html::encode($coche) ?></div>
					<small style="color:var(--muted)">Reserva #<?= $incidencia->id_reserva ?></small>
				  </td>
				  
				  <td><?= Html::encode($incidencia->descripcion) ?></td>
				  
				  <td><?= Yii::$app->formatter->asDate($incidencia->fecha_incidencia, 'php:d/m/Y') ?></td>
				  
				  <td style="font-weight:bold; color:<?= $colorImporte ?>">
					<?= $incidencia->importe_multa ? number_format($incidencia->importe_multa, 2) . '€' : '-' ?>
				  </td>
				  
				  <td>
					<?php if($incidencia->reserva): ?>
						<a href="<?= Url::to(['contratos/ver', 'id_reserva' => $incidencia->id_reserva]) ?>" class="btn" style="padding:4px 10px; font-size:12px">
							Ver Contrato
						</a>
					<?php endif; ?>
				  </td>
				</tr>
			  <?php endforeach; ?>
			</tbody>
		  </table>
		</div>

	  <?php endif; ?>

	  <div style="padding:16px; border-top:1px solid var(--border)">
		<div class="actions">
		  <a class="btn" href="<?= Url::to(['reservas/mis-reservas']) ?>">Volver a Mis Reservas</a>
		  <a class="btn primary" href="<?= Url::to(['vehiculos/flota']) ?>">Nueva Reserva</a>
		</div>
	  </div>
	</div>
  </section>
</section>