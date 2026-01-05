<?php

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Controlador sugerido: /controladores/flota_controller.php

  En backend:
  - Leer filtros por $_GET: inicio, fin, categoria, precio_max
  - Ejecutar SELECT con condiciones
  - Devolver $vehiculos (array) a esta vista

  Estructura esperada:
  $vehiculos = [
    [
      'id'=>1,'marca'=>'Toyota','modelo'=>'Yaris','categoria'=>'Compacto',
      'precio_dia'=>35,'estado'=>'disponible','plazas'=>5,'caja'=>'Manual',
      'img'=>'/recursos/img/car-placeholder.svg' // o ruta BD
    ],
    ...
  ];
*/

$pageTitle = "Flota - AlquilerCars";
$active = "flota";

// Header común (calcula $BASE_URL y carga CSS)
include __DIR__ . "/../vistas/header_front.php";


$vehiculos = $vehiculos ?? [
  ['id'=>1,'marca'=>'Toyota','modelo'=>'Yaris','categoria'=>'Compacto','precio_dia'=>35,'estado'=>'disponible','plazas'=>5,'caja'=>'Manual','img'=> $BASE_URL . '/recursos/img/car-placeholder.svg'],
  ['id'=>2,'marca'=>'Nissan','modelo'=>'Qashqai','categoria'=>'SUV','precio_dia'=>55,'estado'=>'reservado','plazas'=>5,'caja'=>'Auto','img'=> $BASE_URL . '/recursos/img/car-placeholder.svg'],
  ['id'=>3,'marca'=>'BMW','modelo'=>'Serie 1','categoria'=>'Lujo','precio_dia'=>79,'estado'=>'disponible','plazas'=>5,'caja'=>'Auto','img'=> $BASE_URL . '/recursos/img/car-placeholder.svg'],
];
?>

<section class="hero">
  <h1 class="h-title">Flota disponible</h1>
  <p class="h-sub">Filtra y selecciona un vehículo.</p>
</section>

<section class="grid">
  <aside class="card">
    <div class="card-h">
      <h3>Filtros</h3>
      <span class="small">GET</span>
    </div>

    <div class="card-b">

      <form action="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php" method="get">
        <div class="row2">
          <div class="field">
            <div class="label">Fecha inicio</div>
            <input type="date" name="inicio" value="<?= htmlspecialchars($_GET['inicio'] ?? '') ?>">
          </div>
          <div class="field">
            <div class="label">Fecha fin</div>
            <input type="date" name="fin" value="<?= htmlspecialchars($_GET['fin'] ?? '') ?>">
          </div>
        </div>

        <div class="field">
          <div class="label">Categoría</div>
          <?php $cat = $_GET['categoria'] ?? ''; ?>
          <select name="categoria">
            <option value="" <?= $cat===''?'selected':'' ?>>Todas</option>
            <option value="Compacto" <?= $cat==='Compacto'?'selected':'' ?>>Compacto</option>
            <option value="SUV" <?= $cat==='SUV'?'selected':'' ?>>SUV</option>
            <option value="Familiar" <?= $cat==='Familiar'?'selected':'' ?>>Familiar</option>
            <option value="Lujo" <?= $cat==='Lujo'?'selected':'' ?>>Lujo</option>
          </select>
        </div>

        <div class="field">
          <div class="label">Precio máx/día (€)</div>
          <input type="number" name="precio_max" min="0" value="<?= htmlspecialchars($_GET['precio_max'] ?? '') ?>">
        </div>

        <div class="actions">
          <button class="btn primary" type="submit">Buscar</button>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/flota.php">Limpiar</a>
        </div>

        <hr class="sep"/>
        <div class="notice">
          En BD: SELECT con filtros + estado. Devolver array <strong>$vehiculos</strong>.
        </div>
      </form>
    </div>
  </aside>

  <section class="card">
    <div class="card-h">
      <h3>Resultados</h3>
      <span class="small"><?= count($vehiculos) ?> vehículos</span>
    </div>

    <div class="card-b">
      <?php if (empty($vehiculos)): ?>
        <div class="notice">No hay vehículos para los filtros seleccionados.</div>
      <?php else: ?>
        <div class="list">
          <?php foreach ($vehiculos as $v): ?>
            <?php
              $estado = $v['estado'] ?? 'disponible';
              $pillClass = $estado==='disponible' ? 'ok' : ($estado==='reservado' ? 'busy' : 'off');
              $pillText  = $estado==='disponible' ? 'Disponible' : ($estado==='reservado' ? 'Reservado' : 'Baja');
              $img = $v['img'] ?? ($BASE_URL . '/recursos/img/car-placeholder.svg');
            ?>
            <article class="vehicle">
              <div class="thumb">
                <img src="<?= htmlspecialchars($img) ?>" alt="Vehículo">
                <span class="pill <?= $pillClass ?>"><?= $pillText ?></span>
              </div>

              <div class="v-body">
                <h4 class="v-title"><?= htmlspecialchars(($v['marca'] ?? '').' '.($v['modelo'] ?? '')) ?></h4>

                <div class="meta">
                  <span><?= htmlspecialchars($v['categoria'] ?? '-') ?></span><span>•</span>
                  <span><?= htmlspecialchars($v['caja'] ?? '-') ?></span><span>•</span>
                  <span><?= (int)($v['plazas'] ?? 0) ?> plazas</span>
                </div>

                <div class="price">
                  <strong><?= (float)($v['precio_dia'] ?? 0) ?>€ / día</strong>

                  <?php if ($estado === 'disponible'): ?>
                    <a class="btn good" href="<?= htmlspecialchars($BASE_URL) ?>/front/vehiculo.php?id=<?= (int)$v['id'] ?>">Ver</a>
                  <?php else: ?>
                    <button class="btn" disabled style="opacity:.55;cursor:not-allowed">No disponible</button>
                  <?php endif; ?>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
