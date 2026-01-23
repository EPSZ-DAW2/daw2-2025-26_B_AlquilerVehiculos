<?php

use app\models\Usuarios;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuariosSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Gestión de Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuarios-index">

		<h1><?= Html::encode($this->title) ?></h1>

		<p>
				<?= Html::a('Crear Nuevo Usuario', ['create'], ['class' => 'btn primary']) ?>
		</p>

		<div class="card" style="padding: 10px; background: rgba(0,0,0,0.2);">
				<?= GridView::widget([
						'dataProvider' => $dataProvider,
						'filterModel' => $searchModel,
						'summary' => "Mostrando {begin}-{end} de {totalCount} usuarios",
						'columns' => [
								['class' => 'yii\grid\SerialColumn'],

								'id_usuario',
								'nombre',
								'email:email',
								'dni',
								'edad',
								[
										'attribute' => 'rol',
										'filter' => ['Admin' => 'Admin', 'Cliente' => 'Cliente'],
										'value' => function ($model) {
												return $model->rol;
										},
										'contentOptions' => function ($model) {
												return $model->rol == 'Admin' ? ['style' => 'color: var(--brand); font-weight:bold;'] : [];
										}
								],
								[
										'attribute' => 'menor_25',
										'format' => 'boolean',
										'label' => '< 25 años',
								],

								[
										'class' => ActionColumn::className(),
										'urlCreator' => function ($action, Usuarios $model, $key, $index, $column) {
												return Url::toRoute([$action, 'id_usuario' => $model->id_usuario]);
										 }
								],
						],
				]); ?>
		</div>

</div>