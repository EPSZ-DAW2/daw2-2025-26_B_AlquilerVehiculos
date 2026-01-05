<?php

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Controlador sugerido: /controladores/vehiculo_controller.php

  En backend:
  1) Leer $_GET['id']
  2) SELECT * FROM vehiculos WHERE id = ?
  3) Validar existencia
  4) Preparar $vehiculo (array) para la vista
*/

$id = (int)($_GET['id'] ?? 0);

$pageTitle = "Detalle del vehículo";
$active = "flota";

// Header común (calcula $BASE_URL y carga CSS)
include __DIR__ . "/../vistas/header_front.php";


$vehiculo = $vehiculo ?? [
  'id' => ($id > 0 ? $id : 1),
  'marca' => 'Toyota',
  'modelo' => 'Yaris',
  'categoria' => 'Compacto',
  'precio_dia' => 35,
  'caja' => 'Manual',
  'plazas' => 5,
  'combustible' => 'Gasolina',
  'estado' => 'disponible', // disponible | reservado | baja
  'descripcion' => 'Vehículo ideal para ciudad, bajo consumo (texto demo).',
  'img' => $BASE_URL . '/recursos/img/car-placeholder.svg',
];
?>

<section class="hero">
  <h1 class="h-title"><?= htmlspecialchars(($vehiculo['marca'] ?? '').' '.($vehiculo['modelo'] ?? '')) ?></h1>
  <p class="h-sub">
    <?= htmlspecialchars($vehiculo['categoria'] ?? '-') ?> •
    <?= htmlspecialchars($vehiculo['caja'] ?? '-') ?> •
    <?= (int)($vehiculo['plazas'] ?? 0) ?> plazas •
    Estado: <strong><?= htmlspecialchars($vehiculo['estado'] ?? '-') ?></strong>
  </p>
</section>

<section class="split">
  <section class="card">
    <div class="card-b">
      <div class="gallery">
        <img src="<?= htmlspecialchars($vehiculo['img'] ?? ($BASE_URL.'/recursos/img/car-placeholder.svg')) ?>" alt="Vehículo">
      </div>

      <hr class="sep"/>

      <div class="kv">
        <div class="box">
          <div class="k">Categoría</div>
          <div class="v"><?= htmlspecialchars($vehiculo['categoria'] ?? '-') ?></div>
        </div>
        <div class="box">
          <div class="k">Precio / día</div>
          <div class="v"><?= (float)($vehiculo['precio_dia'] ?? 0) ?>€</div>
        </div>
        <div class="box">
          <div class="k">Transmisión</div>
          <div class="v"><?= htmlspecialchars($vehiculo['caja'] ?? '-') ?></div>
        </div>
        <div class="box">
          <div class="k">Combustible</div>
          <div class="v"><?= htmlspecialchars($vehiculo['combustible'] ?? '-') ?></div>
        </div>
      </div>

      <hr class="sep"/>
      <p class="small"><?= htmlspecialchars($vehiculo['descripcion'] ?? 'Sin descripción') ?></p>
    </div>
  </section>

  <aside class="card">
    <div class="card-h">
      <h3>Reservar</h3>
      <span class="small">POST</span>
    </div>

    <div class="card-b">
      <!-- =====================================================
           FORMULARIO RESERVA (POST)
           Controlador sugerido: /controladores/reserva_crear.php

           En backend (BD):
           - Validar sesión del cliente
           - Validar fechas (inicio < fin)
           - Comprobar disponibilidad (no solapamiento)
           - Insertar reserva o añadir a cesta
           ===================================================== -->
      <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/reserva_crear.php" method="post">
        <input type="hidden" name="id_vehiculo" value="<?= (int)($vehiculo['id'] ?? 0) ?>">

        <div class="row2">
          <div class="field">
            <div class="label">Inicio</div>
            <input type="date" name="fecha_inicio" required>
          </div>
          <div class="field">
            <div class="label">Fin</div>
            <input type="date" name="fecha_fin" required>
          </div>
        </div>

        <div class="notice">
          En backend: calcular total en servidor:<br/>
          <strong>(fin - inicio) × precio_día</strong>
        </div>

        <div class="actions" style="margin-top:12px">
          <?php if (($vehiculo['estado'] ?? '') === 'disponible'): ?>
            <button class="btn good" type="submit">Añadir a cesta</button>
          <?php else: ?>
            <button class="btn" disabled style="opacity:.55;cursor:not-allowed">No disponible</button>
          <?php endif; ?>

          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Volver</a>
        </div>
      </form>
    </div>
  </aside>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
