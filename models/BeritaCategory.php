<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "berita_category".
 *
 * @property integer $category_id
 * @property string $title
 * @property string $image
 * @property integer $order_num
 * @property string $slug
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property integer $status
 *
 * @property Berita[] $beritas
 */
class BeritaCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'berita_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['order_num', 'tree', 'lft', 'rgt', 'depth', 'status'], 'integer'],
            [['title', 'image', 'slug'], 'string', 'max' => 128],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'title' => 'Title',
            'image' => 'Image',
            'order_num' => 'Order Num',
            'slug' => 'Slug',
            'tree' => 'Tree',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'depth' => 'Depth',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBeritas()
    {
        return $this->hasMany(Berita::className(), ['category_id' => 'category_id']);
    }
}
