<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Registro;
use app\models\Usuarios;

class SiteController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::class,
				'only' => ['logout'],
				'rules' => [
					[
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::class,
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
			'captcha' => [
				'class' => 'yii\captcha\CaptchaAction',
				'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
			],
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex()
	{
		return $this->render('index');
	}

	/**
	 * Login action.
	 *
	 * @return Response|string
	 */
	public function actionLogin()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}

		$model = new LoginForm();
		if ($model->load(Yii::$app->request->post()) && $model->login()) {
			return $this->goBack();
		}

		$model->password = '';
		return $this->render('login', [
			'model' => $model,
		]);
	}

	public function actionRegister()
	{
		$model = new Registro();

		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->registrar()) {
				Yii::$app->session->setFlash('success', 'Cuenta creada con éxito. Por favor inicia sesión.');
				return $this->redirect(['site/login']);
			}
		}

		return $this->render('register', [
			'model' => $model,
		]);
	}

	/**
	 * Logout action.
	 *
	 * @return Response
	 */
	public function actionLogout()
	{
		Yii::$app->user->logout();

		return $this->goHome();
	}

	/**
	 * Displays contact page.
	 *
	 * @return Response|string
	 */
	public function actionContact()
	{
		$model = new ContactForm();
		if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
			Yii::$app->session->setFlash('contactFormSubmitted');

			return $this->refresh();
		}
		return $this->render('contact', [
			'model' => $model,
		]);
	}

	/**
	 * Displays about page.
	 *
	 * @return string
	 */
	public function actionAbout()
	{
		return $this->render('about');
	}

	public function actionPerfil()
	{
		if (Yii::$app->user->isGuest) {
			return $this->redirect(['site/login']);
		}

		$id = Yii::$app->user->id;
		$model = Usuarios::findOne($id);
		$model->scenario = Usuarios::SCENARIO_PERFIL;
		$passAntigua = $model->password;
		$model->password = '';

		if ($this->request->isPost && $model->load($this->request->post())) {
			if (empty($model->password)) {
				$model->password = $passAntigua;
			}
			if ($model->save()) {
				Yii::$app->session->setFlash('success', 'Tus datos se han actualizado correctamente.');
				return $this->refresh();
			}
		}

		return $this->render('perfil', [
			'model' => $model,
		]);
	}
}
