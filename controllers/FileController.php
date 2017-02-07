<?php

namespace app\controllers;

use Yii;
use app\models\File;
use app\models\Data;
use app\models\search\FileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
            $image = $model->name;
            $model->file = UploadedFile::getInstance($model,'file');
            $model->file->saveAs('excel/'.$image.'.'.$model->file->extension);
            // Save the path and date time of file
            $model->path = 'excel/'.$image.'.'.$model->file->extension;
            $model->create_at = date('Y-m-d h:m:s');
            $model->update_at = date('Y-m-d h:m:s');
            $model->save();
            return $this->redirect(['import', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionImport($id)
    {
        $status = 'no';
        $model = $this->findModel($id);
        $inputFile = $model->path;
        try
        {
            $dota = \moonland\phpexcel\Excel::import($inputFile,[
                'setFirstRecordAsKeys' => false,
                'setIndexSheetByName' => true, 
                'getOnlySheet' => 'sheet1'
            ]);
        }catch(Exception $e)
        {
        die('Error');
        }
        $N = count($dota);
        for($row = 1; $row <= $N; $row++)
        {
            if($row == 1)
            {
            continue;
            }
            $data = new Data();
            //$data->id 
            $data->time = $dota[$row]['A'];
            $data->number = $dota[$row]['B'];
            $data->name = $dota[$row]['C'];
            $data->event = $dota[$row]['F'];
            $data->create_at = date('Y-m-d h:m:s');
            $data->save();
            print_r($data->getErrors());
        }
        $status = 'ok';
        return $this->render('import', [
            'model' => $this->findModel($id),
            'status'
        ]);

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
