<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_category".
 *
 * @property integer $id
 * @property string $category_name
 * @property integer $parent_category_id
 * @property string $category_code
 *
 * @property Product[] $products
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_name'], 'required'],
            [['parent_category_id'], 'integer'],
            [['category_name'], 'string', 'max' => 50],
            [['category_code'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'parent_category_id' => 'Parent Category ID',
            'category_code' => 'Category Code'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }
}
