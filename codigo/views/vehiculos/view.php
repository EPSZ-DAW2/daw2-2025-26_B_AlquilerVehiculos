<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Vehiculos $model */

$this->title = $model->id_vehiculo;
$this->params['breadcrumbs'][] = ['label' => 'Vehiculos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="vehiculos-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id_vehiculo' => $model->id_vehiculo], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id_vehiculo' => $model->id_vehiculo], [
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
			'id_vehiculo',
			'matricula',
			'marca',
			'modelo',
			'id_categoria',
			'estado',
			'fecha_baja_logica',
		],
	]) ?>

</div>
