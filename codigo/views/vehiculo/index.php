<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  En backend:
  - Leer filtros por GET: inicio, fin, categoria, precio_max
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

  NOTA:
  - En Yii2 no usamos $_GET en la vista. El controlador puede pasar $filtros.
*/

$this->title = $this->title ?: 'Flota - AlquilerCars';

// Para que renderice aunque no haya backend:
$vehiculos = $vehiculos ?? [
  ['id'=>1,'marca'=>'Toyota','modelo'=>'Yaris','categoria'=>'Compacto','precio_dia'=>35,'estado'=>'disponible','plazas'=>5,'caja'=>'Manual','img'=> '/recursos/img/yaris.png'],
  ['id'=>2,'marca'=>'Nissan','modelo'=>'Qashqai','categoria'=>'SUV','precio_dia'=>55,'estado'=>'reservado','plazas'=>5,'caja'=>'Auto','img'=> '/recursos/img/nissan.png'],
  ['id'=>3,'marca'=>'BMW','modelo'=>'Serie 1','categoria'=>'Lujo','precio_dia'=>79,'estado'=>'disponible','plazas'=>5,'caja'=>'Auto','img'=> '/recursos/img/bmw.png'],
];

// Valores del filtro (los puede pasar el controlador para “mantener” la selección)
$filtros = $filtros ?? [
  'inicio' => '',
  'fin' => '',
  'categoria' => '',
  'precio_max' => '',
];

// Lista EXACTA como en tu versión antigua
$categorias = ['Compacto','SUV','Familiar','Lujo'];
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
      <form action="<?= Html::encode(Url::to(['vehiculo/index'])) ?>" method="get">
        <div class="row2">
          <div class="field">
            <div class="label">Fecha inicio</div>
            <input type="date" name="inicio" value="<?= Html::encode($filtros['inicio'] ?? '') ?>">
          </div>
          <div class="field">
            <div class="label">Fecha fin</div>
            <input type="date" name="fin" value="<?= Html::encode($filtros['fin'] ?? '') ?>">
          </div>
        </div>

        <div class="field">
          <div class="label">Categoría</div>
          <?php $cat = (string)($filtros['categoria'] ?? ''); ?>
          <select name="categoria">
            <option value="" <?= $cat===''?'selected':'' ?>>Todas</option>
            <?php foreach ($categorias as $c): ?>
              <option value="<?= Html::encode($c) ?>" <?= $cat===$c?'selected':'' ?>><?= Html::encode($c) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="field">
          <div class="label">Precio máx/día (€)</div>
          <input type="number" name="precio_max" min="0" value="<?= Html::encode($filtros['precio_max'] ?? '') ?>">
        </div>

        <div class="actions">
          <button class="btn primary" type="submit">Buscar</button>
          <a class="btn" href="<?= Html::encode(Url::to(['vehiculo/index'])) ?>">Limpiar</a>
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
              $img = $v['img'] ?? '/recursos/img/yaris.png';
            ?>
            <article class="vehicle">
              <div class="thumb">
                <img src="/recursos/img/yaris.png" alt="Vehículo">

                <span class="pill <?= Html::encode($pillClass) ?>"><?= Html::encode($pillText) ?></span>
              </div>

              <div class="v-body">
                <h4 class="v-title"><?= Html::encode(($v['marca'] ?? '').' '.($v['modelo'] ?? '')) ?></h4>

                <div class="meta">
                  <span><?= Html::encode($v['categoria'] ?? '-') ?></span><span>•</span>
                  <span><?= Html::encode($v['caja'] ?? '-') ?></span><span>•</span>
                  <span><?= (int)($v['plazas'] ?? 0) ?> plazas</span>
                </div>

                <div class="price">
                  <strong><?= (float)($v['precio_dia'] ?? 0) ?>€ / día</strong>

                  <?php if ($estado === 'disponible'): ?>
                    <a class="btn good" href="<?= Html::encode(Url::to(['vehiculo/view', 'id' => (int)($v['id'] ?? 0)])) ?>">Ver</a>
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
