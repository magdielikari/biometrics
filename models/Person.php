<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "person".
 *
 * @property string $id
 * @property string $name
 * @property string $ci
 *
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
            [['name', 'ci'], 'required'],
            [['ci'], 'integer'],
            [['name'], 'string', 'max' => 97],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDates()
    {
        return $this->hasMany(Date::className(), ['persona_id' => 'id']);
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
