<?php
namespace app\models;

use Yii;
use app\models\File;
use yii\web\UploadedFile;


class Upload
{
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
	            //print("<pre>".print_r($dota,true)."</pre>");;
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
}
