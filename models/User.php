<?php

namespace app\models;

use Yii;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
	public $email;
	public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];
	
	private static $user;

	/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {		
		$profile = Profiles::findOne([
			'profiles_id' => $id		
		]);

		if ( !empty($profile) )
		{
			self::$user = [
				'id' => $profile->profiles_id,
				'username' => $profile->username,
				'email' => $profile->email,
				'password' => $profile->password,
				'authKey' => "test{$profile->profiles_id}key",
				'accessToken' => "{$profile->profiles_id}-token",
			];

			return new static(self::$user);
		}
		
		return null;
		
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        foreach (self::$users as $user) {
//            if ($user['accessToken'] === $token) {
//                return new static($user);
//            }
//        }
		
        return null;
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        if ( !empty(self::$user) )
		{
			return new static(self::$user);
		}
		else
		{
			$profile = Profiles::findOne([
				'username' => strtolower($username)		
			]);

			if ( !empty($profile) )
			{
				self::$user = [
					'id' => $profile->profiles_id,
					'username' => $profile->username,
					'email' => $profile->email,
					'password' => $profile->password,
					'authKey' => "test{$profile->profiles_id}key",
					'accessToken' => "{$profile->profiles_id}-token",
				];
				
				return new static(self::$user);
			}
		}
	
        return null;
    }
	
	/**
     * Finds user by email
     *
     * @param  string      $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        if ( !empty(self::$user) )
		{
			return new static(self::$user);
		}
		else
		{
			$profile = Profiles::findOne([
				'email' => strtolower($email)		
			]);

			if ( !empty($profile) )
			{
				self::$user = [
					'id' => $profile->profiles_id,
					'username' => $profile->username,
					'email' => $profile->email,
					'password' => $profile->password,
					'authKey' => "test{$profile->profiles_id}key",
					'accessToken' => "{$profile->profiles_id}-token",
				];
				
				return new static(self::$user);
			}
		}
	
        return false;
    }	

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {		
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
}
