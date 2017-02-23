<?php

namespace app\controllers;

use Yii;
use yii\db\Query;
use app\models\Data;
use app\models\Date;
use app\models\Event;
use app\models\Person;
use app\models\Record;
use app\models\Labor;
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

    /**
     *
     */
    public function actionImport($app)
    {   
        $model = Data::find()
                ->select(['name','number'])
                ->where(['file_id' => $app])
                ->distinct()
                ->all();

        $personAll = Person::find()
                ->select(['ci'])
                ->all();

        foreach ( $model as $key ) 
        {
            /** 
             * If $flat is true => $person exist on database
             */
            $flat = false;
            foreach ( $personAll as $k )
            {
                if ( $key->number == $k->ci )
                {
                    $flat = true;
                }
            }
            if ( $flat == false )
            {
                $person = new Person();
                $person->ci = $key->number;
                $person->name = $key->name;
                $person->file_id = $app;
                $person->save();
            }
        }

        $status = true;
        if( $status )
        {
            return $this->redirect(['upload', 'app' => $app]);
        } else {
            return $this->render('import');
        }
    }

    /**
     *
     */
    public function actionUpload($app)
    {
        $query = (new Query())
            ->select(['time','event','person.id','data.file_id'])
            ->from('data')
            ->where(['data.file_id' => $app])
            ->innerJoin('person','data.number=person.ci')
            ->all();
        //print("<pre>".print_r($query,true)."</pre>");
        
        $m = [];
        foreach ( $query as $k => $v )
        {
            $m[$k] = $v;           
            foreach ( $v as $key => $value ) 
            {
                $m[$k][$key] = $value;
                if ( $key == 'time' )
                {
                    $aux = $value;
                    $aux = strtotime($aux);
                    $aux = getdate($aux);
                    foreach ( $aux as $a => $e ) 
                    {
                        $m[$k][$a] = $e;
                    }
                }
            }   
        }

        $eventAll = Event::find()
                ->select(['unix_time'])
                ->all();

        foreach ( $m as $k => $v ) 
        {
            /**
             * If $flat is true => $event exist on database
             */
            $flat = false;
            foreach ( $eventAll as $kk )
            {
                if ( $v['0'] == $kk->unix_time )
                {
                    $flat = true;
                }
            }

            if( $flat == false )
            {    
                $model = new Event();
                $model->year = $v['year'];
                $model->number_years_day = $v['yday'];
                $model->unix_time = $v['0'];
                $model->event = $v['event'];
                $model->person_id = $v['id'];
                $model->save();
            }
        }
        $status = true;
        if($status)
        {
            return $this->redirect(['finish']);
        } else {
            return $this->render('upload');
        }
    }

    /**
     *
     */
    public function actionDate()
    {
        $eventAll = Event::find()
                ->select(['year','number_years_day'])
                ->distinct()
                ->all();

        $dateAll = Date::find()
                ->select(['year','number_years_day'])
                ->all();

        foreach ( $eventAll as $key ) 
        {
            /**
             * If $flat is true => $date exist on database
             */
            $flat = false;

            foreach ( $dateAll as $k )
            {
                if ( $key->number_years_day == $k->number_years_day ) 
                {
                    if ( $key->year == $k->year )
                    {
                        $flat = true;
                    }
                }
            }

            /**
             *  mktime(hour, minute, second, month, day, year) => Approach below so it is necessary to increase one day
             */ 
            $v = getdate(mktime(0, 0, 0, 1, $key->number_years_day+1, $key->year));

            if ($flat == false)
            {
                $model = new Date();
                $model->number_day = $v['mday'];
                $model->number_weeks_day = $v['wday'];
                $model->number_month = $v['mon'];
                $model->year = $v['year'];
                $model->number_years_day = $v['yday'];
                $model->weekday = $v['weekday'];
                $model->month = $v['month'];
                $model->save();
            }
        }
    }

    public function actionRecord()
    {
        $persons = Person::find()
                ->all();
        
        $dates = Date::find()
                ->all();

        foreach ($persons as $person) 
        {
            foreach ($dates as $date) 
            {
                print("<pre>".print_r($date,true)."</pre>");
                $exist = Record::find()
                        ->where(['person_id' => $person->id,'date_id' => $date->id])
                        ->exists();
                if(!$exist)
                {
                    $counter = Event::find()
                            ->where(['person_id' => $person->id,'year' => $date->year, 'number_years_day' => $date->number_years_day])
                            ->count();
                    $min = Event::find()
                            ->where(['person_id' => $person->id,'year' => $date->year, 'number_years_day' => $date->number_years_day])
                            ->min('unix_time');
                    $max = Event::find()
                            ->where(['person_id' => $person->id,'year' => $date->year, 'number_years_day' => $date->number_years_day])
                            ->max('unix_time');
                    $average = Event::find()
                            ->where(['person_id' => $person->id,'year' => $date->year, 'number_years_day' => $date->number_years_day])
                            ->average('unix_time');
/*
                    $record = new Record();
                    $record->person_id = $person->id;
                    $record->date_id = $date->id;
                    $record->counter = $counter;
                    $record->max = $max;
                    $record->min = $min;
                    $record->average = round($average);
                    $record->save();
*/
                }
                echo "Fin <br>";
            }
        }
    }

    //print("<pre>".print_r($counter,true)."</pre>");

    public function actionLabor()
    {
        $person = Person::find()
                ->all();
        
        $date = Date::find()
                ->all();

        foreach ($person as $key) 
        {
            foreach ($date as $k) 
            {
                $in_data = Event::find()
                        ->select('unix_time')
                        ->where(['person_id' => $key->id,
                            'year' => $k->year, 
                            'number_years_day' => $k->number_years_day,
                            'event' => 'Entrada Principal' ])
                        ->asArray()
                        ->all();
                if(!empty($in_data))
                {
                    $out_data = Event::find()
                            ->select('unix_time')
                            ->where(['person_id' => $key->id,
                                'year' => $k->year, 
                                'number_years_day' => $k->number_years_day,
                                'event' => '192.168.10.15'])
                            ->asArray()
                            ->all();
                    if(!empty($out_data))
                    {
                        $i = 0;
                        $out_arr = [];
                        foreach ($out_data as $z)
                        {
                            foreach ($z as $x)
                            {
                                $a = 'o' . strval($i);
                                $out_arr[$a] = $x; 
                                $i++;
                            }
                        }
                        $i = 0;
                        $in_arr = [];
                        foreach ($in_data as $z)
                        {
                            foreach ($z as $x)
                            {
                                $a = 'i' . strval($i);
                                $in_arr[$a] =  $x;
                                $i++; 
                            }
                        }
                        $tot = array_merge($in_arr,$out_arr);
                        asort($tot);
                        /*
                        print("<pre>".print_r($tot,true)."</pre>");
                        echo 'Principio <br>';
                        */
                        $out = 0;
                        foreach ($tot as $kk => $in) 
                        {
                            if ( $this->in( $kk ) )
                            {
                                if ( $in > $out )
                                {
                                    $a = [];
                                    foreach ($out_arr as $kkk => $vvv) 
                                    {
                                        if ( $vvv - $in < 0)
                                        {
                                            /**
                                             *  Seconds of a day
                                             */
                                            $e = 86400;
                                        }else
                                        {
                                            $e = $vvv - $in;
                                        }
                                        array_push($a,$e);
                                    }
                                    $time = min($a);
                                    $out = $in + $time;
                                    if ( $time<86400 )
                                    {
                                        //echo $in .' - '. $out .' = ' . $time .'<br>';
                                        $exist = Labor::find()
                                                ->where(['person_id' => $key->id,'date_id' => $k->id,'in' => $in,'out' => $out])
                                                ->exists();
                                        if(!$exist)
                                        {   
                                            $labor = new Labor();
                                            $labor->person_id = $key->id;
                                            $labor->date_id = $k->id;
                                            $labor->in = $in;
                                            $labor->out = $out;
                                            $labor->save();
                                        }
                                    } 
                                }
                            }else
                            {
                                $out = $in; 
                            }
                        }
                        //echo 'Finnn <br>' ;
                    }
                }
            }
        }
    }

    public function in($i)
    {
        $a = substr($i,0,1);
        if ( $a == 'i')
        {
            $flat = 1;
        }else
        {
            $flat = 0;
        }
        return $flat;
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
