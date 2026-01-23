<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\Reservas;
use app\models\ReservasSearch;
use app\models\Vehiculos;
use app\models\Extras;
use app\models\Promociones;
use app\models\ReservaExtras;

class ReservasController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'rules' => [
					[
						'allow' => true,
						'actions' => ['reservar'], 
						'roles' => ['?', '@'],
					],
					[
						'allow' => true,
						'actions' => ['mis-reservas', 'cancelar', 'contrato'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['index', 'view', 'update', 'delete', 'reservar', 'mis-reservas', 'cancelar', 'contrato'],
						'matchCallback' => function ($rule, $action) {
							return !Yii::$app->user->isGuest && Yii::$app->user->identity->rol === 'Admin';
						},
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'delete' => ['POST'],
					'cancelar' => ['POST'],
				],
			],
		];
	}

	public function actionIndex()
	{
		$searchModel = new ReservasSearch();
		$dataProvider = $searchModel->search($this->request->queryParams);

		return $this->render('index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
		]);
	}

	public function actionView($id_reserva)
	{
		return $this->render('view', [
			'model' => $this->findModel($id_reserva),
		]);
	}

	public function actionUpdate($id_reserva)
	{
		$model = $this->findModel($id_reserva);

		if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
			return $this->redirect(['view', 'id_reserva' => $model->id_reserva]);
		}

		return $this->render('update', [
			'model' => $model,
		]);
	}

	public function actionDelete($id_reserva)
	{
		$this->findModel($id_reserva)->delete();
		return $this->redirect(['index']);
	}

	public function actionReservar($id_vehiculo)
	{
		if (Yii::$app->user->isGuest) {
			Yii::$app->session->setFlash('info', 'Para reservar un vehículo necesitas iniciar sesión o registrarte.');
			Yii::$app->user->returnUrl = ['reservas/reservar', 'id_vehiculo' => $id_vehiculo];
			return $this->redirect(['site/login']); 
		}

		$vehiculo = Vehiculos::findOne($id_vehiculo);
		if (!$vehiculo) throw new NotFoundHttpException("Vehículo no encontrado.");

		$model = new Reservas();
		$model->id_vehiculo = $id_vehiculo;
		
		$listaExtras = Extras::find()->all();
		$listaPromos = Promociones::find()
			->where(['>=', 'fecha_limite', date('Y-m-d')])
			->all();

		if ($this->request->isPost && $model->load($this->request->post())) {
			
			$model->id_usuario = Yii::$app->user->id;
			$model->fecha_creacion = date('Y-m-d H:i:s');
			$model->estado_reserva = 'Confirmada'; 

			$solapado = Reservas::find()
				->where(['id_vehiculo' => $id_vehiculo])
				->andWhere(['estado_reserva' => 'Confirmada'])
				->andWhere(['and', 
					['<=', 'fecha_inicio', $model->fecha_fin],
					['>=', 'fecha_fin', $model->fecha_inicio]
				])
				->exists();

			if ($solapado) {
				Yii::$app->session->setFlash('error', 'El vehículo no está disponible en esas fechas. Ya existe una reserva activa.');
			} else {
				$fecha1 = new \DateTime($model->fecha_inicio);
				$fecha2 = new \DateTime($model->fecha_fin);
				$dias = $fecha1->diff($fecha2)->days;
				if ($dias < 1) $dias = 1;

				$precioDiaCoche = $vehiculo->categoria ? $vehiculo->categoria->precio_dia : 0;
				$totalCalculado = $dias * $precioDiaCoche;

				$idsExtrasSeleccionados = $this->request->post('extras_seleccionados', []);
				$lineasExtras = []; 

				foreach ($idsExtrasSeleccionados as $idExtra) {
					$extra = Extras::findOne($idExtra);
					if ($extra) {
						$costeLinea = ($extra->tipo_calculo === 'Por Dia') ? ($extra->precio * $dias) : $extra->precio;
						$totalCalculado += $costeLinea;
						
						$lineasExtras[] = [
							'id_extra' => $extra->id_extra,
							'precio_unitario' => $extra->precio,
							'total_linea' => $costeLinea
						];
					}
				}

				if (!empty($model->id_promocion)) {
					$promo = Promociones::findOne($model->id_promocion);
					if ($promo && $promo->fecha_limite >= date('Y-m-d')) {
						$descuento = $totalCalculado * ($promo->porcentaje_descuento / 100);
						$totalCalculado -= $descuento;
					}
				}

				$model->coste_total = $totalCalculado;

				$transaction = Yii::$app->db->beginTransaction();
				try {
					if ($model->save()) {
						foreach ($lineasExtras as $linea) {
							$resExtra = new ReservaExtras();
							$resExtra->id_reserva = $model->id_reserva;
							$resExtra->id_extra = $linea['id_extra'];
							$resExtra->cantidad = 1;
							$resExtra->precio_unitario_aplicado = $linea['precio_unitario'];
							$resExtra->total_linea = $linea['total_linea'];
							$resExtra->save();
						}
						$transaction->commit();
						Yii::$app->session->setFlash('success', '¡Reserva confirmada! Total: ' . number_format($totalCalculado, 2) . '€');
						return $this->redirect(['reservas/mis-reservas']);
					}
				} catch (\Exception $e) {
					$transaction->rollBack();
					Yii::$app->session->setFlash('error', 'Error al guardar la reserva.');
				}
			}
		}

		return $this->render('reservar', [
			'model' => $model,
			'vehiculo' => $vehiculo,
			'listaExtras' => $listaExtras,
			'listaPromos' => $listaPromos,
		]);
	}

	public function actionMisReservas()
	{
		$reservas = Reservas::find()
			->where(['id_usuario' => Yii::$app->user->id])
			->orderBy(['fecha_creacion' => SORT_DESC])
			->all();

		return $this->render('mis-reservas', [
			'reservas' => $reservas,
		]);
	}

	public function actionCancelar($id_reserva)
	{
		$model = $this->findModel($id_reserva);

		if ($model->id_usuario != Yii::$app->user->id && Yii::$app->user->identity->rol !== 'Admin') {
			throw new \yii\web\ForbiddenHttpException('No tienes permiso.');
		}

		if ($model->estado_reserva === 'Confirmada') {
			$model->estado_reserva = 'Cancelada';
			$model->save();
			Yii::$app->session->setFlash('success', 'Reserva cancelada.');
		} else {
			Yii::$app->session->setFlash('warning', 'No se puede cancelar esta reserva.');
		}

		return $this->redirect(['mis-reservas']);
	}

	public function actionContrato($id_reserva)
	{
		return $this->redirect(['contratos/ver', 'id_reserva' => $id_reserva]);
	}

	protected function findModel($id_reserva)
	{
		if (($model = Reservas::findOne(['id_reserva' => $id_reserva])) !== null) {
			return $model;
		}
		throw new NotFoundHttpException('La reserva solicitada no existe.');
	}
}