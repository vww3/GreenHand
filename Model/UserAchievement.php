<?php
namespace Model;

use System\Core\Mysql;

class UserAchievement extends Mysql
{
	public function __construct()
	{
		parent::__construct('usersAchievementSuccess');
	}
}
