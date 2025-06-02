<?php
namespace app\models;

use Yii;
use app\models\User;
use yii\base\Model;

/**
 * Signup form
 */

/**
 * This is the model class for table "user".
 *
 * @property integer $userId
 * @property string $oldPassword
 * @property string $newPassword
 * @property string $verifyPassword
 */



class ChangePasswordForm extends Model
{
    public $userId;
    public $oldPassword;
    public $newPassword;
    public $verifyPassword;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['newPassword', 'verifyPassword'], 'required', 'message' => 'Kolom {attribute} tidak boleh kosong'],
            [['verifyPassword'], 'checkNewPassword'],
            ['newPassword', 'string', 'min' => 6],
        ];
    }

    
    public function attributeLabels()
    {
        return [
            'userId' => 'User ID',
            'oldPassword' => 'Password Lama',
            'newPassword' => 'Password Baru',
            'verifyPassword' => 'Ulangi Password Baru',
        ];
    }
    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    
    public function checkNewPassword($attribute, $params)
    {
        if($this->newPassword <> $this->verifyPassword)
        {
            $this->addError($attribute, 'Isi dari kolom Password Baru harus sama dengan kolom Verifikasi Password Baru');
        }
    }
    
    public function changePassword()
    {
        if ($this->validate()) {
            $user = User::findOne($this->userId);
            $user->setPassword($this->newPassword);
            if ($user->save()) {
                return $user;
            } 
        }
      return null;
    }
}