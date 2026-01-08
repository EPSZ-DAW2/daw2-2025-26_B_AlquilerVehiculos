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
}
