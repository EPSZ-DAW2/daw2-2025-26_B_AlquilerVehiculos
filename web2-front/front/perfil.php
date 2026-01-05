<?php

session_start();

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  - Obtener id del cliente desde sesión:
      $idCliente = $_SESSION['usuario']['id'];
  - SELECT datos del cliente
  - Pasar resultado como $cliente a la vista
*/

$pageTitle = "Mi perfil";
$active = "perfil";

// Header común (calcula $BASE_URL)
include __DIR__ . "/../vistas/header_front.php";

// ---------------------------------------------------------
// DEMO (sin BD) -> borrar al integrar BD
// ---------------------------------------------------------
$cliente = $cliente ?? [
  'nombre' => 'Juan',
  'apellidos' => 'Pérez',
  'email' => 'juan@email.com',
  'telefono' => '600123456',
  'carnet_num' => 'X1234567',
  'carnet_caducidad' => '2030-12-31'
];
?>

<section class="hero">
  <h1 class="h-title">Mi perfil</h1>
  <p class="h-sub">Actualiza tus datos personales.</p>
</section>

<section class="grid" style="grid-template-columns:1fr;">
  <section class="card">
    <div class="card-h">
      <h3>Datos personales</h3>
      <span class="small">POST</span>
    </div>

    <div class="card-b">
      <!-- =====================================================
           FORMULARIO ACTUALIZAR PERFIL (POST)
           Controlador sugerido: /controladores/perfil_actualizar.php
           ===================================================== -->
      <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/perfil_actualizar.php" method="post">
        <input type="hidden" name="id_cliente" value="<?= (int)($_SESSION['usuario']['id'] ?? 0) ?>">

        <div class="row2">
          <div class="field">
            <div class="label">Nombre</div>
            <input type="text" name="nombre" value="<?= htmlspecialchars($cliente['nombre']) ?>" required>
          </div>
          <div class="field">
            <div class="label">Apellidos</div>
            <input type="text" name="apellidos" value="<?= htmlspecialchars($cliente['apellidos']) ?>" required>
          </div>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Email</div>
            <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required>
          </div>
          <div class="field">
            <div class="label">Teléfono</div>
            <input type="tel" name="telefono" value="<?= htmlspecialchars($cliente['telefono']) ?>">
          </div>
        </div>

        <hr class="sep"/>

        <div class="notice">
          <strong>Carnet de conducir</strong>
        </div>

        <div class="row2">
          <div class="field">
            <div class="label">Número</div>
            <input type="text" name="carnet_num" value="<?= htmlspecialchars($cliente['carnet_num']) ?>" required>
          </div>
          <div class="field">
            <div class="label">Caducidad</div>
            <input type="date" name="carnet_caducidad" value="<?= htmlspecialchars($cliente['carnet_caducidad']) ?>" required>
          </div>
        </div>

        <?php if (isset($_GET['ok'])): ?>
          <div class="notice">Datos guardados correctamente.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
          <div class="notice">Error al guardar los datos.</div>
        <?php endif; ?>

        <div class="actions" style="margin-top:12px">
          <button class="btn primary" type="submit">Guardar</button>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/mis_reservas.php">Mis reservas</a>
        </div>
      </form>
    </div>
  </section>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
