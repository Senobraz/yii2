<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property integer $profiles_id
 * @property string $second_name
 * @property string $first_name
 * @property string $email
 * @property string $password
 * @property string $salt
 */
class Profiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['second_name','first_name','email','password'], 'required', 'message' => 'Это поле обязательно для заполнения.'],
			['email', 'email', 'message' => 'Неправильно указан Email.'],
            [['second_name', 'first_name', 'email', 'password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profiles_id' => 'ID',
            'second_name' => 'Фамилия',
            'first_name' => 'Имя',
            'email' => 'Email',
            'password' => 'Пароль',          
        ];
    }

    /**
     * @inheritdoc
     * @return ProfilesQuery the active query used by this AR class.
     */
    /*public static function find()
    {
        return new ProfilesQuery(get_called_class());
    }*/	
}
