<?php

namespace app\controllers;

use app\models\Vehiculos;
use app\models\VehiculosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\VehiculosPublicSearch;

/**
 * VehiculosController implements the CRUD actions for Vehiculos model.
 */
class VehiculosController extends Controller
{
	/**
	 * @inheritDoc
	 */
	public function behaviors()
	{
		return array_merge(
			parent::behaviors(),
			[
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'delete' => ['POST'],
					],
				],
			]
		);
	}

	/**
	 * Lists all Vehiculos models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new VehiculosSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Vehiculos model.
	 * @param int $id_vehiculo Id Vehiculo
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id_vehiculo)
	{
		return $this->render('view', [
			'model' => $this->findModel($id_vehiculo),
		]);
	}

	/**
	 * Creates a new Vehiculos model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Vehiculos();

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id_vehiculo' => $model->id_vehiculo]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Vehiculos model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id_vehiculo Id Vehiculo
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id_vehiculo)
	{
		$model = $this->findModel($id_vehiculo);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id_vehiculo' => $model->id_vehiculo]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Vehiculos model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id_vehiculo Id Vehiculo
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id_vehiculo)
	{
		$this->findModel($id_vehiculo)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Vehiculos model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id_vehiculo Id Vehiculo
	 * @return Vehiculos the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id_vehiculo)
	{
		if (($model = Vehiculos::findOne(['id_vehiculo' => $id_vehiculo])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
	
	public function actionFlota()
	{
		$this->layout = 'main';

		$searchModel = new VehiculosPublicSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('flota', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}
}
