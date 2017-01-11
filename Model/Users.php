<?php
namespace Model;

use System\Core\Mysql;

/**
 * joueur class.
 */
class Users extends Mysql
{
	public function __construct()
	{
		parent::__construct('users');
	}
	
	public function connexion($email, $password)
	{
		$user = $this->one(
			['id', 'email', 'isAdmin', 'name', 'valid'],
			['where' => [
				'email = :email',
				'password = :password'
				]
			],
			['email' => $email, 'password' => $password]
		);
		
		if(empty($user))
			return null;
		
		$this->query('UPDATE users SET numConnection=numConnection+1 WHERE id=:id', ['id' => $user->id]);
		
		return $user;
	}
	
	public function whoHasKey($key)
	{
		return $this->one('id, valid, name', 'validationKey = :key', ['key' => $key]);
	}
	
	public function validate($userId)
	{
		return $this->save(['id' => $userId, 'valid' => 1]);
	}
	
	public function isAvailableEmail($email)
	{
		return !$this->exist('email=:email', ['email' => $email]);
	}	
}
