<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product_picture".
 *
 * @property integer $id
 * @property string $picture
 * @property integer $product_id
 *
 * @property Product $product
 */
class ProductPicture extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public $image;

    public static function tableName()
    {
        return 'product_picture';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename', 'picture', 'image'], 'safe'],
            [['image'], 'file', 'maxFiles' => 3, 'extensions' => 'jpg, gif, png'],
            [['picture'], 'required'],
            [['id', 'product_id'], 'integer'],
            [['filename', 'picture'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'picture' => 'Picture',
            'product_id' => 'Product ID',
        ];
    }

    public function getImageFile()
    {
        return isset($this->picture) ? Yii::$app->params['productUploadPath'] . $this->product_id . DIRECTORY_SEPARATOR . $this->picture : null;
    }

    public function getImageFileThumbnail()
    {
        return isset($this->picture) ? Yii::$app->params['productUploadPath'] . $this->product_id . DIRECTORY_SEPARATOR . 'thumbnail' . DIRECTORY_SEPARATOR . $this->picture : null;
    }

    public function getImageUrl()
    {
        if (isset($this->picture)) {
            return Yii::$app->params['productUploadUrl'] . $this->product_id . '/' . $this->picture;
        } else {
            return Yii::$app->params['productUploadUrl'] . 'empty_picture.jpg';
        }
    }

    public function getImageUrlThumbnail()
    {
        if (isset($this->picture)) {
            return Yii::$app->params['productUploadUrl'] . $this->product_id . '/thumbnail/' . $this->picture;
        } else {
            return Yii::$app->params['productUploadUrl'] . 'empty_picture_thumb.jpg';
        }
    }

    public function uploadImage()
    {
        $image = UploadedFile::getInstance($this, 'image');

        if (empty($image)) {
            return false;
        }

        $this->filename = $image->name;
        // generate a unique file name
        $this->picture = $this->id . "_" . Yii::$app->security->generateRandomString(8) . "." . $image->extension;
        // the uploaded image instance
        return $image;
    }

    public function deleteImage()
    {
        $file = $this->getImageFile();
        if (empty($file) || !file_exists($file)) {
            return false;
        }
        if (!unlink($file)) {
            return false;
        }

        $fileThumbnail = $this->getImageFileThumbnail();
        if (empty($fileThumbnail) || !file_exists($fileThumbnail)) {
            return false;
        }
        if (!unlink($fileThumbnail)) {
            return false;
        }

        return true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }


}
