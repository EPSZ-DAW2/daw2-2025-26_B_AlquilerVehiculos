<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  =====================================================
  LAYOUT ADMIN (basado en header_admin.php original)
  =====================================================
  - Mantiene el mismo HTML/estructura del header admin.
  - Solo adapta:
      * $BASE_URL -> Url::to()
      * include header/footer -> layout Yii2
  - El "active" se controla desde la vista:
      $this->params['active'] = 'dashboard' | 'vehiculos' | 'usuarios' | 'contratos' | 'incidencias'
*/

$this->title = $this->title ?: 'Admin - AlquilerCars';
$active = $this->params['active'] ?? '';
?>
<?php $this->beginPage(); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="<?= Html::encode(Yii::$app->charset) ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>

  <!-- Igual que tu header_admin.php: /css/app.css -->
  <link rel="stylesheet" href="<?= Html::encode(Url::to('@web/css/app.css')) ?>"/>

  <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<header class="topbar">
  <div class="container topbar-inner">

    <a class="brand" href="<?= Html::encode(Url::to(['admin/dashboard'])) ?>">
      <img src="<?= Html::encode(Url::to('@web/recursos/img/logo.png')) ?>" alt="Logo">
      <span>AlquilerCars · Admin</span>
    </a>

    <nav class="nav">
      <a class="<?= $active==='dashboard'?'active':'' ?>" href="<?= Html::encode(Url::to(['admin/dashboard'])) ?>">Dashboard</a>
      <a class="<?= $active==='vehiculos'?'active':'' ?>" href="<?= Html::encode(Url::to(['admin/vehiculos'])) ?>">Vehículos</a>
      <a class="<?= $active==='usuarios'?'active':'' ?>" href="<?= Html::encode(Url::to(['admin/usuarios'])) ?>">Usuarios</a>
      <a class="<?= $active==='contratos'?'active':'' ?>" href="<?= Html::encode(Url::to(['admin/contratos'])) ?>">Contratos</a>
      <a class="<?= $active==='incidencias'?'active':'' ?>" href="<?= Html::encode(Url::to(['admin/incidencias'])) ?>">Incidencias</a>
    </nav>

    <div class="iconbar">
      <!-- Igual que tu header_admin.php -->
      <a class="iconbtn" href="<?= Html::encode(Url::to(['site/index'])) ?>">
        <img src="<?= Html::encode(Url::to('@web/recursos/img/user.png')) ?>" alt="Inicio">
        <span>Inicio</span>
      </a>

      <!-- Backend: implementar logout real -->
      <?= Html::beginForm(Url::to(['site/logout']), 'post', ['style' => 'display:inline;']) ?>
        <button class="iconbtn" type="submit" style="border:0;background:transparent;padding:0">
          <img src="<?= Html::encode(Url::to('@web/recursos/img/logout.png')) ?>" alt="Salir">
          <span>Salir</span>
        </button>
      <?= Html::endForm() ?>
    </div>

  </div>
</header>

<main class="container">
  <?= $content ?>
</main>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
