<?php
namespace app\controllers;

use yii\web\Controller;

/*
  ================================
  FRONTEND
  ================================
  Controlador de vehículos.
  Solo muestra vistas (listado y detalle).

  Vistas asociadas:
  - vehiculo/index
  - vehiculo/view
*/

class VehiculoController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id = null)
    {
        // El parámetro $id se usará en backend
        return $this->render('view');
    }
}
