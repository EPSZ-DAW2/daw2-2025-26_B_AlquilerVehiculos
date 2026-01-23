<?php

use app\models\Reservas;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReservasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestión de Reservas';
?>
<section class="card" style="min-height: 80vh;">
	<div class="card-h">
		<h3>📅 Gestión de Reservas</h3>
	</div>

	<div class="card-b">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'tableOptions' => ['class' => 'table table-striped table-hover'],
			'layout' => "{summary}\n{items}\n{pager}",
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],
				'id_reserva',
				[
					'attribute' => 'id_usuario',
					'value' => function ($model) {
						return $model->usuario ? $model->usuario->nombre : 'Usuario borrado';
					},
					'label' => 'Cliente',
				],
				[
					'attribute' => 'id_vehiculo',
					'value' => function ($model) {
						return $model->vehiculo ? $model->vehiculo->marca . ' ' . $model->vehiculo->modelo : 'Vehículo borrado';
					},
					'label' => 'Vehículo',
				],
				'fecha_inicio:date',
				'fecha_fin:date',
				'coste_total:currency',
				[
					'attribute' => 'estado_reserva',
					'format' => 'raw',
					'value' => function ($model) {
						$color = 'var(--muted)';
						if ($model->estado_reserva === 'Confirmada') $color = 'var(--ok)';
						if ($model->estado_reserva === 'Cancelada') $color = 'var(--danger)';
						return "<span style='color:{$color}; font-weight:bold'>{$model->estado_reserva}</span>";
					},
					'filter' => ['Confirmada' => 'Confirmada', 'Finalizada' => 'Finalizada', 'Cancelada' => 'Cancelada'],
				],
				[
				'class' => ActionColumn::className(),
				'template' => '{contrato} {view} {update} {delete}',
				'buttons' => [
					'contrato' => function ($url, $model, $key) {
						if ($model->contrato) {
							return Html::a('📄', ['contratos/view', 'id_contrato' => $model->contrato->id_contrato], [
								'class' => 'btn-action btn-ok',
								'title' => 'Ver Contrato Firmado',
								'data-pjax' => '0',
							]);
						}
						elseif ($model->estado_reserva === 'Confirmada') {
							return Html::a('📝', ['contratos/create', 'id_reserva' => $model->id_reserva], [
								'class' => 'btn-action btn-primary',
								'title' => 'Formalizar Contrato (Entrega)',
								'data-pjax' => '0',
							]);
						}
						return '';
					},
				],
				'buttonOptions' => ['class' => 'btn-action'], 
			],
			],
		]); ?>
	</div>
</section>