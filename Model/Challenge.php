<?php
namespace Model;

use System\Core\Mysql;

class Challenge extends Mysql
{
	public function __construct()
	{
		parent::__construct('challenge');
	}
	
	public function list()
	{
		$subNumParticipant = 'SELECT COUNT(*) 
			FROM usersChallengeParticipation 
			WHERE usersChallengeParticipation.challenge = challenge.id
		';
		$subNumLikes = 'SELECT COUNT(*) 
			FROM challengeLike 
			WHERE challengeLike.challenge = challenge.id
		';
		$subTotalObjective = 'SELECT COUNT(*) 
			FROM challengeObjective 
			WHERE challengeObjective.challenge = challenge.id
		';
		
		$selected = [
			'challenge.id',
			'challenge.title',
			'challenge.description',
			'challenge.dateCreation',
			'challenge.dateEnd',
			'challengeCategory.title as category',
			'('.$subNumParticipant.') as numParticipant',
			'('.$subNumLikes.') as numLikes'
		];
		
		if(!empty($_SESSION['user'])) {
			$subYouSuccess = 'SELECT COUNT(*) 
				FROM usersObjectiveSuccess, challengeObjective 
				WHERE usersObjectiveSuccess.objective = challengeObjective.id 
					AND challengeObjective.challenge = challenge.id 
					AND usersObjectiveSuccess.user = :id
				';
			$selected[] = 'CONCAT(CAST( ('.$subYouSuccess.') / ('.$subTotalObjective.') * 100 as UNSIGNED INTEGER ),\'%\') as objectives';
			$preparation = ['id' => $_SESSION['user']->id];
		} else {
			$selected[] = '('.$subTotalObjective.') as objectives';
			$preparation = [];
		}
		
		$left = [
			'left' => [
				'challengeCategory' => 'challengeCategory.id = challenge.category'
			],
		];		
		
		return $this->all($selected, $left, $preparation);
	}
	
	public function getById($id)
	{		
		$subNumLikes = 'SELECT COUNT(*) 
			FROM challengeLike 
			WHERE challengeLike.challenge = challenge.id
		';
		
		return $this->one(
			[
				'challenge.title',
				'challenge.description',
				'challenge.dateCreation',
				'challenge.dateEnd',
				'challenge.achievement',
				'users.name as author',
				'challengeCategory.title as category'
			],
			[
				'left' => [
					'users'				=> 'users.id = challenge.author',
					'challengeCategory' => 'challengeCategory.id = challenge.category'
				],
				'where' => 'challenge.id = :challenge'
			],
			['challenge' => $id]
		);
	}
}