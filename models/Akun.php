<?php

namespace app\models;

/**
 * This is the model class for table "akun".
 *
 * @property integer $id
 * @property string $nama
 * @property integer $saldo
 */
class Akun extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'akun';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama', 'saldo'], 'required'],
            [['saldo'], 'integer'],
            [['nama'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama' => 'Nama',
            'saldo' => 'Saldo',
        ];
    }
}
