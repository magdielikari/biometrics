<?php
namespace app\components\helpers;

use yii\db\Query;
use yii\helpers\BaseVarDumper;

class MyQuery extends BaseVarDumper
{

    /**
     *
     */
    public static function count($table,$where = null,$in = null)
    {
        if (isset($where) && isset($in)){   
            $number = (new Query())
                ->select([])
                ->from($table)
                ->where([$where => $in])
                ->count();
            return $number;
        } else {
            $number = (new Query())
                ->select([])
                ->from($table)
                ->count();
            return $number;
        }
    }
}   