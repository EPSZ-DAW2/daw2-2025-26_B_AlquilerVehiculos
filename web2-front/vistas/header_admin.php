<?php

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}


$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$scriptDir = rtrim($scriptDir, '/');

// Subimos al directorio raíz del proyecto
$BASE_URL = preg_replace('#/(front|admin|vistas)(/.*)?$#', '', $scriptDir);
if ($BASE_URL === null) $BASE_URL = '';
if ($BASE_URL === '/') $BASE_URL = '';

// ---------------------------------------------------------
// Variables de vista
// ---------------------------------------------------------
$pageTitle = $pageTitle ?? "Admin - AlquilerCars";
$active    = $active ?? ""; // dashboard | vehiculos | usuarios | contratos | incidencias

/*
  ================================
  INTEGRACIÓN CON BD / SEGURIDAD
  ================================
  En backend, antes de mostrar cualquier vista /admin/*:
  - Comprobar sesión:
      if(!isset($_SESSION['usuario'])) redirect login
  - Comprobar rol:
      if($_SESSION['usuario']['rol'] !== 'admin') denegar acceso
*/
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title><?= htmlspecialchars($pageTitle) ?></title>

  <link rel="stylesheet" href="<?= htmlspecialchars($BASE_URL) ?>/recursos/app.css"/>
</head>

<body>
<header class="topbar">
  <div class="container topbar-inner">

    <a class="brand" href="<?= htmlspecialchars($BASE_URL) ?>/admin/dashboard.php">
      <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/logo.svg" alt="Logo">
      <span>AlquilerCars · Admin</span>
    </a>

    <nav class="nav">
      <a class="<?= $active==='dashboard'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/admin/dashboard.php">Dashboard</a>
      <a class="<?= $active==='vehiculos'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/admin/vehiculos.php">Vehículos</a>
      <a class="<?= $active==='usuarios'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/admin/usuarios.php">Usuarios</a>
      <a class="<?= $active==='contratos'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/admin/contratos.php">Contratos</a>
      <a class="<?= $active==='incidencias'?'active':'' ?>" href="<?= htmlspecialchars($BASE_URL) ?>/admin/incidencias.php">Incidencias</a>
    </nav>

    <div class="iconbar">
      <!-- En backend: esta ruta puede ser logout o volver al front -->
      <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/index.php">
        <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/icon-user.svg" alt="Inicio">
        <span>Inicio</span>
      </a>

      <!-- Backend: implementar logout real -->
      <a class="iconbtn" href="<?= htmlspecialchars($BASE_URL) ?>/controladores/logout.php">
        <img src="<?= htmlspecialchars($BASE_URL) ?>/recursos/img/icon-user.svg" alt="Salir">
        <span>Salir</span>
      </a>
    </div>

  </div>
</header>

<main class="container">
