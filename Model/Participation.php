<?php
namespace Model;

use System\Core\Mysql;
Use System\Str;

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
				$this->table().'.id',
				$this->table().'.dateParticipation',
				$this->table().'.dateSuccess',
				'users.id as user',
				'users.name'
			], 
			[
				'left' => [
					'users' => 'users.id = '.$this->table().'.user'
				],
				'where' => $this->table().'.challenge = :id'
			],
			['id' => $id]
		);		
	}
	
	public function mineOfChallenge($id)
	{	
		if(empty($_SESSION['user']))
			return null;
		
		$participation = $this->one(
			'*', 
			'challenge = :id AND user = :user',
			['id' => $id, 'user' => $_SESSION['user']->id]
		);
		
		if(!empty($participation))
			$participation->dateSuccess = Str::date($participation->dateSuccess);
		
		return $participation;
	}
	
	public function myChallenges()
	{
		$challenges = $this->all(
			[
				'challenge.id',
				'challenge.title'
			], 
			[
				'left' => [
					'challenge' => 'challenge.id = '.$this->table().'.challenge'
				],
				'where' => [
					$this->table().'.user = :user',
					$this->table().'.dateSuccess IS NULL'
				]
			],
			['user' => $_SESSION['user']->id]
		);
		
		if(!empty($challenges))
			foreach($challenges as $row => $challenge) {
			    $challenges[$row]->slug = Str::simplify($challenges[$row]->title);
		    }
	    
	    return $challenges;
	}	
}
