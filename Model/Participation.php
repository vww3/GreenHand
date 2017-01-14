<?php
namespace Model;

use System\Core\Mysql;

class Participation extends Mysql
{
	public function __construct()
	{
		parent::__construct('usersChallengeParticipation');
	}
	
	public function ofChallenge($id)
	{		
		return $this->all(
			[
				'users.id as user',
				'users.name',
				$this->table().'.dateParticipation',
				$this->table().'.dateSuccess'
			], 
			[
				'left' => [
					'users' => 'users.id = '.$this->table().'.user'
				],
				'where' => 'challenge = :id'
			],
			['id' => $id]
		);		
	}	
}
