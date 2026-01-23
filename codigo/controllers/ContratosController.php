<?php

namespace app\controllers;

use Yii;
use app\models\Contratos;
use app\models\Reservas; // Necesario para buscar la reserva del cliente
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl; // Importante para permisos

/**
 * ContratosController implements the CRUD actions for Contratos model.
 */
class ContratosController extends Controller
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::class,
					'rules' => [
						[
							'allow' => true,
							'actions' => ['ver'],
							'roles' => ['@'],
						],
						[
							'allow' => true,
							'actions' => ['index', 'view', 'create', 'update', 'delete', 'ver'],
							'matchCallback' => function ($rule, $action) {
								return Yii::$app->user->identity->rol === 'Admin';
							},
						],
					],
				],
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			]
		);
	}

	public function actionVer($id_reserva)
	{
		$query = Reservas::find()->where(['id_reserva' => $id_reserva]);
		
		if (Yii::$app->user->identity->rol !== 'Admin') {
			$query->andWhere(['id_usuario' => Yii::$app->user->id]);
		}
		
		$reserva = $query->one();

		if (!$reserva) {
			throw new NotFoundHttpException('No se encontró la reserva o no tienes permiso para ver este contrato.');
		}

		$contrato = $reserva->contrato;

		return $this->render('ver', [
			'reserva' => $reserva,
			'contrato' => $contrato,
		]);
	}

	public function actionIndex()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => Contratos::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id_contrato)
	{
		return $this->render('view', [
			'model' => $this->findModel($id_contrato),
		]);
	}

	public function actionCreate($id_reserva = null)
	{
		$model = new Contratos();

		if ($id_reserva) {
			$existente = Contratos::findOne(['id_reserva' => $id_reserva]);
			if ($existente) {
				return $this->redirect(['ver', 'id_reserva' => $id_reserva]);
			}
			$model->id_reserva = $id_reserva;
			$model->fecha_firma = date('Y-m-d H:i:s');
			$model->estado_contrato = 'Activo';
			$model->km_entrega = 0; 
		}

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				Yii::$app->session->setFlash('success', 'Contrato firmado correctamente.');
				
				return $this->redirect(['ver', 'id_reserva' => $model->id_reserva]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id_contrato)
	{
		$model = $this->findModel($id_contrato);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id_contrato' => $model->id_contrato]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionDelete($id_contrato)
	{
		$this->findModel($id_contrato)->delete();

		return $this->redirect(['index']);
	}

	protected function findModel($id_contrato)
	{
		if (($model = Contratos::findOne(['id_contrato' => $id_contrato])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}