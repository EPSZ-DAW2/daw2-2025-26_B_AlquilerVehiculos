<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  Layout basado en header_front.php (original).
  - Mantiene estructura: topbar + brand + nav + iconbar (Mi cesta)
  - Solo adapta:
      * $_SESSION -> Yii::$app->user + Yii::$app->session
      * $BASE_URL -> Url::to() / Url::to('@web/...')
      * include header/footer -> layout Yii2
*/

$this->title = $this->title ?: 'AlquilerCars';

// Estado de login (antes: isset($_SESSION['usuario']))
$isLogged = !Yii::$app->user->isGuest;

// Contador cesta (antes: $_SESSION['cart_count'] ?? 0)
$cartCount = (int)Yii::$app->session->get('cart_count', 0);

// Activo del menú (antes: $active)
$active = $this->params['active'] ?? ''; // flota | mis_reservas | incidencias | perfil | ...
?>
<?php $this->beginPage(); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="<?= Html::encode(Yii::$app->charset) ?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <?= Html::csrfMetaTags() ?>
  <title><?= Html::encode($this->title) ?></title>

  <!-- Igual que tu header_front: /css/app.css -->
  <link rel="stylesheet" href="<?= Html::encode(Url::to('@web/css/app.css')) ?>"/>

  <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>

<header class="topbar">
  <div class="container topbar-inner">

    <!-- Logo (igual que header_front.php) -->
    <a class="brand" href="<?= Html::encode(Url::to(['site/index'])) ?>">
      <img src="<?= Html::encode(Url::to('@web/recursos/img/logo.png')) ?>" alt="Logo">
      <span>AlquilerCars</span>
    </a>

    <!-- Menú (igual que header_front.php) -->
    <nav class="nav">
      <a class="<?= $active === 'flota' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['vehiculo/index'])) ?>">Flota</a>

      <?php if ($isLogged): ?>
        <a class="<?= $active === 'mis_reservas' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['reserva/mis-reservas'])) ?>">Mis reservas</a>
        <a class="<?= $active === 'incidencias' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['incidencia/index'])) ?>">Incidencias</a>
        <a class="<?= $active === 'perfil' ? 'active' : '' ?>" href="<?= Html::encode(Url::to(['user/perfil'])) ?>">Perfil</a>
      <?php endif; ?>
    </nav>

    <!-- Acciones (igual que header_front.php) -->
    <div class="iconbar">
      <!-- Cesta (siempre visible) -->
      <a class="iconbtn" href="<?= Html::encode(Url::to(['reserva/contrato'])) ?>">
        <img src="<?= Html::encode(Url::to('@web/recursos/img/carro.png')) ?>" alt="Cesta">
        <span>Mi cesta</span>
        <?php if ($cartCount > 0): ?>
          <span class="badge"><?= (int)$cartCount ?></span>
        <?php endif; ?>
      </a>

      <?php if ($isLogged): ?>
        <a class="iconbtn" href="<?= Html::encode(Url::to(['reserva/mis-reservas'])) ?>">
          <img src="<?= Html::encode(Url::to('@web/recursos/img/pedido.png')) ?>" alt="Pedido">
          <span>Pedido</span>
        </a>

        <a class="iconbtn" href="<?= Html::encode(Url::to(['user/perfil'])) ?>">
          <img src="<?= Html::encode(Url::to('@web/recursos/img/user.png')) ?>" alt="Cuenta">
          <span>Mi cuenta</span>
        </a>

        <!-- Logout: en tu proyecto antiguo era /controladores/logout.php -->
        <!-- En Yii2 lo normal es POST a site/logout (controlador lo implementa backend) -->
        <?= Html::beginForm(Url::to(['site/logout']), 'post', ['style' => 'display:inline;']) ?>
          <button class="iconbtn" type="submit" style="border:0;background:transparent;padding:0">
            <img src="<?= Html::encode(Url::to('@web/recursos/img/logout.png')) ?>" alt="Salir">
            <span>Salir</span>
          </button>
        <?= Html::endForm() ?>
      <?php else: ?>
        <a class="iconbtn" href="<?= Html::encode(Url::to(['site/login'])) ?>">
          <img src="<?= Html::encode(Url::to('@web/recursos/img/user.png')) ?>" alt="Login">
          <span>Iniciar sesión</span>
        </a>
      <?php endif; ?>
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
