<?php
namespace app\controllers;

use yii\web\Controller;

/*
  ================================
  FRONTEND
  ================================
  Controlador de reservas.
  Solo renderiza el contrato/resumen.

  Vista asociada:
  - reserva/contrato
*/

class ReservaController extends Controller
{
    public function actionContrato()
    {
        return $this->render('contrato');
    }
}
