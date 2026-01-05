<?php

session_start();

// Variables de vista
$pageTitle = "Inicio - AlquilerCars";
$active = "";

// Incluye header (calcula BASE_URL y carga CSS)
include __DIR__ . "/vistas/header_front.php";

// Estado de login
$isLogged = isset($_SESSION['usuario']);
$nombre = $isLogged ? ($_SESSION['usuario']['nombre'] ?? 'Usuario') : null;

// Nota BD:
// En backend, el index puede mostrar información dinámica (destacados, ofertas, etc.)
// mediante consultas SELECT. Aquí dejamos el layout listo.
?>

<section class="hero">
  <h1 class="h-title">Bienvenido<?= $isLogged ? ', '.htmlspecialchars($nombre) : '' ?> </h1>
  <p class="h-sub">
    Plataforma de alquiler de coches. Busca vehículos, gestiona reservas y consulta incidencias.
  </p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>Acciones rápidas</h3>
      <span class="small">Inicio</span>
    </div>

    <div class="card-b">
      <div class="actions">
        <a class="btn primary" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Ver flota</a>

        <?php if ($isLogged): ?>
          <a class="btn good" href="<?= htmlspecialchars($BASE_URL) ?>/front/mis_reservas.php">Mis reservas</a>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/perfil.php">Mi perfil</a>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/incidencias.php">Incidencias</a>
        <?php else: ?>
          <a class="btn good" href="<?= htmlspecialchars($BASE_URL) ?>/front/login.php">Iniciar sesión</a>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/registro.php">Crear cuenta</a>
        <?php endif; ?>
      </div>

      <hr class="sep"/>

      <div class="notice">
        <strong>Integración con BD (backend):</strong><br/>
        Aquí se pueden mostrar vehículos destacados con un SELECT, por ejemplo:
        <ul>
          <li>SELECT * FROM vehiculos WHERE estado='disponible' ORDER BY ... LIMIT 6</li>
          <li>Mostrar cards reutilizando el diseño de flota</li>
        </ul>
      </div>
    </div>
  </section>

  <section class="card">
    <div class="card-h">
      <h3>Área de administración</h3>
      <span class="small">Backoffice</span>
    </div>

    <div class="card-b">
      <p class="small">
        El panel de administración debe estar protegido por sesión y rol (<strong>admin</strong>).
      </p>

      <div class="actions">
        <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/admin/dashboard.php">Ir al Dashboard Admin</a>
      </div>

      <hr class="sep"/>

      <div class="notice">
        Backend (BD): validar rol antes de permitir acceso a /admin/*.
      </div>
    </div>
  </section>
</section>

<?php include __DIR__ . "/vistas/footer.php"; ?>
