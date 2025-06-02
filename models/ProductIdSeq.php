<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_id_seq".
 *
 * @property integer $id
 */
class ProductIdSeq extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_id_seq';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
        ];
    }
}
