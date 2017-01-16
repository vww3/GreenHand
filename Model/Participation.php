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
		$users = $this->all(
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
		
		foreach($users as $row => $user) {
			$users[$row]->linkUserprofil = BASE.'profil/'.$user->user.'/'.Str::simplify($user->name);
		}
		
		return $users;		
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
					$this->table().'.dateSuccess IS NULL',
					$this->table().'.giveup = 0'
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
	
	public function giveup($id)
	{
		$this->save(['id' => $id, 'giveup' => 1]);
	}
	
	public function succeed($id)
	{
		$this->query('UPDATE '.$this->table().' SET dateSuccess = CURRENT_TIMESTAMP WHERE id = :id', ['id' => $id]);
	}
}
