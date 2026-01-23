<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Reservas $model */

$this->title = 'Reserva #' . $model->id_reserva;
?>
<section class="card">
		<div class="card-h">
				<h3>📄 Detalle de Reserva #<?= $model->id_reserva ?></h3>
				
				<div class="actions">
						<?= Html::a('Editar', ['update', 'id_reserva' => $model->id_reserva], ['class' => 'btn primary']) ?>
						<?= Html::a('Borrar', ['delete', 'id_reserva' => $model->id_reserva], [
								'class' => 'btn danger',
								'data' => [
										'confirm' => '¿Seguro que quieres borrar esta reserva?',
										'method' => 'post',
								],
						]) ?>
						<?= Html::a('Volver', ['index'], ['class' => 'btn']) ?>
				</div>
		</div>

		<div class="card-b">
				<?= DetailView::widget([
						'model' => $model,
						'options' => ['class' => 'table table-striped table-hover detail-view'],
						'attributes' => [
								'id_reserva',
								[
										'label' => 'Cliente',
										'value' => $model->usuario ? $model->usuario->nombre : 'Desconocido',
								],
								[
										'label' => 'Vehículo',
										'value' => $model->vehiculo ? $model->vehiculo->marca . ' ' . $model->vehiculo->modelo : 'Desconocido',
								],
								'fecha_creacion:datetime',
								'fecha_inicio:date',
								'fecha_fin:date',
								'coste_total:currency',
								'estado_reserva',
						],
				]) ?>
		</div>
</section>