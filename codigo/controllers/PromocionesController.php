<?php

namespace app\controllers;

use app\models\Promociones;
use app\models\PromocionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PromocionesController implements the CRUD actions for Promociones model.
 */
class PromocionesController extends Controller
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
	 * Lists all Promociones models.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		$searchModel = new PromocionesSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	/**
	 * Displays a single Promociones model.
	 * @param int $id_promocion Id Promocion
	 * @return string
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionView($id_promocion)
	{
		return $this->render('view', [
			'model' => $this->findModel($id_promocion),
		]);
	}

	/**
	 * Creates a new Promociones model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return string|\yii\web\Response
	 */
	public function actionCreate()
	{
		$model = new Promociones();

		if ($this->request->isPost) {
			if ($model->load($this->request->post()) && $model->save()) {
				return $this->redirect(['view', 'id_promocion' => $model->id_promocion]);
			}
		} else {
			$model->loadDefaultValues();
		}

		return $this->render('create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing Promociones model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param int $id_promocion Id Promocion
	 * @return string|\yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionUpdate($id_promocion)
	{
		$model = $this->findModel($id_promocion);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id_promocion' => $model->id_promocion]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Promociones model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param int $id_promocion Id Promocion
	 * @return \yii\web\Response
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	public function actionDelete($id_promocion)
	{
		$this->findModel($id_promocion)->delete();

		return $this->redirect(['index']);
	}

	/**
	 * Finds the Promociones model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param int $id_promocion Id Promocion
	 * @return Promociones the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id_promocion)
	{
		if (($model = Promociones::findOne(['id_promocion' => $id_promocion])) !== null) {
			return $model;
		}

		throw new NotFoundHttpException('The requested page does not exist.');
	}
}
