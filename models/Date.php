<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "date".
 *
 * @property string $id
 * @property integer $number_day
 * @property integer $number_weeks_day
 * @property integer $number_month
 * @property integer $year
 * @property integer $number_years_day
 * @property string $weekday
 * @property string $month
 * @property string $created_at
 * @property integer $created_by
 * @property string $updated_at
 * @property integer $updated_by
 *
 * @property Record[] $records
 * @property Person[] $people
 * @property Worked[] $workeds
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
     *  Public doc   
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
            [['number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'weekday', 'month'], 'required'],
            [['number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['weekday', 'month'], 'string', 'max' => 17],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number_day' => Yii::t('app', 'Number Day'),
            'number_weeks_day' => Yii::t('app', 'Number Weeks Day'),
            'number_month' => Yii::t('app', 'Number Month'),
            'year' => Yii::t('app', 'Year'),
            'number_years_day' => Yii::t('app', 'Number Years Day'),
            'weekday' => Yii::t('app', 'Weekday'),
            'month' => Yii::t('app', 'Month'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['id' => 'person_id'])->viaTable('record', ['date_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWorkeds()
    {
        return $this->hasMany(Worked::className(), ['date_id' => 'id']);
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
