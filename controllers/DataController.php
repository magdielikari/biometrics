<?php

namespace app\controllers;

use Yii;
use app\models\Data;
use app\models\Date;
use app\models\Person;
use app\models\search\DataSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DataController implements the CRUD actions for Data model.
 */
class DataController extends Controller
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
     * Lists all Data models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Data model.
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
     * Creates a new Data model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Data();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpload()
    {   
        $model = Data::find()
                ->select(['name','number'])
                ->where(['status'=>"0"])
                ->distinct()
                ->all();

        foreach ($model as $key) {
            $person = new Person();
            $person->ci = $key->number;
            $person->name = $key->name;
            $person->save();
        }
    }

    public function actionUp()
    {
        $model = Data::find()
                    ->
                    ->where(['status' => "0"])
                    ->all();
/*
SELECT DISTINCT Fecha, DiaS, Dia, Mes, Ano, Persona.Id from assistance inner join Persona on assistance.CI=Persona.Ci 
*/
        foreach ($model as $key) 
        {
            $aux = $key->time;
            $aux = strtotime($aux);
            $aux = getdate($aux);
            //$date = new Date();
            //$date->event = $model->$event;
            $a = $key->number;
            /*
            echo $key->id . "<br>";
            echo $a . "<br>";
            */
            //echo $key->number . "<br>";
            $person = Person::findOne([
                    'ci' => $a]);
            //echo $person . "<br>";

/*
                    ->distinct()
                    ->where('ci=:a')
                    ->addParams([':a' => $a])
                    ->all();
*/
            /*
            $query->where('status=:status')
                ->addParams([':status' => $status]);

            foreach ($person as $k) {
                echo $k->id . "<br>";
                echo $k->ci . "<br>";
            }
            */
            var_dump($person);
            //echo $person->id;
            //$date->persona_id = $person->id;
            /*
            foreach ($aux as $k => $v) 
            {
                
            } 
            */              
        }

    }

        /*
        foreach ($model as $key) {
            $a = $key->time;
            $b = strtotime($a);
            $c = getdate($b);
            $z = $key->id;
            echo $z . "<br>";
            foreach ($c as $k => $v) {
                echo "$k => $v"."<br>";
            }
        }
        for($id = 1; $id <= 2; $id++)
        {
           //$model = $this->findModel($id);
            $a = $model->time;
            echo $a . "<br>";
            $b = strtotime($a);
            echo $b . "<br>";
            $c = getdate($b);
            foreach ($c as $key => $value) {
                echo "$key => $value" . "<br>";
            }
            
            $c = date_create_from_format("j-M-Y", $b);
            $time = strtotime('10/16/2003');
            $newformat = date('Y-m-d',$time);
            echo $newformat;
            // 2003-10-16
        }
    }
        */


    /**
     * Updates an existing Data model.
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
     * Deletes an existing Data model.
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
     * Finds the Data model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Data the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Data::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
