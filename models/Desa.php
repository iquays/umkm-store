<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "desa".
 *
 * @property integer $id
 * @property string $nama_desa
 * @property integer $id_kecamatan
 * @property integer $kodepos
 *
 * @property Kecamatan $idKecamatan
 * @property User[] $users
 */
class Desa extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'desa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama_desa', 'id_kecamatan'], 'required'],
            [['id_kecamatan', 'kodepos'], 'integer'],
            [['nama_desa'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nama_desa' => 'Nama Desa',
            'id_kecamatan' => 'Id Kecamatan',
            'kodepos' => 'Kodepos',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdKecamatan()
    {
        return $this->hasOne(Kecamatan::className(), ['id' => 'id_kecamatan']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id_desa' => 'id']);
    }
}
