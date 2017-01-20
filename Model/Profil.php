<?php
namespace Model;

use System\Core\Mysql;

class Profil extends Mysql
{
	public function __construct()
	{
		parent::__construct('profils');
	}
	
	public function ofUser($id)
	{		
		$profil = $this->one(
			['profils.*'], 
			[
				'left' => [
					'users' => 'users.id = profils.user'
				],
				'where' => 'users.id = :id'
			], 
			['id' => $id]
		);
		
		if(!empty($profil)) {
			$photo = IMAGE.'profil/'.$profil->id.'.jpg';
			$default = IMAGE.'profil/user.jpg';
			
			$profil->photo = is_file(ROOT.$photo) ? $photo : $default;
		}
		
		return $profil;	
	}	
}
