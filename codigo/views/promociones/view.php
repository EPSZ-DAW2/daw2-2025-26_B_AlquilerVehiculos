<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Promociones $model */

$this->title = $model->id_promocion;
$this->params['breadcrumbs'][] = ['label' => 'Promociones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="promociones-view">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Update', ['update', 'id_promocion' => $model->id_promocion], ['class' => 'btn btn-primary']) ?>
		<?= Html::a('Delete', ['delete', 'id_promocion' => $model->id_promocion], [
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
			'id_promocion',
			'nombre_promo',
			'codigo_descuento',
			'porcentaje_descuento',
			'es_para_estudiantes',
			'fecha_limite',
		],
	]) ?>

</div>
