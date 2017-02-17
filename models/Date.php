<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "date".
 *
 * @property string $id
 * @property integer $seconds
 * @property integer $minutes
 * @property integer $hours
 * @property integer $mday
 * @property integer $wday
 * @property integer $mon
 * @property integer $year
 * @property integer $yday
 * @property string $weekday
 * @property string $month
 * @property string $0
 * @property string $event
 * @property string $persona_id
 *
 * @property Person $persona
 */
class Date extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'date';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['seconds', 'minutes', 'hours', 'mday', 'wday', 'mon', 'year', 'yday', 'weekday', 'month', '0', 'event', 'persona_id'], 'required'],
            [['seconds', 'minutes', 'hours', 'mday', 'wday', 'mon', 'year', 'yday', '0', 'persona_id'], 'integer'],
            [['weekday', 'month'], 'string', 'max' => 17],
            [['event'], 'string', 'max' => 71],
            [['persona_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['persona_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'seconds' => Yii::t('app', 'Seconds'),
            'minutes' => Yii::t('app', 'Minutes'),
            'hours' => Yii::t('app', 'Hours'),
            'mday' => Yii::t('app', 'Mday'),
            'wday' => Yii::t('app', 'Wday'),
            'mon' => Yii::t('app', 'Mon'),
            'year' => Yii::t('app', 'Year'),
            'yday' => Yii::t('app', 'Yday'),
            'weekday' => Yii::t('app', 'Weekday'),
            'month' => Yii::t('app', 'Month'),
            '0' => Yii::t('app', '0'),
            'event' => Yii::t('app', 'Event'),
            'persona_id' => Yii::t('app', 'Persona ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersona()
    {
        return $this->hasOne(Person::className(), ['id' => 'persona_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\DateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\DateQuery(get_called_class());
    }
}
