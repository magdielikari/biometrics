<?php

namespace app\controllers;

use Yii;
use app\models\File;
use app\models\Upload;
use app\models\search\FileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FileController implements the CRUD actions for File model.
 */
class FileController extends Controller
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
     * Lists all File models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single File model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new File();

        if ($model->load(Yii::$app->request->post())) 
        {
            $id = Upload::file($model);
            return $this->redirect(['data', 'id' => $id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Import data of excel file to databases
     */
    public function actionData($id)
    {
        $model = $this->findModel($id);
        $status = Upload::data($id, $model);
        if($status)
        {
            return $this->redirect(['person', 'id' => $id]);
        }
    }

    /**
     * Import data of databases to person table
     */
    public function actionPerson($id)
    {
        $status = Upload::person($id);
        if( $status )
        {
            return $this->redirect(['event', 'app' => $id]);
        }
    }

    /**
     * Import data of databases to person table
     */
    public function actionEvent($app)
    {
        $status = Upload::event($app);
        if( $status )
        {
            return $this->redirect(['date']);
        }
    }

    /**
     * Import data of databases to person table
     */
    public function actionDate()
    {
        $status = Upload::date();
        if( $status )
        {
            return $this->redirect(['labor']);
        }
    }

    /**
     * Import data of databases to person table
     */
    public function actionLabor()
    {
        $status = Upload::labor();
        if( $status )
        {
            return $this->redirect(['record']);
        }
    }

    /**
     * Import data of databases to person table
     */
    public function actionRecord()
    {
        $status = Upload::record();
        if( $status )
        {
            return $this->redirect(['finish']);
        }
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the File model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return File the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = File::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
