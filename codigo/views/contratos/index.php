<?php

use app\models\Contratos;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Contratos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contratos-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Contratos', ['create'], ['class' => 'btn btn-success']) ?>
	</p>


	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id_contrato',
			'id_reserva',
			'fecha_firma',
			'estado_contrato',
			'fecha_devolucion_real',
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, Contratos $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id_contrato' => $model->id_contrato]);
				 }
			],
		],
	]); ?>


</div>
