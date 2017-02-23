<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "record".
 *
 * @property string $person_id
 * @property string $date_id
 * @property integer $counter
 * @property string $min
 * @property string $max
 * @property string $average
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
    public function rules()
    {
        return [
            [['person_id', 'date_id', 'counter', 'min', 'max', 'average'], 'required'],
            [['person_id', 'date_id', 'counter', 'min', 'max', 'average'], 'integer'],
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
            'counter' => Yii::t('app', 'Counter'),
            'min' => Yii::t('app', 'Min'),
            'max' => Yii::t('app', 'Max'),
            'average' => Yii::t('app', 'Average'),
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
