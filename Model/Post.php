<?php
namespace Model;

use System\Core\Mysql;
Use System\Str;

class Post extends Mysql
{
	public function __construct()
	{
		parent::__construct('challengePost');
	}
	
	public function ofChallenge($id)
	{
		$posts = $this->all(
			[
				$this->table().'.*',
				'users.name as author',
			],
			[
				'left' => [
					'users' => 'user = users.id'
				],
				'where' => [
					'challenge = :challenge'
				],
				'order' => 'date DESC'
			],
			['challenge' => $id]
		);
		
		foreach($posts as $row => $post) {
			$posts[$row]->linkUserProfil = BASE.'profil/'.$post->user.'/'.Str::simplify($post->author);
			$posts[$row]->linkReportPost = BASE.'report/post/'.$post->id;
			$posts[$row]->date = Str::date($posts[$row]->date, 'le %d %B %Y à %I:%M:%S %p');
		}
		
		return $posts;
	}
}
