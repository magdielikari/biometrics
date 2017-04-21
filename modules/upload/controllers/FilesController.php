<?php

namespace app\modules\upload\controllers;

use Yii;
use app\controllers\FileController;
use app\modules\upload\models\Files;
use yii\web\UploadedFile;
use yii\web\UnsupportedMediaTypeHttpException;

class FilesController extends FileController
{
    /**
     * @inheritdoc
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                //'view' => 'upload/views/file/error.php'
            ],
        ];
    }
     */

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Creates a new File model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Files();

        if ($model->load(Yii::$app->request->post())) {
            //$id = Yii::$app->upload->file($model);
            $model->file = UploadedFile::getInstance($model,'file');
            if($model->file == null){
                throw new UnsupportedMediaTypeHttpException("Error!!!!");
            }
            // Defining auxiliary variables
            $ext = $model->file->extension;
            $token = Yii::$app->security->generateRandomString(23);
            // Instantiating the file object
            $model->name = $model->file->name;
            $model->size = $model->file->size;
            $model->error = $model->file->error;
            $model->path = 'excel/' . $token . '.' . $ext;        
            // Save the file and records in the database
            $model->file->saveAs($model->path);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

/*
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }
*/
}
