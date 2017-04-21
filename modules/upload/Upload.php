<?php

namespace app\modules\upload;

use Yii;
//use yii\di\ServiceLocator;
/**
 * upload module definition class
 */
class Upload extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\upload\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->setComponents([
            'errorHandler' => [
    			'class' => 'yii\web\ErrorHandler',
            	'errorAction' => 'files/error'
    			]
            ]
        );

        // custom initialization code goes here
    }
}
