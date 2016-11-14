<?php 
class Categorie extends Model{
	public $id;

	public function __construct(){
		parent::__construct('g_mvc_test', 'root', '', 'localhost');
	}

	var $table = "categorie";
}


