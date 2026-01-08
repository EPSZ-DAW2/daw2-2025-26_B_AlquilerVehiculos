<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista debe recibir desde el controlador un array $vehiculos.

  Estructura esperada:
  $vehiculos = [
    [
      'id_vehiculo' => 1,
      'marca' => 'Toyota',
      'modelo' => 'Yaris',
      'categoria' => 'Compacto',
      'precio_dia' => 35,
      'estado' => 'Disponible',
      'plazas' => 5,
      'transmision' => 'Manual',
      'imagen' => 'yaris.png'
    ],
    ...
  ];

  Tablas implicadas:
  - vehiculos
  - categorias

  NOTA PARA BD:
  - Este listado debe obtenerse con JOIN vehiculos + categorias.
  - Los filtros (categoria, precio, fechas) se aplican en la consulta SQL.
*/

// DEMO FRONTEND (para que la vista renderice sin BD)
$vehiculos = $vehiculos ?? [];
?>

<section class="hero">
  <h1 class="h-title">Flota disponible</h1>
  <p class="h-sub">Selecciona el vehículo que mejor se adapte a ti.</p>
</section>

<section class="grid">
  <!-- FILTROS -->
  <aside class="card">
    <div class="card-h">
      <h3>Filtros</h3>
    </div>
    <div class="card-b">
      <form method="get">
        <div class="field">
          <div class="label">Categoría</div>
          <select name="categoria">
            <option value="">Todas</option>
            <option>Compacto</option>
            <option>SUV</option>
            <option>Familiar</option>
            <option>Lujo</option>
          </select>
        </div>

        <div class="field">
          <div class="label">Precio máximo / día</div>
          <input type="number" name="precio_max">
        </div>

        <div class="actions">
          <button class="btn primary">Filtrar</button>
        </div>

        <p class="small">
          En BD: estos filtros se aplican en la consulta SQL.
        </p>
      </form>
    </div>
  </aside>

  <!-- LISTADO -->
  <section class="card">
    <div class="card-h">
      <h3>Vehículos</h3>
      <span class="small"><?= count($vehiculos) ?> resultados</span>
    </div>

    <div class="card-b">
      <?php if (empty($vehiculos)): ?>
        <div class="notice">No hay vehículos disponibles.</div>
      <?php else: ?>
        <div class="list">
          <?php foreach ($vehiculos as $v): ?>
            <article class="vehicle">
              <div class="thumb">
                <img src="/img/<?= Html::encode($v['imagen'] ?? 'placeholder.png') ?>" alt="Vehículo">
              </div>

              <div class="v-body">
                <h4 class="v-title">
                  <?= Html::encode($v['marca'].' '.$v['modelo']) ?>
                </h4>

                <div class="meta">
                  <?= Html::encode($v['categoria']) ?> •
                  <?= Html::encode($v['transmision']) ?> •
                  <?= Html::encode($v['plazas']) ?> plazas
                </div>

                <div class="price">
                  <strong><?= Html::encode($v['precio_dia']) ?> € / día</strong>
                  <a class="btn good"
                     href="<?= Url::to(['vehiculo/view', 'id'=>$v['id_vehiculo']]) ?>">
                     Ver
                  </a>
                </div>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</section>
