<?php
namespace Model;

use System\Core\Mysql;

class Like extends Mysql
{
	public function __construct()
	{
		parent::__construct('challengeLike');
	}
	
	public function ofChallenge($id)
	{		
		if(empty($_SESSION['user']))
			return [];

		return $this->all(
			['users.id as user', 'users.name'], 
			[
				'left' => [
					'users' => 'users.id = challengeLike.user'
				],
				'where' => 'challenge = :id'
			], 
			['id' => $id]
		);		
	}	
}
