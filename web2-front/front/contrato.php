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
  Esta vista puede funcionar en 2 modos:

  A) MODO CESTA (antes de confirmar)
     - El backend guarda items en sesión:
       $_SESSION['cesta'] = [
         ['id_vehiculo'=>1, 'inicio'=>'2026-01-06', 'fin'=>'2026-01-08', ...]
       ];

  B) MODO CONTRATO/RESERVA (ya creada)
     - Se recibe ?id=R-1203 (o C-0001)
     - Backend consulta BD con JOIN para obtener:
       cliente + vehículo + fechas + importes + estado

  En ambos casos mostrar resumen y acciones:
  - Confirmar (POST)
  - Cancelar (POST)
*/

$id = $_GET['id'] ?? null;

$pageTitle = "Contrato / Cesta";
$active = "";

// Header común (calcula $BASE_URL y carga CSS)
include __DIR__ . "/../vistas/header_front.php";

$contrato = $contrato ?? [
  'id' => $id ?? 'C-0001',
  'cliente' => 'Juan Pérez',
  'email' => 'juan@email.com',
  'carnet' => 'X1234567',
  'vehiculo' => 'Toyota Yaris',
  'precio_dia' => 35,
  'inicio' => '2026-01-06',
  'fin' => '2026-01-08',
  'dias' => 2,
  'subtotal' => 70,
  'iva' => 14.7,
  'total' => 84.7,
  'estado' => 'pendiente'
];
?>

<section class="hero">
  <h1 class="h-title">Contrato / Cesta</h1>
  <p class="h-sub">Resumen del alquiler (integración con BD en backend).</p>
</section>

<section class="split">
  <section class="card">
    <div class="card-h">
      <h3>Resumen</h3>
      <span class="small">ID: <?= htmlspecialchars($contrato['id'] ?? '-') ?></span>
    </div>

    <div class="card-b">
      <div class="notice">
        <strong>Cliente:</strong> <?= htmlspecialchars($contrato['cliente'] ?? '-') ?><br/>
        <strong>Email:</strong> <?= htmlspecialchars($contrato['email'] ?? '-') ?><br/>
        <strong>Carnet:</strong> <?= htmlspecialchars($contrato['carnet'] ?? '-') ?><br/>
        <strong>Estado:</strong> <?= htmlspecialchars($contrato['estado'] ?? '-') ?>
      </div>

      <hr class="sep"/>

      <div class="row2">
        <div class="field">
          <div class="label">Vehículo</div>
          <input type="text" value="<?= htmlspecialchars($contrato['vehiculo'] ?? '-') ?>" readonly>
        </div>
        <div class="field">
          <div class="label">Precio / día</div>
          <input type="text" value="<?= (float)($contrato['precio_dia'] ?? 0) ?>€" readonly>
        </div>
      </div>

      <div class="row2">
        <div class="field">
          <div class="label">Inicio</div>
          <input type="date" value="<?= htmlspecialchars($contrato['inicio'] ?? '') ?>" readonly>
        </div>
        <div class="field">
          <div class="label">Fin</div>
          <input type="date" value="<?= htmlspecialchars($contrato['fin'] ?? '') ?>" readonly>
        </div>
      </div>

      <hr class="sep"/>

      <div class="notice">
        <strong>Días:</strong> <?= (int)($contrato['dias'] ?? 0) ?><br/>
        <strong>Subtotal:</strong> <?= (float)($contrato['subtotal'] ?? 0) ?>€<br/>
        <strong>IVA:</strong> <?= (float)($contrato['iva'] ?? 0) ?>€<br/>
        <strong>Total:</strong> <strong><?= (float)($contrato['total'] ?? 0) ?>€</strong>
      </div>

      <hr class="sep"/>

      <p class="small">
        En BD: el total se calcula en servidor. No confiar en valores enviados por el cliente.
      </p>
    </div>
  </section>

  <aside class="card">
    <div class="card-h">
      <h3>Acciones</h3>
      <span class="small">POST</span>
    </div>

    <div class="card-b">
      <div class="notice">
        Confirmar registra o finaliza el contrato en base de datos.
      </div>

      <!-- =====================================================
           CONFIRMAR (POST)
           Controlador sugerido: /controladores/contrato_confirmar.php

           En backend (BD):
           - Validar sesión y propiedad del contrato/cesta
           - INSERT contrato si es cesta o UPDATE si ya existe
           - Cambiar estado a 'activa' / 'confirmada'
           ===================================================== -->
      <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/contrato_confirmar.php" method="post">
        <input type="hidden" name="id_contrato" value="<?= htmlspecialchars($contrato['id'] ?? '') ?>">
        <button class="btn primary" type="submit">Confirmar reserva</button>
      </form>

      <div style="height:10px"></div>

      <!-- =====================================================
           CANCELAR (POST)
           Controlador sugerido: /controladores/contrato_cancelar.php

           En backend (BD):
           - Si es cesta: vaciar sesión
           - Si es contrato pendiente: UPDATE estado='cancelada'
           ===================================================== -->
      <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/contrato_cancelar.php" method="post">
        <input type="hidden" name="id_contrato" value="<?= htmlspecialchars($contrato['id'] ?? '') ?>">
        <button class="btn danger" type="submit">Cancelar</button>
      </form>

      <hr class="sep"/>

      <div class="actions">
        <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Seguir buscando</a>
        <a class="btn good" href="<?= htmlspecialchars($BASE_URL) ?>/front/mis_reservas.php">Mis reservas</a>
      </div>
    </div>
  </aside>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
