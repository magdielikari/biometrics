<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "event".
 *
 * @property string $id
 * @property integer $year
 * @property integer $number_years_day
 * @property string $unix_time
 * @property string $event
 * @property string $persona_id
 *
 * @property Person $person
 */
class Event extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'number_years_day', 'unix_time', 'event', 'person_id'], 'required'],
            [['year', 'number_years_day', 'unix_time', 'person_id'], 'integer'],
            [['event'], 'string', 'max' => 71],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'year' => Yii::t('app', 'Year'),
            'number_years_day' => Yii::t('app', 'Number Years Day'),
            'unix_time' => Yii::t('app', 'Unix Time'),
            'event' => Yii::t('app', 'Event'),
            'person_id' => Yii::t('app', 'Persona ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson()
    {
        return $this->hasOne(Person::className(), ['id' => 'person_id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EventQuery(get_called_class());
    }
}
