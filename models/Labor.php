<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "labor".
 *
 * @property string $id
 * @property string $in
 * @property string $out
 * @property string $person_id
 * @property string $date_id
 *
 * @property Date $date
 * @property Person $person
 */
class Labor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'labor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['in', 'out', 'person_id', 'date_id'], 'required'],
            [['in', 'out', 'person_id', 'date_id'], 'integer'],
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
            'id' => Yii::t('app', 'ID'),
            'in' => Yii::t('app', 'In'),
            'out' => Yii::t('app', 'Out'),
            'person_id' => Yii::t('app', 'Person ID'),
            'date_id' => Yii::t('app', 'Date ID'),
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
     * @return \app\models\query\LaborQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\LaborQuery(get_called_class());
    }
}
