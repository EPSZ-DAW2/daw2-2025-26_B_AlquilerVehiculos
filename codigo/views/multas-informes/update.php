<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MultasInformes $model */

$this->title = 'Update Multas Informes: ' . $model->id_informe;
$this->params['breadcrumbs'][] = ['label' => 'Multas Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_informe, 'url' => ['view', 'id_informe' => $model->id_informe]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="multas-informes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
