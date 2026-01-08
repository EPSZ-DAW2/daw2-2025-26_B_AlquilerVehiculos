<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta vista debe recibir un array $vehiculo desde el controlador.

  Estructura esperada:
  $vehiculo = [
    'id_vehiculo' => 1,
    'marca' => 'Toyota',
    'modelo' => 'Yaris',
    'categoria' => 'Compacto',
    'precio_dia' => 35,
    'plazas' => 5,
    'transmision' => 'Manual',
    'combustible' => 'Gasolina',
    'descripcion' => 'Texto descriptivo',
    'imagen' => 'yaris.png'
  ];

  Tablas implicadas:
  - vehiculos
  - categorias

  NOTA PARA BD:
  - Obtener el vehículo por id_vehiculo.
  - JOIN con categorias para nombre y precio.
*/

// DEMO FRONTEND
$vehiculo = $vehiculo ?? [
  'id_vehiculo' => 0,
  'marca' => '',
  'modelo' => '',
  'categoria' => '',
  'precio_dia' => '',
  'plazas' => '',
  'transmision' => '',
  'combustible' => '',
  'descripcion' => '',
  'imagen' => 'placeholder.png'
];
?>

<section class="hero">
  <h1 class="h-title">
    <?= Html::encode($vehiculo['marca'].' '.$vehiculo['modelo']) ?>
  </h1>
  <p class="h-sub">
    <?= Html::encode($vehiculo['categoria']) ?>
  </p>
</section>

<section class="split">
  <!-- INFO -->
  <section class="card">
    <div class="card-b">
      <img src="/img/<?= Html::encode($vehiculo['imagen']) ?>" alt="Vehículo">

      <hr class="sep">

      <div class="kv">
        <div class="box">
          <div class="k">Precio / día</div>
          <div class="v"><?= Html::encode($vehiculo['precio_dia']) ?> €</div>
        </div>
        <div class="box">
          <div class="k">Plazas</div>
          <div class="v"><?= Html::encode($vehiculo['plazas']) ?></div>
        </div>
        <div class="box">
          <div class="k">Transmisión</div>
          <div class="v"><?= Html::encode($vehiculo['transmision']) ?></div>
        </div>
        <div class="box">
          <div class="k">Combustible</div>
          <div class="v"><?= Html::encode($vehiculo['combustible']) ?></div>
        </div>
      </div>

      <hr class="sep">

      <p><?= Html::encode($vehiculo['descripcion']) ?></p>
    </div>
  </section>

  <!-- RESERVA -->
  <aside class="card">
    <div class="card-h">
      <h3>Reservar</h3>
    </div>
    <div class="card-b">
      <form>
        <div class="row2">
          <div class="field">
            <div class="label">Fecha inicio</div>
            <input type="date">
          </div>
          <div class="field">
            <div class="label">Fecha fin</div>
            <input type="date">
          </div>
        </div>

        <div class="actions">
          <button class="btn primary" disabled>
            Reservar
          </button>
        </div>

        <p class="small">
          En BD: la reserva se crea en la tabla <strong>reservas</strong>
          con validación de fechas y disponibilidad.
        </p>
      </form>
    </div>
  </aside>
</section>
