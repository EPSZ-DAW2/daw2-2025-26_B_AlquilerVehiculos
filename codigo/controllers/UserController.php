<?php
namespace app\controllers;

use yii\web\Controller;

/*
  ================================
  FRONTEND
  ================================
  Controlador de usuario.
  Solo muestra el perfil.

  Vista asociada:
  - user/perfil
*/

class UserController extends Controller
{
    public function actionPerfil()
    {
        return $this->render('perfil');
    }
}
