<?php
namespace Model;

use System\Core\Mysql;
use System\Str;
use DateTime;

class Challenge extends Mysql
{
	public function __construct()
	{
		parent::__construct('challenge');
	}
	
	public function doesExist($id) {
		
		return $this->exist('id = :id', ['id' => $id]);
		
	}
	
	public function getAll()
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
			'order' => 'challenge.dateCreation DESC'
		];		
		
		return $this->all($selected, $left, $preparation);
	}
	
	public function getById($id)
	{		
		$subTotalObjective = 'SELECT COUNT(*) 
			FROM challengeObjective 
			WHERE challengeObjective.challenge = challenge.id
		';
		
		$subNumLikes = 'SELECT COUNT(*) 
			FROM challengeLike 
			WHERE challengeLike.challenge = challenge.id
		';
		
		$selected = [
			'challenge.id',
			'challenge.title',
			'challenge.description',
			'challenge.dateCreation',
			'challenge.dateEnd',
			'challenge.achievement',
			'users.id as authorId',
			'users.name as author',
			'challengeCategory.title as category',
			'IF(challenge.dateEnd IS NULL OR challenge.dateEnd < NOW(), 1, 0) as avaiable'
		];
		
		$preparation = ['challenge' => $id];
		
		$options = [
			'left' => [
				'users'				=> 'users.id = challenge.author',
				'challengeCategory' => 'challengeCategory.id = challenge.category'
			],
			'where' => 'challenge.id = :challenge'
		];
		
		if(!empty($_SESSION['user'])) {
			$subYouSuccess = 'SELECT COUNT(*) 
				FROM usersObjectiveSuccess, challengeObjective 
				WHERE usersObjectiveSuccess.objective = challengeObjective.id 
					AND challengeObjective.challenge = challenge.id 
					AND usersObjectiveSuccess.user = :id
				';
			$selected[] = 'CONCAT(CAST( ('.$subYouSuccess.') / ('.$subTotalObjective.') * 100 as UNSIGNED INTEGER ),\'%\') as objectives';
			$preparation['id'] = $_SESSION['user']->id;
		} else {
			$selected[] = '('.$subTotalObjective.') as objectives';
		}
		
		$challenge = $this->one($selected, $options, $preparation);
		
		if(!empty($challenge)) {
			$challenge->slug = Str::simplify($challenge->title);
			$challenge->dateCreation = Str::date($challenge->dateCreation);
			$challenge->dateEnd = Str::date($challenge->dateEnd);
			$challenge->linkAuthorProfil = BASE.'profil/'.$challenge->authorId.'/'.Str::simplify($challenge->author);			
		}
		
		return $challenge;
	}
}
