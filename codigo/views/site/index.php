<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Inicio';

$isGuest = Yii::$app->user->isGuest;
$isAdmin = !$isGuest && (isset(Yii::$app->user->identity->rol) && Yii::$app->user->identity->rol == 'Admin');
$nombre = !$isGuest ? Yii::$app->user->identity->nombre : '';
?>

<section class="hero">
	<h1 class="h-title">
			Bienvenido<?= $nombre ? ', ' . Html::encode($nombre) : '' ?>
	</h1>
	<p class="h-sub">
		<?php if ($isAdmin): ?>
				Panel de Administración del Sistema. Gestiona tu flota y contratos desde aquí.
		<?php else: ?>
				Plataforma de alquiler de coches. Busca vehículos, gestiona reservas y consulta incidencias.
		<?php endif; ?>
	</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
	
	<section class="card">
		<div class="card-h">
			<h3>Acciones rápidas</h3>
			<span class="small"><?= $isAdmin ? 'Administración' : 'Usuario' ?></span>
		</div>

		<div class="card-b">
			<div class="actions">
				
				<?php if ($isAdmin): ?>
						<a class="btn primary" href="<?= Url::to(['/vehiculos/index']) ?>">🚗 Gestionar Flota</a>
						<a class="btn" href="<?= Url::to(['/reservas/index']) ?>">📅 Ver Reservas</a>
						<a class="btn" href="<?= Url::to(['/contratos/index']) ?>">📝 Contratos</a>
						<a class="btn good" href="<?= Url::to(['/usuarios/index']) ?>">👥 Usuarios</a>

				<?php else: ?>
						
						<a class="btn primary" href="<?= Url::to(['/vehiculos/flota']) ?>">Ver flota disponible</a>

						<?php if (!$isGuest): ?>
								<a class="btn good" href="<?= Url::to(['/reservas/mis-reservas']) ?>">Mis reservas</a>
								<a class="btn" href="<?= Url::to(['/usuarios/perfil']) ?>">Mi perfil</a>
								<a class="btn" href="<?= Url::to(['/multas-informes/mis-incidencias']) ?>">Incidencias</a>
						
						<?php else: ?>
								<a class="btn good" href="<?= Url::to(['/site/login']) ?>">Iniciar sesión</a>
								<a class="btn" href="<?= Url::to(['/site/login']) ?>">Crear cuenta</a>
						<?php endif; ?>

				<?php endif; ?>
			</div>

		</div>
	</section>

	<?php if ($isAdmin): ?>
	<section class="card" style="margin-top: 20px;">
		<div class="card-h">
			<h3>Estado del Sistema</h3>
			<span class="small">Resumen</span>
		</div>
		<div class="card-b">
				<p>Aquí podrás ver gráficas o contadores en el futuro.</p>
				<div class="actions">
						<a class="btn" href="<?= Url::to(['/multas-informes/index']) ?>">⚠️ Ver Incidencias Pendientes</a>
				</div>
		</div>
	</section>
	<?php endif; ?>

</section>