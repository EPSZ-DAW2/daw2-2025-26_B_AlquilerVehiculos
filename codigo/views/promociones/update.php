<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Promociones $model */

$this->title = 'Update Promociones: ' . $model->id_promocion;
$this->params['breadcrumbs'][] = ['label' => 'Promociones', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_promocion, 'url' => ['view', 'id_promocion' => $model->id_promocion]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="promociones-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
