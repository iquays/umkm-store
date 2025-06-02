<?php
namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class SearchForm extends Model
{
    public $category_id;
    public $text;
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['category_id', 'integer'],
            ['text', 'filter', 'filter' => 'trim'],
            ['text', 'string', 'min' => 2, 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Cari Produk',
        ];
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */

}
