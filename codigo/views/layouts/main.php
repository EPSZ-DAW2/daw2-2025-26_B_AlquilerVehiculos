<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
// Asegúrate de usar bootstrap5 si es la versión que tienes instalada
use yii\bootstrap5\Breadcrumbs; 
use app\assets\AppAsset;

AppAsset::register($this);

// Truco para saber qué menú iluminar (active)
$controller = Yii::$app->controller->id;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    
    <link rel="stylesheet" href="<?= Url::to('@web/recursos/app.css') ?>?v=1">
</head>
<body>
<?php $this->beginBody() ?>

<header class="topbar">
  <div class="container topbar-inner">

    <a class="brand" href="<?= Url::to(['/site/index']) ?>">
      <img src="<?= Url::to('@web/recursos/img/logo.png') ?>" alt="Logo">
      <span>AlquilerCars · Admin</span>
    </a>

    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->rol == 'Admin'): ?>
    <nav class="nav">
      <a class="<?= $controller == 'site' ? 'active' : '' ?>" 
         href="<?= Url::to(['/site/index']) ?>">Dashboard</a>
      
      <a class="<?= $controller == 'vehiculos' ? 'active' : '' ?>" 
         href="<?= Url::to(['/vehiculos/index']) ?>">Vehículos</a>
      
      <a class="<?= $controller == 'usuarios' ? 'active' : '' ?>" 
         href="<?= Url::to(['/usuarios/index']) ?>">Usuarios</a>
      
      <a class="<?= $controller == 'reservas' ? 'active' : '' ?>" 
         href="<?= Url::to(['/reservas/index']) ?>">Contratos</a>
      
      <a class="<?= $controller == 'multas-informes' ? 'active' : '' ?>" 
         href="<?= Url::to(['/multas-informes/index']) ?>">Incidencias</a>
    </nav>
    <?php endif; ?>

    <div class="iconbar">
      
      <a class="iconbtn" href="<?= Url::to(['/site/index']) ?>">
        <span>Inicio</span>
      </a>

      <?php if (Yii::$app->user->isGuest): ?>
          <a class="iconbtn" href="<?= Url::to(['/site/login']) ?>">
            <img src="<?= Url::to('@web/recursos/img/user.png') ?>" alt="Inicio">
            <span>Iniciar Sesión</span>
          </a>
      <?php else: ?>
          <a class="iconbtn" href="<?= Url::to(['/site/logout']) ?>" data-method="post">
            <img src="<?= Url::to('@web/recursos/img/logout.png') ?>" alt="Salir">
            <span>Salir (<?= Yii::$app->user->identity->nombre ?>)</span>
          </a>
      <?php endif; ?>
    </div>

  </div>
</header>

<div class="wrap"> 
    <main class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        
        <?= Alert::widget() ?>
        
        <?= $content ?>
    </main>
</div> 

<footer class="footer">
  <div class="container">
    <p style="color: var(--muted)">
        © <?= date('Y') ?> AlquilerCars · Proyecto académico
    </p>
  </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>