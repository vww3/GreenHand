<?php
namespace Model;

use System\Core\Mysql;

class Objective extends Mysql
{
	public function __construct()
	{
		parent::__construct('challengeObjective');
	}
	
	public function toComplete($id)
	{
		if(empty($id) OR empty($_SESSION['user']))
			return null;
			
		$subTotalObjective = 'SELECT COUNT(*) 
			FROM challengeObjective 
			WHERE challengeObjective.challenge = usersChallengeParticipation.challenge
		';
		$subYouSuccess = 'SELECT COUNT(*) 
			FROM usersObjectiveSuccess, challengeObjective 
			WHERE usersObjectiveSuccess.objective = :id 
				AND challengeObjective.challenge = usersChallengeParticipation.challenge 
				AND usersObjectiveSuccess.user = :user
		';
				
		return $this->one(
			[
				$this->table().'.id',
				'usersChallengeParticipation.user',
				'usersChallengeParticipation.id AS participation',
				'usersChallengeParticipation.challenge AS challenge'
			],
			[
				'left' => [
					'usersChallengeParticipation' => 'usersChallengeParticipation.challenge = '.$this->table().'.challenge',
					'usersObjectiveSuccess' => [
						'usersObjectiveSuccess.objective = '.$this->table().'.id',
						'usersObjectiveSuccess.user = usersChallengeParticipation.user'
					]
				],
				'where' => [
					$this->table().'.id = :id',
					'usersChallengeParticipation.user = :user',
					'usersChallengeParticipation.dateSuccess IS NULL',
					'usersObjectiveSuccess.id IS NULL'
				]
			],
			['id' => $id, 'user' => $_SESSION['user']->id]
		);
	}
	
	public function ofChallenge($id)
	{
		$preparation = ['challenge' => $id];
		
		$selected = ['id', 'instruction'];
		
		if(!empty($_SESSION['user'])) {
			$subGetSuccess = 'SELECT TRUE FROM usersObjectiveSuccess WHERE user = :user AND objective = '.$this->table().'.id';
			$selected[] ='IFNULL(('.$subGetSuccess.'), FALSE) AS completed';
			$preparation['user'] = $_SESSION['user']->id;
		} else {
			$selected[] ='FALSE AS completed';
		}
		
		return $this->all($selected, 'challenge = :challenge', $preparation);		
	}	
}
