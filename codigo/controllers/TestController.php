<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class TestController extends Controller
{
	/**
	 *
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}
	
	public function actionBuscarLenguaje( $term=null)
	{
	  $json= [];
	  if (!empty( $term)) {

		$datos= [ 
			'c', 'c++', 'java', 'php', 'coldfusion', 'javascript', 
			'asp', 'ruby', 'perl', 'python', 'ada', 'cobol', 'erlang', 
			'pascal', 'c#' 
		];
		asort( $datos);
		foreach( $datos as $i => $lenguaje) {
		  if (preg_match( '/'.preg_quote( $term).'/iu', $lenguaje)) {
			$json[]= ['id'=>$i, 'label'=>$lenguaje, 'value'=>$lenguaje];
		  }
		}
		
	  }
	  Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
	  Yii::$app->response->charset= 'UTF-8';
	  return $json;
	}
	
}
