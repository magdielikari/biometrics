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
use yii\helpers\VarDumper;
use yii\db\Query;

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
        return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    //print("<pre>".print_r($key,true)."</pre>");
    //print("<pre>".print_r($value,true)."</pre>");

    public function actionUp()
    {

        $query = (new Query())
            ->select(['time','event','person.id'])
            ->from('data')
            ->where(['status' => '0'])
            ->innerJoin('person','data.number=person.ci')
            ->all();
        
        $m = [];
        foreach ($query as $k => $v)
        {
            $m[$k] = $v;           
            foreach ($v as $key => $value) 
            {
                $m[$k][$key] = $value;
                if($key == 'time')
                {
                    $aux = $value;
                    $aux = strtotime($aux);
                    $aux = getdate($aux);
                    foreach ($aux as $a => $e) 
                    {
                        $m[$k][$a] = $e;
                    }
                }
            }   
        }

        foreach ($m as $k => $v) 
        {
            $model = new Date();
            $model->seconds = $v['seconds'];
            $model->minutes = $v['minutes'];
            $model->hours = $v['hours'];
            $model->number_day = $v['mday'];
            $model->number_weeks_day = $v['wday'];
            $model->number_month = $v['mon'];
            $model->year = $v['year'];
            $model->number_years_day = $v['yday'];
            $model->weekday = $v['weekday'];
            $model->month = $v['month'];
            $model->unix_time = $v['0'];
            $model->event = $v['event'];
            $model->persona_id = $v['id'];
            $model->save();
        }
    }

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
