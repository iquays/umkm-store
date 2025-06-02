<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $id
 * @property string $product_code
 * @property string $product_name
 * @property string $price
 * @property integer $category_id
 * @property string $short_description
 * @property string $description
 * @property integer $user_id
 * @property integer $stock\
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ProductCategory $category
 * @property User $user
 * @property ProductPicture[] $productPictures
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $image;

    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image'], 'file', 'maxFiles' => 6, 'extensions' => 'jpg, gif, png'],
            [['product_name', 'category_id', 'user_id', 'price'], 'required'],
            [['price'], 'number'],
            [['id', 'user_id'], 'integer'],
            [['product_code'], 'string', 'max' => 10],
            [['product_name'], 'string', 'max' => 50],
            [['short_description'], 'string', 'max' => 250],
            [['description'], 'string', 'max' => 5000],
            ['stock', 'integer', 'message' => 'Isikan hanya angka saja'],
            ['category_id', 'integer', 'message' => 'Kategori harus diisi']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'image' => 'Foto Produk',
            'id' => 'ID',
            'product_code' => 'Kode Produk',
            'product_name' => 'Nama Produk',
            'price' => 'Harga (dalam rupiah)',
            'stock' => 'Jumlah Persediaan',
            'category_id' => 'Kategori',
            'short_description' => 'Deskripsi Singkat',
            'description' => 'Deskripsi Lengkap',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ProductCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductPictures()
    {
        return $this->hasMany(ProductPicture::className(), ['product_id' => 'id']);
    }


}
