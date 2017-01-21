<?php
namespace Model;

use System\Core\Mysql;

class ServiceCategory extends Mysql
{
	public function __construct()
	{
		parent::__construct('serviceCategory');
	}
}
