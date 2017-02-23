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
 * @property integer $number_day
 * @property integer $number_weeks_day
 * @property integer $number_month
 * @property integer $year
 * @property integer $number_years_day
 * @property string $weekday
 * @property string $month
 * @property string $unix_time
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
            [['seconds', 'minutes', 'hours', 'number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'weekday', 'month', 'unix_time', 'event', 'persona_id'], 'required'],
            [['seconds', 'minutes', 'hours', 'number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'unix_time', 'persona_id'], 'integer'],
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
            'number_day' => Yii::t('app', 'Number Day'),
            'number_weeks_day' => Yii::t('app', 'Number Weeks Day'),
            'number_month' => Yii::t('app', 'Number Month'),
            'year' => Yii::t('app', 'Year'),
            'number_years_day' => Yii::t('app', 'Number Years Day'),
            'weekday' => Yii::t('app', 'Weekday'),
            'month' => Yii::t('app', 'Month'),
            'unix_time' => Yii::t('app', 'Unix Time'),
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
