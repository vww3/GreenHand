<?php
namespace Model;

use System\Core\Mysql;
Use System\Str;

class ObjectiveSuccess extends Mysql
{
	public function __construct()
	{
		parent::__construct('usersObjectiveSuccess');
	}
	
	public function complete($id, $user)
	{
		return $this->save(['objective' => $id, 'user' => $user]);
	}
}
