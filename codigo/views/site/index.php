<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  CONEXIÓN CON BASE DE DATOS
  ================================
  Esta página es informativa (home).

  Opcional en BD:
  - Mostrar vehículos destacados
  - Mostrar promociones activas
  - Mostrar número total de vehículos

  Tablas posibles:
  - vehiculos
  - categorias
  - promociones (si existe)

  NOTA PARA BD:
  - Todo el contenido dinámico es opcional.
  - Esta vista puede renderizarse solo con HTML estático.
*/
?>

<section class="hero">
  <h1 class="h-title">Alquiler de Vehículos</h1>
  <p class="h-sub">
    Reserva tu coche de forma rápida y sencilla.
  </p>

  <div class="actions" style="margin-top:16px">
    <a class="btn primary" href="<?= Url::to(['vehiculo/index']) ?>">Ver flota</a>
    <a class="btn" href="<?= Url::to(['site/login']) ?>">Acceder</a>
  </div>
</section>

<section class="grid" style="margin-top:24px">
  <section class="card">
    <div class="card-h">
      <h3>¿Cómo funciona?</h3>
    </div>
    <div class="card-b">
      <ol class="small">
        <li>Selecciona un vehículo de la flota</li>
        <li>Elige las fechas de alquiler</li>
        <li>Confirma la reserva</li>
        <li>Recoge el vehículo</li>
      </ol>
    </div>
  </section>

  <section class="card">
    <div class="card-h">
      <h3>Ventajas</h3>
    </div>
    <div class="card-b">
      <ul class="small">
        <li>Flota variada</li>
        <li>Precios claros</li>
        <li>Gestión online</li>
        <li>Soporte ante incidencias</li>
      </ul>
    </div>
  </section>
</section>
