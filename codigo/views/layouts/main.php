<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && (isset(Yii::$app->user->identity->rol) && Yii::$app->user->identity->rol == 'Admin');
$isCliente = !$isGuest && (isset(Yii::$app->user->identity->rol) && Yii::$app->user->identity->rol == 'Cliente');

$nombreUsuario = !$isGuest ? Yii::$app->user->identity->nombre : '';

$controllerId = Yii::$app->controller->id;
$actionId = Yii::$app->controller->action->id;

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php $this->registerCsrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?> - AlquilerCars</title>
	<?php $this->head() ?>
	
	<link rel="stylesheet" href="<?= Url::to('@web/recursos/app.css') ?>?v=5">

	<style>
		.nav .dropdown-toggle {
			color: inherit;
			text-decoration: none;
			padding: 0.5rem 1rem;
			display: inline-block;
			background: none;
			border: none;
		}
		.nav .dropdown-menu {
			margin-top: 0;
			background-color: var(--panel);
			border: 1px solid var(--border);
			box-shadow: 0 4px 8px rgba(0,0,0,0.3);
		}
		.nav .dropdown-item {
			color: var(--muted);
		}
		.nav .dropdown-item:hover {
			background-color: rgba(255,255,255,0.05);
			color: #fff;
		}
	</style>
</head>
<body>
<?php $this->beginBody() ?>

<header class="topbar">
  <div class="container topbar-inner">

	<a class="brand" href="<?= Url::to(['/site/index']) ?>">
	  <img src="<?= Url::to('@web/recursos/img/logo.png') ?>" alt="Logo">
	  <?php if ($isAdmin): ?>
		  <span>AlquilerCars · Admin</span>
	  <?php else: ?>
		  <span>AlquilerCars</span>
	  <?php endif; ?>
	</a>

	<nav class="nav d-flex align-items-center">
		
		<?php if ($isAdmin): ?>
			<a class="<?= $controllerId == 'site' ? 'active' : '' ?>" 
			   href="<?= Url::to(['/site/index']) ?>">Dashboard</a>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					🚗 Flota
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="<?= Url::to(['/vehiculos/index']) ?>">Vehículos</a></li>
					<li><a class="dropdown-item" href="<?= Url::to(['/categorias/index']) ?>">Categorías y Precios</a></li>
					<li><hr class="dropdown-divider" style="border-color:var(--border)"></li>
					<li><a class="dropdown-item" href="<?= Url::to(['/extras/index']) ?>">Extras y Accesorios</a></li>
				</ul>
			</div>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					📅 Operaciones
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="<?= Url::to(['/reservas/index']) ?>">Reservas (Solicitudes)</a></li>
					<li><a class="dropdown-item" href="<?= Url::to(['/contratos/index']) ?>">Contratos (Firmados)</a></li>
					<li><hr class="dropdown-divider" style="border-color:var(--border)"></li>
					<li><a class="dropdown-item" href="<?= Url::to(['/multas-informes/index']) ?>">Informes y Multas</a></li>
				</ul>
			</div>

			<div class="dropdown">
				<a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					👥 Gestión
				</a>
				<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="<?= Url::to(['/usuarios/index']) ?>">Usuarios</a></li>
					<li><a class="dropdown-item" href="<?= Url::to(['/promociones/index']) ?>">Promociones</a></li>
				</ul>
			</div>

		<?php else: ?>
			<a class="<?= ($controllerId == 'vehiculos' && $actionId == 'flota') ? 'active' : '' ?>" 
			   href="<?= Url::to(['/vehiculos/flota']) ?>">Vehículos</a>
			
			<?php if ($isCliente): ?>
				<a class="<?= $controllerId == 'reservas' ? 'active' : '' ?>" 
				   href="<?= Url::to(['/reservas/mis-reservas']) ?>">Mis reservas</a>
				   
				<a class="<?= $controllerId == 'multas-informes' ? 'active' : '' ?>" 
				   href="<?= Url::to(['/multas-informes/mis-incidencias']) ?>">Incidencias</a>
				   
				<a class="<?= ($controllerId == 'site' && $actionId == 'perfil') ? 'active' : '' ?>" 
				   href="<?= Url::to(['/site/perfil']) ?>">Perfil</a>
			<?php endif; ?>

		<?php endif; ?>
	</nav>

	<div class="iconbar">
	  
	  <?php if ($isGuest): ?>
		  <a class="iconbtn" href="<?= Url::to(['/site/login']) ?>">
			<img src="<?= Url::to('@web/recursos/img/user.png') ?>" alt="Login">
			<span>Iniciar sesión</span>
		  </a>
	  <?php else: ?>
		  <?php if ($isAdmin): ?>
			 <a class="iconbtn" href="<?= Url::to(['/site/index']) ?>">
				<img src="<?= Url::to('@web/recursos/img/user.png') ?>" alt="Inicio">
				<span>Inicio</span>
			 </a>
		  <?php endif; ?>

		  <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
			<button type="submit" class="iconbtn" style="background:none; border:none; cursor:pointer; display:flex; flex-direction:column; align-items:center;">
				<img src="<?= Url::to('@web/recursos/img/logout.png') ?>" alt="Salir">
				<span>Salir (<?= Html::encode($nombreUsuario) ?>)</span>
			</button>
		  <?= Html::endForm() ?>
	  <?php endif; ?>
	</div>

  </div>
</header>

<main class="container">
	<?php if (isset($this->params['breadcrumbs'])): ?>
		<?= yii\bootstrap5\Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
	<?php endif; ?>
	<?= \app\widgets\Alert::widget() ?>
	<?= $content ?>
</main>

<footer class="footer">
  <div class="container">
	© <?= date('Y') ?> AlquilerCars · Proyecto académico
  </div>
</footer>

<?php $this->endBody() ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $this->endPage() ?>