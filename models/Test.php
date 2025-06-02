<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test".
 *
 * @property integer $id
 * @property integer $angka
 * @property string $tanggal
 * @property integer $karakter
 */
class Test extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['angka', 'tanggal', 'karakter'], 'required'],
            [['angka', 'karakter'], 'integer'],
            [['tanggal'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'angka' => 'Angka',
            'tanggal' => 'Tanggal',
            'karakter' => 'Karakter',
        ];
    }
}
