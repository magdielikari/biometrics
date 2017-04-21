<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "record".
 *
 * @property string $person_id
 * @property string $date_id
 * @property integer $counter_record
 * @property integer $counter_worked
 * @property string $min_record
 * @property string $max_record
 * @property string $average_record
 * @property integer $time_worked
 * @property integer $time_record
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Date $date
 * @property Person $person
 */
class Record extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'record';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            BlameableBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_id', 'date_id'], 'required'],
            [['person_id', 'date_id', 'counter_record', 'counter_worked', 'min_record', 'max_record', 'average_record', 'time_worked', 'time_record', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['date_id'], 'exist', 'skipOnError' => true, 'targetClass' => Date::className(), 'targetAttribute' => ['date_id' => 'id']],
            [['person_id'], 'exist', 'skipOnError' => true, 'targetClass' => Person::className(), 'targetAttribute' => ['person_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'person_id' => Yii::t('app', 'Person ID'),
            'date_id' => Yii::t('app', 'Date ID'),
            'counter_record' => Yii::t('app', 'Counter Record'),
            'counter_worked' => Yii::t('app', 'Counter Worked'),
            'min_record' => Yii::t('app', 'Min Record'),
            'max_record' => Yii::t('app', 'Max Record'),
            'average_record' => Yii::t('app', 'Average Record'),
            'time_worked' => Yii::t('app', 'Time Worked'),
            'time_record' => Yii::t('app', 'Time Record'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDate()
    {
        return $this->hasOne(Date::className(), ['id' => 'date_id']);
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
     * @return \app\models\query\RecordQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\RecordQuery(get_called_class());
    }
}
