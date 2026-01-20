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

    public function actionCrear()
    {
        $request = \Yii::$app->request;

        if ($request->isPost) {
            // 1. Recoger datos del formulario (incluido el nuevo código)
            $id_vehiculo = $request->post('id_vehiculo');
            $fecha_inicio = $request->post('fecha_inicio');
            $fecha_fin = $request->post('fecha_fin');
            $codigo_promo = $request->post('codigo_promo'); // <--- El campo nuevo
            
            // Asegurarnos de que el usuario está logueado
            if (\Yii::$app->user->isGuest) {
                return $this->redirect(['site/login']);
            }
            $id_usuario = \Yii::$app->user->id;

            // 2. Llamar al Procedimiento Almacenado (sp_RegistrarReserva)
            try {
                \Yii::$app->db->createCommand("CALL sp_RegistrarReserva(:uid, :vid, :ini, :fin, :cod)")
                    ->bindValues([
                        ':uid' => $id_usuario,
                        ':vid' => $id_vehiculo,
                        ':ini' => $fecha_inicio,
                        ':fin' => $fecha_fin,
                        ':cod' => $codigo_promo 
                    ])
                    ->execute();

                // 3. Éxito
                \Yii::$app->session->setFlash('success', '¡Reserva confirmada! Descuento aplicado si correspondía.');
                return $this->redirect(['reserva/mis-reservas']);

            } catch (\Exception $e) {
                // 4. Error (ej. fechas solapadas o fallo de BD)
                \Yii::$app->session->setFlash('error', 'No se pudo reservar: ' . $e->getMessage());
                return $this->redirect(['vehiculo/view', 'id' => $id_vehiculo]);
            }
        }

        // Si intentan entrar por GET, mandarlos a la home
        return $this->redirect(['site/index']);
    }
}

