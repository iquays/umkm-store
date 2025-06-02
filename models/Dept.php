<?php

namespace app\models;

use \app\models\base\Dept as BaseDept;

/**
 * This is the model class for table "dept".
 */
class Dept extends BaseDept
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id', 'nama'], 'required'],
            [['id', 'nama'], 'integer'],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
