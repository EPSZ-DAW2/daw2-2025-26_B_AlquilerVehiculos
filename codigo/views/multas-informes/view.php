<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\MultasInformes $model */

$this->title = $model->id_informe;
$this->params['breadcrumbs'][] = ['label' => 'Multas Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="multas-informes-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id_informe' => $model->id_informe], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id_informe' => $model->id_informe], [
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
			'id_informe',
			'id_reserva',
			'descripcion:ntext',
			'fecha_incidencia',
			'importe_multa',
		],
	]) ?>

</div>
