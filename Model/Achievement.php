<?php
namespace Model;

use System\Core\Mysql;

class Achievement extends Mysql
{
	public function __construct()
	{
		parent::__construct('achievement');
	}
	
	public function ofChallenge($id)
	{
		$subMyBadges = 'SELECT id FROM usersAchievementSuccess WHERE user = :user';
		
		return $this->one(
			[
				$this->table().'.*',
				'IF('.$this->table().'.id IN ('.$subMyBadges.'), 1, 0) as isWon'
			],
			[
				'left' => [
					'challengeachievement' => 'challengeachievement.achievement = '.$this->table().'.id'
				],
				'where' => [
					'challengeachievement.challenge = :challenge'
				]
			],
			['challenge' => $id, 'user' => $_SESSION['user']->id]
		);
	}
}
