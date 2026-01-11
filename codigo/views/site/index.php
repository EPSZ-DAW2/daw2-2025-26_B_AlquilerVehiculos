<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Inicio - AlquilerCars";
$this->params['active'] = ""; // 对应你原来的 $active = ""

// Estado de login（原来：isset($_SESSION['usuario'])）
$isLogged = !Yii::$app->user->isGuest;

// 原来：$_SESSION['usuario']['nombre']
$identity = $isLogged ? Yii::$app->user->identity : null;
$nombre = null;
if ($isLogged) {
  if (is_object($identity) && property_exists($identity, 'nombre') && !empty($identity->nombre)) {
    $nombre = $identity->nombre;
  } elseif (is_object($identity) && isset($identity->username) && !empty($identity->username)) {
    $nombre = $identity->username;
  } else {
    $nombre = 'Usuario';
  }
}
?>

<section class="hero">
  <h1 class="h-title">Bienvenido<?= $isLogged ? ', '.Html::encode($nombre) : '' ?> </h1>
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
        <a class="btn primary" href="<?= Html::encode(Url::to(['vehiculo/index'])) ?>">Ver flota</a>

        <?php if ($isLogged): ?>
          <a class="btn good" href="<?= Html::encode(Url::to(['reserva/mis-reservas'])) ?>">Mis reservas</a>
          <a class="btn" href="<?= Html::encode(Url::to(['user/perfil'])) ?>">Mi perfil</a>
          <a class="btn" href="<?= Html::encode(Url::to(['incidencia/index'])) ?>">Incidencias</a>
        <?php else: ?>
          <a class="btn good" href="<?= Html::encode(Url::to(['site/login'])) ?>">Iniciar sesión</a>
          <a class="btn" href="<?= Html::encode(Url::to(['site/registro'])) ?>">Crear cuenta</a>
        <?php endif; ?>
      </div>

      <hr class="sep"/>

      <div class="notice">
        <strong>Integración con BD (backend):</strong><br/>
        Aquí se pueden mostrar vehículos destacados con un SELECT, por ejemplo:
        <ul>
          <li>SELECT * FROM vehiculos WHERE estado='disponible' ORDER BY . LIMIT 6</li>
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
        <a class="btn" href="<?= Html::encode(Url::to(['admin/dashboard'])) ?>">Ir al Dashboard Admin</a>
      </div>

      <hr class="sep"/>

      <div class="notice">
        Backend (BD): validar rol antes de permitir acceso a /admin/*.
      </div>
    </div>
  </section>
</section>
