<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); 
$scriptDir = rtrim($scriptDir, '/');

// Si estamos dentro de /front o /admin, subimos un nivel para obtener la raíz del proyecto
$BASE_URL = preg_replace('#/(front|admin|vistas)(/.*)?$#', '', $scriptDir);
if ($BASE_URL === null) $BASE_URL = '';
if ($BASE_URL === '/') $BASE_URL = '';
// Nota: $BASE_URL se usará para construir rutas seguras

// ---------------------------------------------------------
// Variables de vista
// ---------------------------------------------------------
$pageTitle = $pageTitle ?? "AlquilerCars";
$active    = $active ?? ""; // flota | mis_reservas | incidencias | perfil

// ---------------------------------------------------------
// Sesión / usuario
// ---------------------------------------------------------
// Backend: al autenticar, crear por ejemplo:
// $_SESSION['usuario'] = ['id'=>1,'nombre'=>'Juan','rol'=>'cliente'];
$isLogged  = isset($_SESSION['usuario']);

// ---------------------------------------------------------
// Cesta (opcional)
// ---------------------------------------------------------
// Backend: actualizar contador al añadir reservas
$cartCount = $_SESSION['cart_count'] ?? 0;
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?= htmlspecialchars($pageTitle) ?></title>

  <!-- CSS (ruta robusta usando BASE_URL) -->
  <link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL) ?>/recursos/app.css"/>
</head>

<body>
<header class="topbar">
  <div class="container topbar-inner">

    <!-- Logo -->
    <a class="brand" href="<?= htmlspecialchars($BASE_URL) ?>/index.php">
      <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/logo.png" alt="Logo">
      <span>AlquilerCars</span>
    </a>

    <!-- Menú -->
    <nav class="nav">
      <a class="<?= $active==='flota'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Flota</a>

      <?php if ($isLogged): ?>
        <a class="<?= $active==='mis_reservas'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/front/mis_reservas.php">Mis reservas</a>
        <a class="<?= $active==='incidencias'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/front/incidencias.php">Incidencias</a>
        <a class="<?= $active==='perfil'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/front/perfil.php">Perfil</a>
      <?php endif; ?>
    </nav>

    <!-- Acciones -->
    <div class="iconbar">
      <!-- Cesta -->
      <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/front/contrato.php">
        <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/carro.png" alt="Cesta">
        <span>Mi cesta</span>
        <?php if ((int)$cartCount > 0): ?>
          <span class="badge"><?= (int)$cartCount ?></span>
        <?php endif; ?>
      </a>

      <?php if ($isLogged): ?>
        <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/front/mis_reservas.php">
          <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/pedido.png" alt="Pedido">
          <span>Pedido</span>
        </a>

        <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/front/perfil.php">
          <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/user.png" alt="Cuenta">
          <span>Mi cuenta</span>
        </a>

        <!-- Backend: implementar logout -->
        <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/controladores/logout.php">
          <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/logout.png" alt="Salir">
          <span>Salir</span>
        </a>
      <?php else: ?>
        <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/front/login.php">
          <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/user.png" alt="Login">
          <span>Iniciar sesión</span>
        </a>
      <?php endif; ?>
    </div>

  </div>
</header>

<main class="container">
