<?php

use app\models\MultasInformes;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MultasInformesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Multas Informes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multas-informes-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Multas Informes', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id_informe',
			'id_reserva',
			'descripcion:ntext',
			'fecha_incidencia',
			'importe_multa',
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, MultasInformes $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id_informe' => $model->id_informe]);
				 }
			],
		],
	]); ?>


</div>
