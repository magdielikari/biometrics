<?php

namespace app\controllers;

use Yii;
use app\models\Record;
use app\models\search\RecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RecordController implements the CRUD actions for Record model.
 */
class RecordController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Record models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Record model.
     * @param string $person_id
     * @param string $date_id
     * @return mixed
     */
    public function actionView($person_id, $date_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($person_id, $date_id),
        ]);
    }

    /**
     * Creates a new Record model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Record();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'person_id' => $model->person_id, 'date_id' => $model->date_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Record model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $person_id
     * @param string $date_id
     * @return mixed
     */
    public function actionUpdate($person_id, $date_id)
    {
        $model = $this->findModel($person_id, $date_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'person_id' => $model->person_id, 'date_id' => $model->date_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Record model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $person_id
     * @param string $date_id
     * @return mixed
     */
    public function actionDelete($person_id, $date_id)
    {
        $this->findModel($person_id, $date_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Record model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $person_id
     * @param string $date_id
     * @return Record the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($person_id, $date_id)
    {
        if (($model = Record::findOne(['person_id' => $person_id, 'date_id' => $date_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
