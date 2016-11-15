<?php 
class Categorie extends Model{
	var $table = "categorie";

	public function __construct(){
		parent::__construct('g_mvc_test', 'root', '', 'localhost');
	}

	

	public function getLast($num = 5){
		return $this->find(array(
			'limit' => $num,
			'order' => 'id DESC'
			));
	}
}


