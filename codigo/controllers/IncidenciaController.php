<?php
namespace app\controllers;

use yii\web\Controller;

/*
  ================================
  FRONTEND
  ================================
  Controlador de incidencias.
  Solo renderiza la vista de listado.

  Vista asociada:
  - incidencia/index

  NOTA:
  - La obtención de incidencias por usuario
    se implementa en backend (modelo + consulta).
*/

class IncidenciaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
