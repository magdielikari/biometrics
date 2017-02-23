<?php

namespace app\models\query;

/**
 * This is the ActiveQuery class for [[\app\models\Person]].
 *
 * @see \app\models\Person
 */
class PersonQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Person[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Person|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
