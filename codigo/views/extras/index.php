<?php

use app\models\Extras;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ExtrasSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Extras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="extras-index">

	<h1><?= Html::encode($this->title) ?></h1>

	<p>
		<?= Html::a('Create Extras', ['create'], ['class' => 'btn btn-success']) ?>
	</p>

	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'id_extra',
			'concepto',
			'precio',
			'tipo_calculo',
			[
				'class' => ActionColumn::className(),
				'urlCreator' => function ($action, Extras $model, $key, $index, $column) {
					return Url::toRoute([$action, 'id_extra' => $model->id_extra]);
				 }
			],
		],
	]); ?>


</div>
