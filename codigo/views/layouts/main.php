<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  NOTAS (BD / PROYECTO)
  ================================
  - La navegación muestra enlaces según el estado de autenticación.
  - En producción, el acceso a "Admin" debe restringirse por rol (Admin).
  - No se usan variables globales directamente para sesión.
*/

$this->title = $this->title ?: 'AlquilerCars';
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Html::encode(Yii::$app->language) ?>">
<head>
  <meta charset="<?= Html::encode(Yii::$app->charset) ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?= Html::csrfMetaTags() ?>

  <title><?= Html::encode($this->title) ?></title>

  <!-- CSS principal (colocar app.css en /web/css/app.css) -->
  <link rel="stylesheet" href="/css/app.css">
  <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<header class="topbar">
  <div class="container topbar-inner">
    <a class="brand" href="<?= Html::encode(Url::to(['site/index'])) ?>">
      <!-- Logo opcional: si no existe, no pasa nada -->
      <span class="brand-dot"></span>
      <span>AlquilerCars</span>
    </a>

    <nav class="nav">
      <a class="nav-link" href="<?= Html::encode(Url::to(['site/index'])) ?>">Inicio</a>
      <a class="nav-link" href="<?= Html::encode(Url::to(['vehiculo/index'])) ?>">Flota</a>

      <?php if (Yii::$app->user->isGuest): ?>
        <a class="nav-link" href="<?= Html::encode(Url::to(['site/login'])) ?>">Login</a>
      <?php else: ?>
        <a class="nav-link" href="<?= Html::encode(Url::to(['user/perfil'])) ?>">Perfil</a>
        <a class="nav-link" href="<?= Html::encode(Url::to(['reserva/contrato'])) ?>">Contrato</a>
        <a class="nav-link" href="<?= Html::encode(Url::to(['incidencia/index'])) ?>">Incidencias</a>

        <!-- En producción: mostrar Admin solo si rol=Admin -->
        <a class="nav-link" href="<?= Html::encode(Url::to(['admin/dashboard'])) ?>">Admin</a>

        <!-- Logout por POST (seguro) -->
        <?= Html::beginForm(Url::to(['site/logout']), 'post', ['class' => 'logout-form']) ?>
          <button type="submit" class="btn small">Salir</button>
        <?= Html::endForm() ?>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="container main">
  <!-- Mensajes -->
  <?php if (Yii::$app->session->hasFlash('ok')): ?>
    <div class="notice"><?= Html::encode(Yii::$app->session->getFlash('ok')) ?></div>
  <?php endif; ?>
  <?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="notice"><?= Html::encode(Yii::$app->session->getFlash('error')) ?></div>
  <?php endif; ?>

  <?= $content ?>
</main>

<footer class="footer">
  <div class="container footer-inner">
    <div class="small">
      Proyecto Alquiler de Vehículos • DAW2
    </div>
    <div class="small">
      © <?= date('Y') ?> AlquilerCars
    </div>
  </div>
</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
