<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property string $id
 * @property string $name
 * @property string $ci
 * @property string $file_id
 *
 * @property Event[] $events
 * @property Labor[] $labors
 * @property File $file
 * @property Record[] $records
 * @property Date[] $dates
 */
class Person extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'ci', 'file_id'], 'required'],
            [['ci', 'file_id'], 'integer'],
            [['name'], 'string', 'max' => 97],
            [['file_id'], 'exist', 'skipOnError' => true, 'targetClass' => File::className(), 'targetAttribute' => ['file_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'ci' => Yii::t('app', 'Ci'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvents()
    {
        return $this->hasMany(Event::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLabors()
    {
        return $this->hasMany(Labor::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'file_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(Record::className(), ['person_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasMany(Date::className(), ['id' => 'date_id'])->viaTable('record', ['person_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return \app\models\query\PersonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\PersonQuery(get_called_class());
    }
}
