<?php
namespace Model;

use System\Core\Mysql;

class ChallengeAchievement extends Mysql
{
	public function __construct()
	{
		parent::__construct('challengeachievement');
	}
	
	public function getAchievement($challenge, $user)
	{
		$subUserAchievement = 'SELECT challenge FROM usersAchievementSuccess WHERE user = :user';
		
		return $this->one(
			'achievement.id, achievement.title',
			[
				'left' => [
					'achievement' => $this->table().'.achievement = achievement.id'
				],
				'where' => [
					$this->table().'.challenge = :challenge',
					'achievement.id NOT IN ('.$subUserAchievement.')'
				]
			],
			['user' => $user, 'challenge' => $challenge]
		);
	}
}
