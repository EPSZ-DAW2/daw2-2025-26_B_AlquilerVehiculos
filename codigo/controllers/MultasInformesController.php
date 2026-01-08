<?php

namespace app\controllers;

use app\models\MultasInformes;
use app\models\MultasInformesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MultasInformesController implements the CRUD actions for MultasInformes model.
 */
class MultasInformesController extends Controller
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
     * Lists all MultasInformes models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MultasInformesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MultasInformes model.
     * @param int $id_informe Id Informe
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_informe)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_informe),
        ]);
    }

    /**
     * Creates a new MultasInformes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
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

    /**
     * Updates an existing MultasInformes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_informe Id Informe
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
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

    /**
     * Deletes an existing MultasInformes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_informe Id Informe
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_informe)
    {
        $this->findModel($id_informe)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MultasInformes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_informe Id Informe
     * @return MultasInformes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_informe)
    {
        if (($model = MultasInformes::findOne(['id_informe' => $id_informe])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
