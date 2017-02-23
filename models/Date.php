<?php

namespace app\models;

use Yii;

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
 *
 * @property Labor[] $labors
 * @property Record[] $records
 * @property Person[] $people
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
            [['number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day', 'weekday', 'month'], 'required'],
            [['number_day', 'number_weeks_day', 'number_month', 'year', 'number_years_day'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabors()
    {
        return $this->hasMany(Labor::className(), ['date_id' => 'id']);
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
     * @inheritdoc
     * @return \app\models\query\DateQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\DateQuery(get_called_class());
    }
}
