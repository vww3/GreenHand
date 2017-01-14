<?php
namespace Model;

use System\Core\Mysql;

class Objective extends Mysql
{
	public function __construct()
	{
		parent::__construct('challengeObjective');
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
