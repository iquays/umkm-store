<?php

namespace app\models;

use \app\models\base\Emp as BaseEmp;

/**
 * This is the model class for table "emp".
 */
class Emp extends BaseEmp
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['id', 'name'], 'required'],
            [['id', 'dept_id'], 'integer'],
            [['name'], 'string', 'max' => 12],
            [['lock'], 'default', 'value' => '0'],
            [['lock'], 'mootensai\components\OptimisticLockValidator']
        ]);
    }
	
}
