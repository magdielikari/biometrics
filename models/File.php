<?php

namespace app\models;

use Yii;
//use yii\validators\FileValidator;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $path
 * @property string $name
 * @property string $size
 * @property integer $error
 * @property string $created_at
 * @property string $created_by
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Data[] $datas
 * @property Person[] $people
 */
class File extends \yii\db\ActiveRecord
{
    /**
     *  Public doc   
     */    
    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
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
            [['size', 'error', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['path'], 'string', 'max' => 37],
            [['name'], 'string', 'max' => 257],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'path' => Yii::t('app', 'Path'),
            'name' => Yii::t('app', 'Name'),
            'size' => Yii::t('app', 'Size'),
            'error' => Yii::t('app', 'Error'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatas()
    {
        return $this->hasMany(Data::className(), ['file_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeople()
    {
        return $this->hasMany(Person::className(), ['file_id' => 'id']);
    }
/*
    public function getDataFile($id)
    {
        return $this->hasMany(Data::className(), ['file_id' => 'id'])->file();
    }
*/
    /**
     * @inheritdoc
     * @return \app\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FileQuery(get_called_class());
    }
}
