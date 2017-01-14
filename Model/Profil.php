<?php
namespace Model;

use System\Core\Mysql;

class Profil extends Mysql
{
	public function __construct()
	{
		parent::__construct('profils');
	}
	
	public function ofCurrentUser()
	{		
		if(empty($_SESSION['user']))
			return [];

		return $this->one(
			['profils.*'], 
			[
				'left' => [
					'users' => 'users.id = profils.user'
				],
				'where' => 'users.id = :id'
			], 
			['id' => $_SESSION['user']->id]
		);		
	}	
}
