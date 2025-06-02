<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $website
 * @property string $fullname
 * @property string $bio
 * @property string $address
 * @property integer $id_desa
 * @property string $lat
 * @property string $long
 * @property string $avatar
 * @property string $filename
 *
 * @property Product[] $products
 * @property Desa $idDesa 
 */
class User extends ActiveRecord implements IdentityInterface
{
    
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    
    public $image;
    
    public static function tableName()
    {
        return 'user';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    
    public function rules()
    {
        return [
            [['avatar', 'filename', 'image'], 'safe'],
            [['image'], 'file', 'maxFiles' => 3, 'extensions'=>'jpg, gif, png'],
            
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            
            [['username', 'auth_key', 'password_hash'], 'required'],
            ['email', 'email'],
            [['status', 'created_at', 'updated_at', 'id_desa'], 'integer'],
            [['bio'], 'string'],
            [['password_hash', 'password_reset_token', 'email', 'fullname', 'website', 'address', 'avatar', 'filename'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username', 'lat', 'long'], 'string', 'max' => 20],
	    [['lat', 'long'], 'default', 'value' => NULL],
        ];
    }

    public function getImageFile()
    {
        return isset($this->avatar) ? Yii::$app->params['avatarUploadPath'] . $this->avatar : null;
    }
    
    public function getImageFileThumbnail()
    {
        return isset($this->avatar) ? Yii::$app->params['avatarUploadPath'] . 'thumbnails/' . $this->avatar : null;
    }
    
    public function getImageUrl()
    {
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return Yii::$app->params['avatarUploadUrl'] . $avatar;   
    }
    
    public function getImageUrlThumbnail()
    {
        $avatar = isset($this->avatar) ? $this->avatar : 'default_user.jpg';
        return  Yii::$app->params['avatarUploadUrl'] . 'thumbnails/' . $avatar;   
    }
    
    public function uploadImage()
    {
        $image = UploadedFile::getInstance($this, 'image');
        
        if (empty($image)) {return false;}
        
        $this->filename = $image->name;
        //$ext = end((explode(".", $image->name)));
         
        // generate a unique file name
//        $this->avatar = Yii::$app->security->generateRandomString().".{$ext}";
        //$this->avatar = $this->id .".{$ext}";
        $this->avatar = $this->id . "_" . Yii::$app->security->generateRandomString(8) . "." . $image->extension;
 
        // the uploaded image instance
        return $image;
    }
    
    public function deleteImage()
    {
        $file = $this->getImageFile();
        
        if (empty($file) || !file_exists($file)) {return false;}
        
        if(!unlink($file)) {return false;}
        
        $this->avatar = null;
        $this->filename = null;
        
        return true;
    }    
    
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }    
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Nama User',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'fullname' => 'Nama UMKM',
            'website' => 'Website',
            'bio' => 'Deskripsi',
            'address' => 'Alamat',
            'id_desa' => 'Desa',
            'lat' => 'Lat',
            'long' => 'Long',
            'avatar' => 'Avatar',
            'filename' => 'Filename',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['user_id' => 'id']);
    }

    public function getIdDesa()
    {
        return $this->hasOne(Desa::className(), ['id' => 'id_desa']);
    }
    
    public function getSentMessages()
    {
        return $this->hasMany(Message::className(), ['from' => 'id']);
    }

    public function getReceivedMessages()
    {
        return $this->hasMany(Message::className(), ['to' => 'id']);
    }

    
    
}
