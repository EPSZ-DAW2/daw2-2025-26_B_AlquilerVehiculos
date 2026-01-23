<?php

namespace app\controllers;

use Yii;
use app\models\MultasInformes;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * MultasInformesController: Gestiona tanto el panel de Admin como la vista de Cliente.
 */
class MultasInformesController extends Controller
{
	/**
	 * CONFIGURACIÓN DE PERMISOS
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'access' => [
					'class' => AccessControl::class,
					'rules' => [
						// REGLA 1: Clientes registrados (Ver sus multas)
						[
							'allow' => true,
							'actions' => ['mis-incidencias'],
							'roles' => ['@'],
						],
						// REGLA 2: Administradores (CRUD Completo)
						[
							'allow' => true,
							'actions' => ['index', 'view', 'create', 'update', 'delete', 'mis-incidencias'],
							'matchCallback' => function ($rule, $action) {
								return !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'Admin';
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

	public function actionIndex()
	{
		$searchModel = new \app\models\MultasInformesSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id_informe)
	{
		return $this->render('view', [
			'model' => $this->findModel($id_informe),
		]);
	}

	public function actionCreate()
	{
		$model = new MultasInformes();

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id_informe' => $model->id_informe]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	public function actionUpdate($id_informe)
	{
		$model = $this->findModel($id_informe);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id_informe' => $model->id_informe]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionDelete($id_informe)
	{
		$this->findModel($id_informe)->delete();

		return $this->redirect(['index']);
	}

	public function actionMisIncidencias()
	{
		$idUsuario = Yii::$app->user->id;

		$incidencias = MultasInformes::find()
			->joinWith(['reserva']) 
			->where(['reservas.id_usuario' => $idUsuario])
			->orderBy(['fecha_incidencia' => SORT_DESC])
			->all();

		return $this->render('mis-incidencias', [
			'incidencias' => $incidencias,
		]);
	}

	protected function findModel($id_informe)
	{
		if (($model = MultasInformes::findOne(['id_informe' => $id_informe])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('La página solicitada no existe.');
	}
}