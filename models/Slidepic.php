<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "slidepic".
 *
 * @property integer $id
 * @property string $filename
 * @property string $short_description
 * @property string $picture
 */
class Slidepic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    
    public $image;
    
    public static function tableName()
    {
        return 'slidepic';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['image', 'filename', 'picture'], 'safe'],
            [['image'], 'file', 'maxFiles' => 1, 'extensions'=>'jpg, gif, png'],
            [['filename', 'title'], 'string', 'max' => 50],
            [['short_description', 'picture'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Judul',
            'filename' => 'Filename',
            'short_description' => 'Deskripsi',
            'picture' => 'Picture',
        ];
    }
    
    public function getImageFile()
    {
        return Yii::$app->params['slidepicUploadPath'] . $this->picture;
    }
    
    public function getImageFileThumbnail()
    {
        $picture = isset($this->picture) ? $this->picture : 'no_image.jpg';
        return Yii::$app->params['slidepicUploadPath'] . 'thumbnails/' . $picture;
    }
    
    public function getImageFileCropped()
    {
        return Yii::$app->params['slidepicUploadPath'] . 'cropped/' . $this->picture;
    }
    
    public function getImageUrl()
    {
        return Yii::$app->params['slidepicUploadUrl'] . $this->picture;   
    }
    
    public function getImageUrlThumbnail()
    {
        return  Yii::$app->params['slidepicUploadUrl'] . 'thumbnails/' . $this->picture;
    }
    
    public function getImageUrlCropped()
    {
        return  Yii::$app->params['slidepicUploadUrl'] . 'cropped/' . $this->picture;
    }
    
    public function uploadImage()
    {
        $image = UploadedFile::getInstance($this, 'image');
        
        if (empty($image)) {return false;}
        
        $this->filename = $image->name;
        // generate a unique file name
        $this->picture = $this->id . "_" . Yii::$app->security->generateRandomString(8) . "." . $image->extension;
        // the uploaded image instance
        return $image;
    }
    
    public function deleteImage()
    {
        $file = $this->getImageFile();    
        if (empty($file) || !file_exists($file)) {return false;}
        if(!unlink($file)) {return false;}
        $file2 = $this->getImageFileCropped();    
        if (empty($file2) || !file_exists($file2)) {return false;}
        if(!unlink($file2)) {return false;}
        $file3 = $this->getImageFileThumbnail();    
        if (empty($file3) || !file_exists($file3)) {return false;}
        if(!unlink($file3)) {return false;}
               
        $this->picture = null;
        $this->filename = null;
        
        return true;
    }
    
}
