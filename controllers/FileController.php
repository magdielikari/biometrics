<?php

namespace app\controllers;

use Yii;
use app\models\File;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\components\helpers\MyQuery;
use app\models\search\FileSearch;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use yii\web\UnsupportedMediaTypeHttpException;

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
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException("Error!!!!");
        }

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
    public function actionView($id,$event1 = null, $date1 =null, $worked1 =null, $record1 = null)
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException("Error!!!!");
        }
        $data = MyQuery::count('data','file_id',$id);
        $person = MyQuery::count('person','file_id',$id);
        if (isset($event1) && isset($date1) && isset($worked1) && isset($record1)){
            $event2 = MyQuery::count('event');
            $date2 = MyQuery::count('date');
            $worked2 = MyQuery::count('worked');
            $record2 = MyQuery::count('record');
            $event = $event2 - $event1;
            $date = $date2 - $date1;
            $worked = $worked2 - $worked1;
            $record = $record2 - $record1;
        } else {
            $event = null;
            $date = null;
            $worked = null;
            $record = null;
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
            'data' => $data,
            'person' => $person,
            'event' => $event,
            'date' => $date,
            'worked' => $worked,
            'record' => $record
            ]);
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException("Error!!!!");
        }

        $model = new File();
        $this->handle($model);

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing File model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException("Error!!!!");
        }

        $model = $this->findModel($id);
        $this->handleFile($model);

        return $this->render('update', [
            'model' => $model,
        ]);
    }
     */

    /**
     * Deletes an existing File model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
    public function actionDelete($id)
    {
        if (Yii::$app->user->isGuest) {
            throw new UnauthorizedHttpException("Error!!!!");
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
     */

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

    /**
     * Upload file to the system
     */ 
    protected function handle(File $model)
    {
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model,'file');
            if (!isset($model->file)) {
                throw new NotFoundHttpException("Error Processing the File");
            }
            $ext = $model->file->extension;
            print("<pre>".print_r($ext,true)."</pre>");
            if(strcmp($ext,'xls') != 0 || !strcmp($ext,'xlsx') != 0) {
                throw new UnsupportedMediaTypeHttpException("Error Processing Request");
            }
            $token = Yii::$app->security->generateRandomString(23);
            $model->path = 'excel/' . $token . '.' . $ext;
            $model->file->saveAs($model->path);
            $model->error = $model->file->error;
            if ($model->error != '0') {
                throw new NotFoundHttpException("Error Saved the File");
            }
            // ---
            $event1 = MyQuery::count('event');
            $date1 = MyQuery::count('date');
            $worked1 = MyQuery::count('worked');
            $record1 = MyQuery::count('record');
            $model->size = $model->file->size;
            $model->name = $model->file->name;
            if ($model->save(false)) {
                $id = $model->id;
                // ---    
                $user = Yii::$app->get('user', false);
                $user = $user && !$user->isGuest ? $user->id : 0;
                // Ojo: en la base de dato el Usurio 0 es por defecto, no debe de existir otro usuario real con ese id
                $runner = new \tebazil\runner\ConsoleCommandRunner();
                $runner->run('upload/data', [$id, $user]);
                $output = $runner->getOutput();
                $exitCode = $runner->getExitCode();
                return $this->redirect(['view', 
                   'id' => $id, 'event1' => $event1, 
                   'date1' => $date1, 'worked1' => $worked1,
                   'record1' => $record1]);
            }
        }
    }
}
