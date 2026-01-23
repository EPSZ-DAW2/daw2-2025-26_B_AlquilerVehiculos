<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Reservas[] $reservas */

$this->title = 'Mis Reservas';
?>

<section class="hero">
	<h1 class="h-title">Mis reservas</h1>
	<p class="h-sub">Historial de tus reservas y alquileres.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
	<section class="card">
	<div class="card-h">
		<h3>Listado</h3>
		<span class="small"><?= count($reservas) ?> reservas encontradas</span>
	</div>

	<div class="card-b" style="padding:0">
		
		<?php if (empty($reservas)): ?>
		<div style="padding:30px; text-align:center; color:var(--muted)">
			<p>Todavía no has realizado ninguna reserva.</p>
			<a class="btn primary" href="<?= Url::to(['vehiculos/flota']) ?>">Ver coches disponibles</a>
		</div>
		<?php else: ?>

		<div style="overflow-x:auto"> <table class="table">
			<thead>
				<tr>
				<th>#</th>
				<th>Vehículo</th>
				<th>Inicio</th>
				<th>Fin</th>
				<th>Total</th>
				<th>Estado</th>
				<th>Acciones</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($reservas as $r): ?>
				<?php
					$estado = $r->estado_reserva;
					$pillClass = 'busy'; 
					
					if ($estado === 'Confirmada') $pillClass = 'ok';
					if ($estado === 'Cancelada')	$pillClass = 'off';
					if ($estado === 'Finalizada') $pillClass = 'default';

					$nombreVehiculo = $r->vehiculo 
						? $r->vehiculo->marca . ' ' . $r->vehiculo->modelo 
						: '<span style="color:var(--danger)">Vehículo no disponible</span>';
				?>
				<tr>
					<td><span style="color:var(--muted)">#<?= $r->id_reserva ?></span></td>
					<td style="font-weight:700; color:#fff"><?= $nombreVehiculo ?></td>
					<td><?= Yii::$app->formatter->asDate($r->fecha_inicio, 'php:d/m/Y') ?></td>
					<td><?= Yii::$app->formatter->asDate($r->fecha_fin, 'php:d/m/Y') ?></td>
					<td style="font-weight:bold"><?= $r->coste_total ?>€</td>
					
					<td>
					<span class="pill <?= $pillClass ?>" style="position:static; display:inline-block">
						<?= ucfirst($estado) ?>
					</span>
					</td>
					
					<td style="display:flex; gap:10px; align-items:center">
					
					<?php if ($estado === 'Confirmada'): ?>
						
						<?= Html::a('Cancelar', ['cancelar', 'id_reserva' => $r->id_reserva], [
							'class' => 'btn danger',
							'style' => 'padding:6px 12px; font-size:12px',
							'data' => [
								'confirm' => '¿Estás seguro de que quieres cancelar esta reserva? Esta acción no se puede deshacer.',
								'method' => 'post',
							],
						]) ?>

						<a class="btn" href="<?= Url::to(['contratos/ver', 'id_reserva' => $r->id_reserva]) ?>">
						📄 Contrato
						</a>

					<?php else: ?>
						<span style="color:var(--muted); font-size:12px">Sin acciones</span>
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
			<a class="btn primary" href="<?= Url::to(['vehiculos/flota']) ?>">Nueva reserva</a>
			<a class="btn" href="<?= Url::to(['multas-informes/mis-incidencias']) ?>">Mis Incidencias</a>
		</div>
		</div>
	
	</div>
	</section>
</section>