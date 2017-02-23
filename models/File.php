<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $path
 * @property string $name
 * @property string $create_at
 * @property string $update_at
 *
 * @property Data[] $datas
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
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'name', 'create_at', 'update_at'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['file'],'file'],
            [['path'], 'string', 'max' => 127],
            [['name'], 'string', 'max' => 113],
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
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
            'file' => Yii::t('app', 'Excel')
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
     * @inheritdoc
     * @return \app\models\query\FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\FileQuery(get_called_class());
    }
}
