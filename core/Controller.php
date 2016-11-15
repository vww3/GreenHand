<?php

class Controller{
	var $vars = array();
	var $layout = 'default';

	function __construct(){
		if(isset($_POST)){
			$this->data = $_POST;
		}
		if(isset($this->model)){
			foreach($this->model as $v){
				$this->loadModel($v);
			}
		}
	}

	//pousser les variables dans la vue
	public function set($d){
		$this->vars = array_merge($this->vars, $d);
	}

	//inclut la vue qui correspond
	public function render($filename){
		extract($this->vars);
		ob_start();
		require(ROOT.'view/'.get_class($this).'/'.$filename.'.php');
		$content_for_layout = ob_get_clean();

		if($this->layout == false){
			echo $content_for_layout;
		}else{
			require(ROOT.'view/layout/'.$this->layout.'.php');
		}
	}

	//Fonction permettant de charger les modèles
	function loadModel($name){
		require_once(ROOT .'model/'. strtolower($name) .'.php');
		$this->$name = new $name;
	}
}