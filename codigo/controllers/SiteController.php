<?php
namespace app\controllers;

use yii\web\Controller;

/*
  ================================
  FRONTEND
  ================================
  Controlador principal.
  Solo renderiza vistas (sin lógica).

  Vistas asociadas:
  - site/index
  - site/login
  - site/registro
  - site/error
*/

class SiteController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        return $this->render('login');
    }

    public function actionRegistro()
    {
        return $this->render('registro');
    }

    public function actionError()
    {
        return $this->render('error');
    }
}
