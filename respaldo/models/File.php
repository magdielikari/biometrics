<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $name
 * @property string $create_at
 * @property string $update_at
 */
class File extends \yii\db\ActiveRecord
{
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
            [['create_at', 'update_at'], 'safe'],
            [['file'],'file'],
            [['path'], 'string', 'max' => 127],
            [['name'], 'string', 'max' => 113]
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
            'create_at' => Yii::t('app', 'Create At'),
            'update_at' => Yii::t('app', 'Update At'),
            'path' => Yii::t('app', 'Path'), 
            'file' => Yii::t('app', 'Excel'),
        ];
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