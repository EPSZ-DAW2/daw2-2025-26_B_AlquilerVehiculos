<?php
use yii\helpers\Html;
use yii\helpers\Url;

/*
  ================================
  ADMIN - USUARIOS (Yii2 View)
  ================================
  Migración directa desde el admin/usuarios.php antiguo.

  CAMBIOS NECESARIOS (solo framework):
  - Sin session_start / includes
  - Sin $BASE_URL
  - action del form -> Url::to(['admin/usuario-guardar'])
*/

/*
  ================================
  INTEGRACIÓN CON BASE DE DATOS
  ================================
  Listado:
    SELECT id, nombre, apellidos, email, rol
    FROM usuarios
    ORDER BY id DESC;

  Editar:
    UPDATE usuarios SET nombre=?, apellidos=?, email=?, rol=? WHERE id=?;

  Nota importante:
  - No permitir eliminar el último admin (regla de negocio).
*/

$this->title = 'Admin - Usuarios';

$usuarios = $usuarios ?? [
  ['id'=>1,'nombre'=>'Juan Pérez','email'=>'juan@email.com','rol'=>'cliente'],
  ['id'=>2,'nombre'=>'María López','email'=>'maria@email.com','rol'=>'cliente'],
  ['id'=>3,'nombre'=>'Carlos Ruiz','email'=>'carlos@email.com','rol'=>'admin'],
];
?>

<section class="hero">
  <h1 class="h-title">Usuarios</h1>
  <p class="h-sub">Gestión de clientes y administradores (roles).</p>
</section>

<section class="card">
  <div class="card-h">
    <h3>Editar usuario</h3>
    <span class="small">POST</span>
  </div>

  <div class="card-b">
    <!-- =====================================================
         FORMULARIO EDITAR (POST)
         Ruta Yii2 sugerida: admin/usuario-guardar

         En backend (BD):
         - Validar id
         - UPDATE usuario
         - Validar reglas: no dejar el sistema sin admins
         ===================================================== -->
    <?= Html::beginForm(Url::to(['admin/usuario-guardar']), 'post') ?>
      <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()) ?>

      <div class="row2">
        <div class="field">
          <div class="label">ID (obligatorio)</div>
          <input type="number" name="id" min="1" required>
        </div>

        <div class="field">
          <div class="label">Rol</div>
          <select name="rol" required>
            <option value="cliente">Cliente</option>
            <option value="admin">Administrador</option>
          </select>
        </div>
      </div>

      <div class="row2">
        <div class="field">
          <div class="label">Nombre</div>
          <input type="text" name="nombre" placeholder="Opcional (si se quiere actualizar)">
        </div>

        <div class="field">
          <div class="label">Email</div>
          <input type="email" name="email" placeholder="Opcional (si se quiere actualizar)">
        </div>
      </div>

      <div class="actions">
        <button class="btn primary" type="submit">Guardar</button>
      </div>

      <hr class="sep"/>

      <p class="small">
        En BD: recomendable mantener integridad (email único, roles válidos, etc.).
      </p>
    <?= Html::endForm() ?>
  </div>
</section>

<div style="height:14px"></div>

<section class="card">
  <div class="card-h">
    <h3>Listado</h3>
    <span class="small"><?= count($usuarios) ?> registros</span>
  </div>

  <div class="card-b" style="padding:0">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Rol</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <?php $pillClass = (($u['rol'] ?? '') === 'admin') ? 'busy' : 'ok'; ?>
          <tr>
            <td><?= (int)$u['id'] ?></td>
            <td><?= Html::encode($u['nombre']) ?></td>
            <td><?= Html::encode($u['email']) ?></td>
            <td>
              <span class="pill <?= Html::encode($pillClass) ?>" style="position:static">
                <?= Html::encode($u['rol']) ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
