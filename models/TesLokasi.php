<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tes_lokasi".
 *
 * @property integer $id
 * @property string $nama
 * @property string $lat
 * @property string $long
 */
class TesLokasi extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tes_lokasi';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nama'], 'required'],
            [['nama'], 'string', 'max' => 50],
            [['lat', 'long'], 'string', 'max' => 20]
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
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }
}
