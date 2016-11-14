<?php 
class Category{
	public $id;

	function read($field){
		$sql = "SELECT $field FROM categorie WHERE id=".$this->id;
		$req = mysql_query($sql) or die(mysql_error());
		$data = mysql_fetch_assoc($req);
		return $data;
	}
}


 ?>