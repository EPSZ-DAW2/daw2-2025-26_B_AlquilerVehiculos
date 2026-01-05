<?php

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Controlador sugerido: /controladores/login.php  (POST)

  En backend:
  1) Recibir email y password
  2) Buscar usuario en BD:
       SELECT * FROM usuarios WHERE email = ?
  3) Verificar contraseña:
       password_verify($password, $hash_bd)
  4) Crear sesión:
       $_SESSION['usuario'] = ['id'=>..., 'nombre'=>..., 'rol'=>...]
  5) Redirigir:
       header("Location: <BASE_URL>/front/flota.php");

  Error:
  - Redirigir a login con ?error=1
*/

$pageTitle = "Iniciar sesión";
$active = "";

// Header común (calcula $BASE_URL y carga CSS)
include __DIR__ . "/../vistas/header_front.php";
?>

<section class="auth-wrap">
  <section class="card">
    <div class="card-h">
      <h3>Iniciar sesión</h3>
      <span class="small">Cliente</span>
    </div>

    <div class="card-b">
      <form action="<?= htmlspecialchars($BASE_URL) ?>/controladores/login.php" method="post">
        <div class="field">
          <div class="label">Email</div>
          <input type="email" name="email" placeholder="email@dominio.com" required>
        </div>

        <div class="field">
          <div class="label">Contraseña</div>
          <input type="password" name="password" placeholder="••••••••" required>
        </div>

        <?php if (isset($_GET['ok'])): ?>
          <div class="notice">Cuenta creada correctamente. Ya puedes iniciar sesión.</div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
          <div class="notice">Error: credenciales incorrectas o usuario no existe.</div>
        <?php endif; ?>

        <div class="actions" style="margin-top:12px">
          <button class="btn primary" type="submit">Entrar</button>
          <a class="btn" href="<?= htmlspecialchars($BASE_URL) ?>/front/registro.php">Crear cuenta</a>
        </div>

        <hr class="sep"/>

        <p class="small">
          Backend: almacenar contraseñas con <strong>password_hash</strong>
          y verificar con <strong>password_verify</strong>.
        </p>
      </form>
    </div>
  </section>
</section>

<?php include __DIR__ . "/../vistas/footer.php"; ?>
