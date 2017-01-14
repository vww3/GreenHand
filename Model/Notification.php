<?php
namespace Model;

use System\Core\Mysql;

class Notification extends Mysql
{
	public function __construct()
	{
		parent::__construct('notification');
	}
	
	public function ofCurrentUser()
	{		
		if(empty($_SESSION['user']))
			return [];

		return $this->all(
			'notification.*', 
			[
				'left' => [
					'users' => 'users.id = notification.user'
				],
				'where' => 'users.id = :id'
			], 
			['id' => $_SESSION['user']->id]
		);		
	}	
}
