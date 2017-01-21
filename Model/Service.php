<?php
namespace Model;

use System\Core\Mysql;

class Service extends Mysql
{
	public function __construct()
	{
		parent::__construct('service');
	}
	
	public function getAll()
	{		
		$services = $this->all(
			[
				$this->table().'.*',
				'serviceCategory.id as categoryId',
				'serviceCategory.idAttr',
				'serviceCategory.title as category'
			],
			[
				'left' => [
					'serviceCategory' => 'serviceCategory.id = '.$this->table().'.category'
				]
			]
		);
		
		$result = [];
		
		foreach($services as $service) {
			$result[$service->categoryId]['title'] = $service->category;
			$result[$service->categoryId]['id'] = $service->idAttr;
			$result[$service->categoryId]['services'][] = $service;
		}
		
		return $result;
	}
}
