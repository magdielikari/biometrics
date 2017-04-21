<?php

namespace app\modules\upload\models;

use yii\behaviors\TimestampBehavior;

class Files extends \app\models\File
{
    /**
     *  Public doc   
     */    
    public $file;


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
}
