<?php
namespace app\controllers;
use app\models\Contrato;
use app\models\Reserva;

use Yii;
use yii\web\Controller;
use yii\web\Response;

/*
  =====================================================
  ADMIN CONTROLLER (FRONT COMPLETO)
  =====================================================
  - Este controlador sirve SOLO para que el panel admin funcione en front.
  - No usa $_SESSION / $_POST / $_GET directamente.
  - Los endpoints POST son placeholders (redirigen), listos para conectar BD.

  IMPORTANTE (BACKEND):
  - Proteger /admin/* con AccessControl o RBAC (rol admin).
  - En producción, validar permisos en cada acción.
*/

class AdminController extends Controller
{

    public $layout = 'admin';

    /* ============================
       PÁGINAS ADMIN (GET)
       ============================ */

    // /index.php?r=admin/dashboard
    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    // /index.php?r=admin/contratos
    public function actionContratos()
    {
        // 1. Buscamos todos los contratos en la BD
        // Usamos 'with' para traer también los datos de la reserva, usuario y vehículo de una sola vez (más rápido)
        $contratos = Contrato::find()
            ->with(['reserva.usuario', 'reserva.vehiculo'])
            ->orderBy(['id_contrato' => SORT_DESC])
            ->all();

        // 2. Enviamos los datos reales a la vista
        return $this->render('contratos', [
            'contratos' => $contratos
        ]);
    }

    // /index.php?r=admin/incidencias
    public function actionIncidencias()
    {
        return $this->render('incidencias');
    }

    // /index.php?r=admin/usuarios
    public function actionUsuarios()
    {
        return $this->render('usuarios');
    }

    // /index.php?r=admin/vehiculos
    public function actionVehiculos()
    {
        return $this->render('vehiculos');
    }

    /* ============================
       ENDPOINTS (POST) - PLACEHOLDER
       ============================ */

    // POST: cambiar estado de un contrato (ej. cancelar)
    // Ruta usada en la vista: admin/contrato-estado
    public function actionContratoEstado(): Response
    {
        $post = Yii::$app->request->post();

        /*
          ======= BD (backend) =======
          $id = $post['id_contrato'] ?? null;
          $estado = $post['nuevo_estado'] ?? null;

          - Validar rol admin
          - Validar contrato existe
          - UPDATE contratos SET estado=:estado WHERE id=:id;
        */

        return $this->redirect(['admin/contratos']);
    }

    // POST: guardar/editar usuario
    // Ruta usada en la vista: admin/usuario-guardar
    public function actionUsuarioGuardar(): Response
    {
        $post = Yii::$app->request->post();

        /*
          ======= BD (backend) =======
          - Validar rol admin
          - Validar id
          - UPDATE usuarios SET ... WHERE id=?
          - Reglas: no dejar el sistema sin admins, email único, etc.
        */

        return $this->redirect(['admin/usuarios']);
    }

    // POST: guardar/editar incidencia
    // Ruta usada en la vista: admin/incidencia-guardar
    public function actionIncidenciaGuardar(): Response
    {
        $post = Yii::$app->request->post();

        /*
          ======= BD (backend) =======
          - Validar rol admin
          - Validar FK contrato existe
          - INSERT/UPDATE incidencias
        */

        return $this->redirect(['admin/incidencias']);
    }

    // POST: guardar/editar vehículo
    // Ruta usada en la vista: admin/vehiculo-guardar
    public function actionVehiculoGuardar(): Response
    {
        $post = Yii::$app->request->post();

        /*
          ======= BD (backend) =======
          - Validar rol admin
          - Si viene id => UPDATE
          - Si no viene id => INSERT
          - Validar categoría/precio/estado/histórico
        */

        return $this->redirect(['admin/vehiculos']);
    }

    // POST: baja lógica de vehículo
    // Ruta usada en la vista: admin/vehiculo-baja
    public function actionVehiculoBaja(): Response
    {
        $post = Yii::$app->request->post();

        /*
          ======= BD (backend) =======
          $id = $post['id'] ?? null;

          - Validar rol admin
          - UPDATE vehiculos SET historico='baja' WHERE id=:id
        */

        return $this->redirect(['admin/vehiculos']);
    }
}

