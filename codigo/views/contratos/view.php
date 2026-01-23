<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Contratos $model */

$this->title = $model->id_contrato;
$this->params['breadcrumbs'][] = ['label' => 'Contratos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="contratos-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id_contrato' => $model->id_contrato], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id_contrato' => $model->id_contrato], [
			'class' => 'btn btn-danger',
			'data' => [
				'confirm' => 'Are you sure you want to delete this item?',
				'method' => 'post',
			],
		]) ?>
	</p>

	<?= DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id_contrato',
			'id_reserva',
			'fecha_firma',
			'estado_contrato',
			'fecha_devolucion_real',
			'km_entrega',
			'km_devolucion',
		],
	]) ?>

</div>
