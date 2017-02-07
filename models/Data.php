<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property string $id
 * @property string $time
 * @property string $number
 * @property string $name
 * @property string $event
 * @property string $create_at
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time', 'number', 'name', 'event', 'create_at'], 'required'],
            [['number'], 'integer'],
            [['create_at'], 'safe'],
            [['time', 'event'], 'string', 'max' => 71],
            [['name'], 'string', 'max' => 127],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'time' => Yii::t('app', 'Time'),
            'number' => Yii::t('app', 'Number'),
            'name' => Yii::t('app', 'Name'),
            'event' => Yii::t('app', 'Event'),
            'create_at' => Yii::t('app', 'Create At'),
        ];
    }

    /**
     * @inheritdoc
     * @return \app\models\query\DataQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\DataQuery(get_called_class());
    }
}
