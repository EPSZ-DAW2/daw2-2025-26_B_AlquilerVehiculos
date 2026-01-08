<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\MultasInformes $model */

$this->title = 'Create Multas Informes';
$this->params['breadcrumbs'][] = ['label' => 'Multas Informes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="multas-informes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
