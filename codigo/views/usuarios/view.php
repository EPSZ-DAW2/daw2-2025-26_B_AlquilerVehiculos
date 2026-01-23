<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Usuarios $model */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuarios-view">

		<h1><?= Html::encode($this->title) ?></h1>

		<p>
				<?= Html::a('Editar (Update)', ['update', 'id_usuario' => $model->id_usuario], ['class' => 'btn primary']) ?>
				<?= Html::a('Borrar', ['delete', 'id_usuario' => $model->id_usuario], [
						'class' => 'btn danger',
						'data' => [
								'confirm' => '¿Estás seguro de que quieres borrar este usuario?',
								'method' => 'post',
						],
				]) ?>
		</p>

		<div class="card" style="padding: 20px; background: rgba(0,0,0,0.2);">
				<?= DetailView::widget([
						'model' => $model,
						'attributes' => [
								'id_usuario',
								'nombre',
								'email:email',
								'dni',
								'edad',
								'rol',
								[
									'attribute' => 'menor_25',
									'format' => 'boolean',
									'label' => '¿Es Menor de 25?',
								],
						],
						'options' => ['class' => 'table table-striped table-bordered detail-view', 'style' => 'color: var(--text);'],
				]) ?>
		</div>

</div>