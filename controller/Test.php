<?php 
class Test extends Controller{

	var $model = array('Categorie');

	public function index(){

		$d['test'] = $this->Categorie->getLast();


		$this->set($d);

		$this->render('index');
	}

	//génère une page en fonction de l'id
	function view($id){

		$d['test'] = $this->Categorie->find(array(
			'condition' => 'id='.$id
		));
		$d['test'] = $d['test'][0]; 
		$this->set($d);
		$this->render('view');
	}

}


