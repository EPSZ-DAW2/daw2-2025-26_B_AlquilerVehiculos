<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Categorias; 

/** @var yii\web\View $this */
/** @var app\models\VehiculosPublicSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Flota Disponible';
?>

<section class="hero">
  <h1 class="h-title">Flota disponible</h1>
  <p class="h-sub">Encuentra el vehículo perfecto para tu viaje.</p>
</section>

<section class="grid">
  
  <aside class="card" style="height: fit-content;">
	<div class="card-h">
	  <h3>🔍 Filtros</h3>
	</div>
	<div class="card-b">
	  <?php $form = ActiveForm::begin([
		  'action' => ['flota'],
		  'method' => 'get',
		  'fieldConfig' => [
			  'template' => "<div class=\"field\">{label}\n{input}</div>", 
			  'labelOptions' => ['class' => 'label']
		  ],
	  ]); ?>

		<?php 
			$listaCategorias = \yii\helpers\ArrayHelper::map(Categorias::find()->all(), 'id_categoria', 'nombre_grupo');
		?>
		
		<?= $form->field($searchModel, 'id_categoria')->dropDownList(
			$listaCategorias, 
			['prompt' => 'Todas las categorías']
		)->label('Categoría') ?>

		<?= $form->field($searchModel, 'precio_max')->input('number', ['placeholder' => 'Ej: 100'])->label('Precio máx (€/día)') ?>

		<div class="actions" style="margin-top:20px;">
		  <?= Html::submitButton('Filtrar', ['class' => 'btn primary', 'style' => 'flex:1']) ?>
		  <a class="btn" href="<?= Url::to(['vehiculos/flota']) ?>">Limpiar</a>
		</div>
	  
	  <?php ActiveForm::end(); ?>
	</div>
  </aside>

  <section class="card">
	<div class="card-h">
	  <h3>Resultados</h3>
	  <span class="small"><?= $dataProvider->getTotalCount() ?> vehículos encontrados</span>
	</div>

	<div class="card-b">
	  
	  <?php if ($dataProvider->getCount() == 0): ?>
		<div class="notice">No hay vehículos disponibles con esos filtros.</div>
	  <?php else: ?>
		
		<div class="list">
		  <?php foreach ($dataProvider->getModels() as $vehiculo): ?>
			<?php
			  $catNombre = $vehiculo->categoria ? $vehiculo->categoria->nombre_grupo : 'Sin Categoría';
			  $catPrecio = $vehiculo->categoria ? $vehiculo->categoria->precio_dia : 0;
			  $catPlazas = $vehiculo->categoria && isset($vehiculo->categoria->plazas) ? $vehiculo->categoria->plazas : '5'; 

			  $estaReservadoHoy = $vehiculo->estaReservado;
			  $estadoGlobal = $vehiculo->estado;

			  $textoBoton = "Reservar";
			  $claseBoton = "btn good";
			  $botonDesactivado = false;
			  
			  $textoEtiqueta = "Disponible";
			  $claseEtiqueta = "ok";

			  if ($estadoGlobal !== 'Activo') {
				  $textoEtiqueta = "No disponible";
				  $claseEtiqueta = "off";
				  $botonDesactivado = true;
				  $textoBoton = "No disponible";
			  }
			  elseif ($estaReservadoHoy) {
				  $textoEtiqueta = "Reservado";
				  $claseEtiqueta = "busy";
				  $botonDesactivado = true;
				  $textoBoton = "Ocupado hoy";
			  }

			  $imgUrl = $vehiculo->imagen_url 
				  ? Url::to('@web/' . $vehiculo->imagen_url) 
				  : Url::to('@web/recursos/img/coche_default.png');
			?>

			<article class="vehicle">
			  <div class="thumb">
				<img src="<?= $imgUrl ?>" alt="<?= Html::encode($vehiculo->marca) ?>" loading="lazy">
				<span class="pill <?= $claseEtiqueta ?>"><?= $textoEtiqueta ?></span>
			  </div>

			  <div class="v-body">
				<h4 class="v-title">
					<?= Html::encode($vehiculo->marca) ?> <?= Html::encode($vehiculo->modelo) ?>
				</h4>

				<div class="meta">
				  <span><?= Html::encode($catNombre) ?></span><span>•</span>
				  <span><?= $catPlazas ?> plazas</span><span>•</span>
				  <span><?= Html::encode($vehiculo->matricula) ?></span>
				</div>

				<div class="price">
				  <strong><?= $catPrecio ?>€ <span style="font-size:12px; font-weight:400; color:var(--muted)">/día</span></strong>
				  
				  <?php if (!$botonDesactivado): ?>
					<a class="<?= $claseBoton ?>" href="<?= Url::to(['reservas/reservar', 'id_vehiculo' => $vehiculo->id_vehiculo]) ?>">
						<?= $textoBoton ?>
					</a>
				  <?php else: ?>
					<button class="btn" disabled style="opacity:.5; cursor:not-allowed; background:rgba(255,255,255,0.05)">
						<?= $textoBoton ?>
					</button>
				  <?php endif; ?>
				</div>
			  </div>
			</article>

		  <?php endforeach; ?>
		</div>
		
		<div style="margin-top: 20px; text-align: center;">
			<?= \yii\widgets\LinkPager::widget(['pagination' => $dataProvider->pagination]) ?>
		</div>

	  <?php endif; ?>

	</div>
  </section>

</section>