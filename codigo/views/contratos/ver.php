<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Reservas $reserva */
/** @var app\models\Contratos|null $contrato */

$this->title = 'Contrato #' . $reserva->id_reserva;

$baseImponible = $reserva->coste_total / 1.21;
$iva = $reserva->coste_total - $baseImponible;

$f1 = new DateTime($reserva->fecha_inicio);
$f2 = new DateTime($reserva->fecha_fin);
$dias = $f1->diff($f2)->days;
if ($dias < 1) $dias = 1;

$estadoReserva = ucfirst($reserva->estado_reserva);
$estadoContrato = $contrato ? ucfirst($contrato->estado_contrato) : 'Pendiente de firma';

?>

<section class="hero">
  <h1 class="h-title">Contrato de Alquiler</h1>
  <p class="h-sub">
	Referencia: <strong><?= substr(md5($reserva->id_reserva), 0, 8) ?></strong> • 
	Fecha solicitud: <?= Yii::$app->formatter->asDate($reserva->fecha_creacion, 'php:d/m/Y') ?>
  </p>
</section>

<section class="split">
  
  <section class="card">
	<div class="card-h">
	  <h3>Datos del Titular y Vehículo</h3>
	</div>

	<div class="card-b">
	  <div class="notice">
		<div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
			<div><strong>Titular:</strong><br> <?= Html::encode($reserva->usuario->nombre) ?></div>
			<div><strong>DNI/NIF:</strong><br> <?= Html::encode($reserva->usuario->dni) ?></div>
			<div><strong>Email:</strong><br> <?= Html::encode($reserva->usuario->email) ?></div>
			<div><strong>Estado Reserva:</strong><br> <span style="color:var(--brand)"><?= $estadoReserva ?></span></div>
		</div>
	  </div>

	  <hr class="sep"/>

	  <h4 style="font-size:14px; color:var(--muted); margin-bottom:10px">Vehículo Asignado</h4>
	  <div class="row2">
		<div class="field">
		  <div class="label">Marca y Modelo</div>
		  <input type="text" value="<?= Html::encode($reserva->vehiculo->marca . ' ' . $reserva->vehiculo->modelo) ?>" readonly>
		</div>
		<div class="field">
		  <div class="label">Matrícula</div>
		  <input type="text" value="<?= Html::encode($reserva->vehiculo->matricula) ?>" readonly>
		</div>
	  </div>

	  <div class="row2">
		<div class="field">
		  <div class="label">Fecha Recogida</div>
		  <input type="text" value="<?= Yii::$app->formatter->asDate($reserva->fecha_inicio, 'php:d/m/Y') ?>" readonly>
		</div>
		<div class="field">
		  <div class="label">Fecha Devolución</div>
		  <input type="text" value="<?= Yii::$app->formatter->asDate($reserva->fecha_fin, 'php:d/m/Y') ?>" readonly>
		</div>
	  </div>

	  <hr class="sep"/>
	  
	  <?php if ($contrato): ?>
		  <div class="notice" style="border-left: 4px solid var(--ok); background: rgba(0, 255, 0, 0.05);">
			<h4 style="margin-top:0; color:var(--ok)">✅ Contrato Activo</h4>
			<ul style="list-style:none; padding:0; margin:0; font-size:0.9em;">
				
				<li><strong>Fecha Firma:</strong> <?= Yii::$app->formatter->asDatetime($contrato->fecha_firma) ?></li>
				<li><strong>Kilómetros Entrega:</strong> <?= $contrato->km_entrega ?> km</li>
				
				<li style="margin-top:10px; border-top:1px dashed var(--border); padding-top:5px;">
					<strong>Devolución el:</strong> 
					<?php 
						if($contrato->fecha_devolucion_real) {
							echo Yii::$app->formatter->asDatetime($contrato->fecha_devolucion_real);
						} else {
							echo Yii::$app->formatter->asDate($reserva->fecha_fin, 'php:d/m/Y') . " <small style='color:var(--muted)'>(Prevista)</small>";
						}
					?>
				</li>

				<li>
					<strong>Km Devolución:</strong> 
					<?php if(!empty($contrato->km_devolucion)): ?>
						<?= $contrato->km_devolucion ?> km
					<?php else: ?>
						<span style="color:var(--muted); font-style:italic;">Por determinar</span>
					<?php endif; ?>
				</li>

			</ul>
		  </div>
	  <?php else: ?>
		  <div class="notice" style="border-left: 4px solid var(--warn); background: rgba(255, 165, 0, 0.05);">
			<h4 style="margin-top:0; color:var(--warn)">⏳ Pre-contrato</h4>
			<p style="font-size:0.9em; margin:0;">
				El vehículo aún no ha sido retirado. Los datos de kilometraje y la firma legal se registrarán en la oficina al momento de la entrega de llaves.
			</p>
		  </div>
	  <?php endif; ?>

	</div>
  </section>

  <aside class="card" style="height: fit-content;">
	<div class="card-h">
	  <h3>Resumen Económico</h3>
	</div>

	<div class="card-b">
	  <div class="kv">
		<div class="box"><div class="k">Duración</div><div class="v"><?= $dias ?> días</div></div>
		<div class="box"><div class="k">Tarifa</div><div class="v"><?= $reserva->vehiculo->categoria->precio_dia ?>€/día</div></div>
	  </div>

	  <hr class="sep"/>

	  <table style="width:100%; font-size:0.9em; color:var(--text);">
		<tr>
			<td style="padding:4px 0; color:var(--muted)">Base Imponible</td>
			<td style="text-align:right"><?= number_format($baseImponible, 2) ?>€</td>
		</tr>
		<tr>
			<td style="padding:4px 0; color:var(--muted)">IVA (21%)</td>
			<td style="text-align:right"><?= number_format($iva, 2) ?>€</td>
		</tr>
		<tr style="font-size:1.2em; font-weight:bold; border-top:1px solid var(--border);">
			<td style="padding-top:10px;">TOTAL</td>
			<td style="padding-top:10px; text-align:right; color:var(--brand)"><?= number_format($reserva->coste_total, 2) ?>€</td>
		</tr>
	  </table>

	  <hr class="sep"/>

	  <div class="actions" style="flex-direction: column; gap: 10px;">
		
		<?php if (Yii::$app->user->identity->rol === 'Admin'): ?>
			
			<?php if (!$contrato): ?>
				<div class="notice" style="border-color: var(--brand); background: rgba(59,130,246,0.1); width: 100%;">
					<strong>Panel de Administración</strong><br>
					Este vehículo está reservado pero aún no se ha formalizado la entrega.
				</div>

				<?= Html::a('📝 Formalizar Contrato (Entregar Llaves)', ['create', 'id_reserva' => $reserva->id_reserva], [
					'class' => 'btn primary', 
					'style' => 'width:100%; justify-content:center; font-weight:bold',
					'data' => [
						'confirm' => '¿Estás seguro de formalizar este contrato? Una vez firmado, pasará a estado ACTIVO y se generará la fecha de entrega. No se podrá cancelar.',
						'method' => 'post',
					],
				]) ?>

			<?php else: ?>
				<button class="btn ok" onclick="window.print()" style="width:100%; justify-content:center">
					🖨️ Imprimir Contrato Oficial
				</button>
				
				<?php if ($contrato->estado_contrato === 'Activo'): ?>
					<?= Html::a('🔄 Registrar Devolución', ['update', 'id_contrato' => $contrato->id_contrato], [
						'class' => 'btn',
						'style' => 'width:100%; justify-content:center; margin-top:5px',
					]) ?>
				<?php endif; ?>

			<?php endif; ?>

		<?php else: ?>
			
			<?php if ($contrato): ?>
				<button class="btn primary" onclick="window.print()" style="width:100%">
					🖨️ Descargar Copia
				</button>
			<?php else: ?>
				<button class="btn" disabled style="width:100%; opacity:0.6; cursor:not-allowed">
					Pendiente de firma en oficina
				</button>
			<?php endif; ?>

		<?php endif; ?>
		
		<a class="btn" href="<?= Url::to(['reservas/index']) ?>" style="width:100%; text-align:center; opacity:0.8; margin-top:10px">
			Volver al listado
		</a>
	  </div>

	</div>
  </aside>

</section>