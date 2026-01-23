<?php

use app\models\Promociones;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PromocionesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Promociones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promociones-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Promociones', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id_promocion',
			'nombre_promo',
			'codigo_descuento',
			'porcentaje_descuento',
			'es_para_estudiantes',
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, Promociones $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id_promocion' => $model->id_promocion]);
				 }
			],
		],
	]); ?>


</div>
