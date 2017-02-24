<?php
namespace app\models;

use Yii;
use yii\db\Query;
use app\models\File;
use app\models\Data;
use app\models\Date;
use app\models\Labor;
use app\models\Event;
use app\models\Person;
use app\models\Record;
use yii\web\UploadedFile;


class Upload
{
	/**
	 * Upload file to the system
	 */ 
	public static function file($model)
	{
	    $image = $model->name;
        $model->file = UploadedFile::getInstance($model,'file');
        $model->file->saveAs('excel/'.$image.'.'.$model->file->extension);
        $model->path = 'excel/'.$image.'.'.$model->file->extension;
        $model->create_at = date('Y-m-d h:m:s');
        $model->update_at = date('Y-m-d h:m:s');
        $model->save();
    	return $model->id;
	}

	/** 
	 * Upload data of file excel to table data in databases
	 */
	public static function data($id, $model)
	{
		try
		{
	        $inputFile = $model->path;
	        try
	        {
	            $dota = \moonland\phpexcel\Excel::import($inputFile,[
	                'setFirstRecordAsKeys' => false,
	                'setIndexSheetByName' => true, 
	                'getOnlySheet' => 'sheet1'
	            ]);
	        }
	        catch(Exception $e)
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
	            $data->time = $dota[$row]['A'];
	            $data->number = $dota[$row]['B'];
	            $data->name = $dota[$row]['C'];
	            $data->event = $dota[$row]['F'];
	            $data->create_at = date('Y-m-d h:m:s');
	            $data->file_id = $id;
	            $data->save();
	        }
	        $status = 1;
	    }
	    catch(Exception $e)
	    {
	    	$status = 0;
	    }
        return $status;
	}

	/**
	 * Upload data of table data to table person in databases
	 */
	public static function person($app)
	{
		try
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
        	$status = 1;
		}
		catch(Exception $e)
		{
			$status = 0;
		}
		return $status;
	}

	/** 
	 *  Upload data of table data and person to table event in databases
	 */
	public static function event($app)
	{
		try
		{
		    $query = (new Query())
	            ->select(['time','event','person.id','data.file_id'])
	            ->from('data')
	            ->where(['data.file_id' => $app])
	            ->innerJoin('person','data.number=person.ci')
	            ->all();
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

	        $eventAll = Event::find()->select(['unix_time'])->all();

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
        	$status = 1;
		}
		catch(Exception $e)
		{
			$status = 0;
		}
		return $status;
	} 

	/**
	 * Upload data of table person and event to table date in databases
	 */
	public static function date()
	{
		try
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
	        $status = 1;
		}
		catch(Exception $e)
		{
			$status = 0;
		}
		return $status;
	}

	/**
	 * Upload data of table event, date and person to table record in databases
	 */
	public static function record()
	{
		try
		{

		    $persons = Person::find()->all();
	        $dates = Date::find()->all();

	        foreach ($persons as $person) 
	        {
	            foreach ($dates as $date) 
	            {
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

	                    $record = new Record();
	                    $record->person_id = $person->id;
	                    $record->date_id = $date->id;
	                    $record->counter = $counter;
	                    $record->max = $max;
	                    $record->min = $min;
	                    $record->average = round($average);
	                    $record->save();
	                }
	            }
	        }
	        $status = 1;
		}
		catch(Exception $e)
		{
			$status = 0;
		}
		return $status;
	}

	/**
	 * Upload data of table event, date and person to table labor in databases
	 */
	public static function labor()
	{
		try
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
	                        $out = 0;
	                        foreach ($tot as $kk => $in) 
	                        {
	                            if ( self::in( $kk ) )
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
	                    }
	                }
	            }
	        }
	        $status = 1;
	 	}
	 	catch(Exception $e)
		{
			$status = 0;
		}
		return $status;
	}

//    print("<pre>".print_r($tot,true)."</pre>");

	/**
	 * Subfunction helper of labor function  
	 */
	public static function in($i)
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

}
