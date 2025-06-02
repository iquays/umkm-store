<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "message".
 *
 * @property integer $id
 * @property integer $from
 * @property string $fromName
 * @property string $fromEmail
 * @property integer $to
 * @property string $text
 *
 * @property User $sender
 * @property User $recipient
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from', 'fromName', 'fromEmail', 'to', 'text'], 'required'],
            ['fromEmail', 'email'],
            [['from', 'to'], 'integer'],
            [['text'], 'string'],
            [['fromName', 'fromEmail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from' => 'From',
            'fromName' => 'From Name',
            'fromEmail' => 'From Email',
            'to' => 'To',
            'text' => 'Text',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSender()
    {
        return $this->hasOne(User::className(), ['id' => 'from']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(User::className(), ['id' => 'to']);
    }
}
