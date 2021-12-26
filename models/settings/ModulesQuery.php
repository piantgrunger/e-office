<?php

namespace app\models\settings;

/**
 * This is the ActiveQuery class for [[Modules]].
 *
 * @see Modules
 */
class ModulesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Modules[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Modules|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
