<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class RegistrationForm extends Model
{
	public $email;
    public $password;	
	public $confirm_password;
	
	public $rememberMe = true;
	
	private $isUser = true;
    private $_user = false;

    public function rules()
    {
        return [         
            [['email', 'password', 'confirm_password'], 'required'],            
            ['rememberMe', 'boolean'],
			['email', 'email', 'message' => 'Неправильно указан Email.'],
			['email', 'validateEmail'],
            ['password', 'validatePassword'],
        ];
    }
	
	public function validateEmail($attribute, $params)
	{
		if (!$this->hasErrors()) 
		{
			$isUser = $this->isUser();
			
			if ( $isUser )		
				$this->addError($attribute, 'Пользователь с данным email уже зарегистрирован в системе.');            
		}
	}

	public function validatePassword($attribute, $params)
    {
		if( $this->password != $this->confirm_password )
			$this->addError($attribute, 'Пароль потверждения не соотвествует.'); 
    }
	
	public function login()
	{
		if (!$this->validate())
		{
			$user = $this->getUser();
			return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
		}
	}
	
	public function isUser()
	{
		if (User::findByEmail($this->email) === false)
			$this->isUser = false;
		
		return	$this->isUser;	
	}
	
	public function getUser()
	{
		return $this->_user = User::findByEmail($this->email);
	}
}
