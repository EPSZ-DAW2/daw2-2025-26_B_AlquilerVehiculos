<?php
namespace app\controllers;

use yii\web\Controller;

/*
  ================================
  FRONTEND
  ================================
  Controlador del panel de administración.
  Solo muestra el dashboard (presentación).

  Vista asociada:
  - admin/dashboard

  NOTA:
  - Control de roles y permisos
    se gestiona en backend.
*/

class AdminController extends Controller
{
    public function actionDashboard()
    {
        return $this->render('dashboard');
    }
}
