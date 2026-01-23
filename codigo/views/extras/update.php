<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Extras $model */

$this->title = 'Update Extras: ' . $model->id_extra;
$this->params['breadcrumbs'][] = ['label' => 'Extras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_extra, 'url' => ['view', 'id_extra' => $model->id_extra]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="extras-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>
