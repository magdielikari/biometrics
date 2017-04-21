<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Yii;
use yii\db\Query;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\console\Exception;
use yii\console\Controller;
use yii\db\Migration;
/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UploadController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionData($id, $user)
    {
        // if (Yii::$app instanceof Yii\console\Application) -> no me funciono
        // Guard Clause, validating that $ id exists
		if ( !isset($id) ){
			throw new Exception("Id empty()");
		}
		$file = (new Query())
			->select(['path'])
			->from('file')
			->where(['id' => $id])
			->all();
	    $inputFile = 'C:\xampp\htdocs\biometrics\web/' . $file[0]['path'];
        // Read and save in $dota the excel file
        try{
            $dota = \moonland\phpexcel\Excel::import($inputFile,[
                'setFirstRecordAsKeys' => false,
                'setIndexSheetByName' => true, 
                'getOnlySheet' => 'sheet1'
            ]);
        }
        catch(Exception $err){
            throw new Exception("Id empty()");
        }
        // Extracting the columns of $dota in arrays
        foreach ($dota as $key => $value ) {
            if ($key == 1){
                continue;
            }
            $ti[] = ArrayHelper::getValue($dota[$key], 'A');
            $nu[] = ArrayHelper::getValue($dota[$key], 'B');
            $na[]   = ArrayHelper::getValue($dota[$key], 'C');
            $ev[]  = ArrayHelper::getValue($dota[$key], 'F');      
        }
        // Erasing nulls value value of the arrays
        foreach ($ti as $key) {
            if ($key !== null){
                $time[] = $key;
            }
        }
        foreach ($na as $key) {
            if ($key !== null){
                $name[] = $key;
            }
        }
        foreach ($nu as $key) {
            if ($key !== null){
                $number[] = $key;
            }   
        }
        foreach ($ev as $key) {
            if ($key !== null){
                $event[] = $key;
            }   
        }
        $a = [
            count($time), 
            count($number), 
            count($name), 
            count($event)
        ];
        // The minimum eliminates incomplete data 
        $n = min($a);
        for ( $i = 0; $i < $n; $i++ ){
            $row[] = [
                $time[$i],
                $number[$i],
                $name[$i],
                $event[$i],
                time(),
                $user,
                time(),
                $user,
                $id
            ]; 
        }
        // Grouping the arrays into an matrix
        $columms = [
            'time', 
            'number', 
            'name', 
            'event', 
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'file_id'
        ];

        Yii::$app
            ->db
            ->createCommand()
            ->batchInsert('data', $columms, $row)
            ->execute();

        return $this->runAction("person", [$id, $user]);
    }

    /**
     *  
     */
    public function actionPerson($id, $user)
    {
        $person = (new Query())
            ->select(['ci'])
            ->from(['person'])
            ->all();
        // Transforming the matrix into $array;    
        $all = [];
        foreach ($person as $key => $value) {
            foreach ($value as $kk => $vv) {
                $all[] = $vv;    
            }
        }

        $model = (new Query())
            ->select(['name','number'])
            ->from('data')
            ->where(['file_id' => $id])
            ->distinct()
            ->all();

        $row = [];
        foreach ($model as $key => $value) {   
            $flat = false;
            foreach ($value as $k => $v) {
                foreach ($all as $kk => $vv) {
                // If $flat is true => $person exist on database
                    if ($vv == $v){
                        $flat = true;
                    }
                }
            }
            // Grouping the arrays into an matrix
            if ($flat == false) {
                $row[] = [
                    $value['name'],
                    $value['number'],
                    time(),
                    $user,
                    time(),
                    $user,
                    $id,
                ];
            }
        }

        $columns = [
            'name', 
            'ci', 
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'file_id',
        ];

        if(isset($row)){
            Yii::$app
                ->db
                ->createCommand()
                ->batchInsert('person', $columns, $row)
                ->execute();                
        }

        return $this->runAction("event", [$id, $user]);
    }

    /**
     * 
     */
    public function actionEvent($id, $user)
    {
        $query = (new Query())
            ->select(['time','event','person.id','data.file_id'])
            ->from('data')
            ->where(['data.file_id' => $id])
            ->innerJoin('person','data.number=person.ci')
            ->all();

        $m = [];
        foreach ($query as $k => $v){
            $m[$k] = $v;           
            foreach ($v as $key => $value) {
                $m[$k][$key] = $value;
                if ($key == 'time'){
                    $aux = $value;
                    $aux = strtotime($aux);
                    $aux = getdate($aux);
                    foreach ($aux as $a => $e){
                        $m[$k][$a] = $e;
                    }
                }
            }   
        }

        $eventAll = (new Query())
            ->select(['unix_time'])
            ->from('Event')
            ->all();

        $row = [];
        foreach ( $m as $k => $v ) 
        {
            // If $flat is true => $event exist on database
            $flat = false;
            foreach ( $eventAll as $kk ){
                if ( $v['0'] == $kk['unix_time'] ){
                    $flat = true;
                }
            }
            // Grouping the arrays into an matrix
            if( $flat == false ){    
                $row[] = [
                    $v['year'],
                    $v['yday'],
                    (int) $v['0'],
                    $v['event'],
                    (int) time(),
                    $user,
                    (int) time(),
                    $user,
                    (int) $v['id'],
                ];
            }
        }

        $columns = [
            'year',
            'number_years_day',
            'unix_time',
            'event',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'person_id'
        ];

        if(isset($row)){
            Yii::$app
                ->db
                ->createCommand()
                ->batchInsert('event', $columns, $row)
                ->execute();             
        }

        return $this->runAction("date", [$user]);
    }

    /**
     *
     */
    public function actionDate($user)
    {
        $eventAll = (new Query())
            ->select(['year','number_years_day'])
            ->from(['event'])
            ->distinct()
            ->all();

        $dateAll = (new Query())
            ->select(['year','number_years_day'])
            ->from(['date'])
            ->all();     

        $row = [];
        foreach ( $eventAll as $key => $value ) {
            // If $flat is true => $date exist on database
            $flat = false;
            foreach ( $dateAll as $k => $v) {
                if ( $key['number_years_day'] == $k['number_years_day'] ) {
                    if ( $key['year'] == $k['year'] ){
                        $flat = true;
                    }
                }
            }
            // mktime(hour, minute, second, month, day, year) 
            // => Approach below so it is necessary to increase one day           
            $vv = getdate(mktime(0, 0, 0, 1, 
                (int) $value['number_years_day']+1, (int) $value['year']));
            
            if ( $flat == false ){
                $row[] = [
                    $vv['mday'],
                    $vv['wday'],
                    $vv['mon'],
                    $vv['year'],
                    $vv['yday'],
                    $vv['weekday'],
                    $vv['month'],
                    time(),
                    $user,
                    time(),
                    $user,
                ];
            }
        }

        $columns = [
            'number_day',
            'number_weeks_day',
            'number_month',
            'year',
            'number_years_day',
            'weekday',
            'month',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ];
        
        if(isset($row)){
            Yii::$app
                ->db
                ->createCommand()
                ->batchInsert('date', $columns, $row)
                ->execute();             
        }

        return $this->runAction("worked", [$user]);
    }

    /**
     *  
     */
    public function actionWorked($user)
    {
      $person = (new Query())
        ->select([])
        ->from('person')
        ->all();
          
      $date = (new Query())
        ->select([])
        ->from(['date'])
        ->all();

      $sInput = 'Entrada Principal';
      $sOutput = '192.168.10.15';
      $row = [];
      foreach ( $person as $key => $value ) {
        foreach ( $date as $k => $v ) {
          $in_data = self::IOQuery($value['id'], $v['year'], $v['number_years_day'], $sInput);
          if( !empty($in_data) ) {
              $out_data = self::IOQuery($value['id'], $v['year'], $v['number_years_day'], $sOutput);
            if( !empty($out_data) ) {
              $i = 0;
              $out_arr = [];
              //Grouping in a array, arrays associative the outputs 
              //  by days using the key => o[int]
              foreach ( $out_data as $z ) {
                foreach ( $z as $x ) {
                  $a = 'o' . strval($i);
                  $out_arr[$a] = $x; 
                  $i++;
                }
              }
              $i = 0;
              $in_arr = [];
              //Grouping in a array, arrays associative the inputs 
              //  by days using the key => i[int]
              foreach ( $in_data as $z ) {
                foreach ($z as $x) {
                  $a = 'i' . strval($i);
                  $in_arr[$a] =  $x;
                  $i++; 
                }
              }
              // Merge and order the input and output vectors 
              // is essential to get the input-output pairs
              $tot = array_merge($in_arr,$out_arr);
              asort($tot);
              $out = 0;
              foreach ( $tot as $kk => $in ) {
                  // Dismisses exits without previous entries
                if ( self::in( $kk ) ) {
                  if ( $in > $out ) { 
                    $a = [];
                    foreach ( $out_arr as $kkk => $vvv ) {
                      if ( $vvv - $in < 0 ) {
                           //  Seconds of a day
                          $e = 86400;
                      } else {
                        $e = $vvv - $in;
                      }
                      array_push($a,$e);
                    }
                    $time = min($a);
                    $out = $in + $time;
                    // Discarded inputs without outputs
                    if ( $time<86400 ) {
                      //$a = [$value['id'],$k['id'],$in,$out];
                      $exist = (new Query())
                                ->select([])
                                ->from('worked')
                                ->where(['person_id' => $value['id'],
                                         'date_id' => $v['id'],
                                         'in' => $in,
                                         'out' => $out])
                                ->exists();
                      // Verify that there is no such record in the database   
                      if(!$exist) {
                        $row[] = [
                          $in,
                          $out,
                          time(),
                          $user,
                          time(),
                          $user,
                          $value['id'],
                          $v['id']
                        ];    
                      }
                    } 
                  }
                } else {
                  $out = $in; 
                }    
              }   
            }
          }
        }
    }

        $columns = [
            'in',
            'out',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
            'person_id',
            'date_id'
        ];
        
        if(isset($row)){
            Yii::$app
                ->db
                ->createCommand()
                ->batchInsert('worked', $columns, $row)
                ->execute();        
        }

       return $this->runAction("record", [$user]);
    }

    /**
     *
     */
    public function actionRecord($user)
    {

      $persons = (new Query())
              ->select([])
              ->from('person')
              ->all();

      $dates = (new Query())
              ->select([])
              ->from('date')
              ->all();

      $row = [];
      foreach ($persons as $key => $person) {
          foreach ($dates as $k => $date) {
              $exist = (new Query())
                      ->select([])
                      ->from('record')
                      ->where(['person_id' => $person['id'],
                          'date_id' => $date['id']])
                      ->exists();              

              if(!$exist) {
                  $counter_record = (new Query())
                          ->select([])
                          ->from('event')
                          ->where(['person_id' => $person['id'],
                              'year' =>  (int) $date['year'], 
                              'number_years_day' => $date['number_years_day']])
                          ->count();
                if($counter_record != 0) {                
                  $min_record = (new Query())
                          ->select([])
                          ->from('event') 
                          ->where(['person_id' => $person['id'],
                              'year' => $date['year'], 
                              'number_years_day' => $date['number_years_day']])
                          ->min('unix_time');

                  $max_record = (new Query())
                          ->select([])
                          ->from('event')
                          ->where(['person_id' => $person['id'],
                              'year' => $date['year'], 
                              'number_years_day' => $date['number_years_day']])
                          ->max('unix_time');

                  $average_record = (new Query())
                          ->select([])
                          ->from('event')
                          ->where(['person_id' => $person['id'],
                              'year' => $date['year'], 
                              'number_years_day' => $date['number_years_day']])
                          ->average('unix_time');

                  $time_record = $max_record - $min_record;

                  $counter_worked = (new Query())
                          ->select([])
                          ->from('worked')
                          ->where(['person_id' => $person['id'],
                              'date_id' => $date['id']])
                          ->count();
                  
                  $time_worked = 0;
                  if($counter_worked != 0) {                
                    $query = (new Query())
                            ->select(['in','out'])
                            ->from('worked')
                            ->where(['person_id' => $person['id'],
                                'date_id' => $date['id'],
                                ])
                            ->all();
                    foreach ($query as $key => $value) {
                      $time_worked = $time_worked + ($value['out'] - $value['in']);
                    } 
                  }

                  $row[] = [
                      $person['id'],
                      $date['id'],
                      $counter_record,
                      $counter_worked,
                      $min_record,
                      $max_record,
                      $average_record,
                      $time_worked,
                      $time_record,
                      time(),
                      $user,
                      time(),
                      $user,
                  ];
                }
              }
          }
        }

        $columns = [
            'person_id',
            'date_id',
            'counter_record',
            'counter_worked',
            'min_record',
            'max_record',
            'average_record',
            'time_worked',
            'time_record',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ];

        if(isset($row)){
            Yii::$app
                ->db
                ->createCommand()
                ->batchInsert('record', $columns, $row)
                ->execute();
        }
    }

    
    /**
     *  Devuelve $flat = 1 si se tiene una entrada y 0 sino
     */
    protected static function in($i)
    {
        $a = substr($i,0,1);
        if ( $a == 'i') {
            $flat = 1;
        } else {
            $flat = 0;
        }
        return $flat;
    }

    /**
     *
     */
    protected static function IOQuery($value, $vYear, $vNumber, $parm)
    {
        $a = (new Query())
            ->select('unix_time')
            ->from('event')
            ->where(['person_id' => $value,
                     'year' => $vYear, 
                     'number_years_day' => $vNumber,
                     'event' =>  $parm ])
            ->all();
        return $a;
    }  

}
