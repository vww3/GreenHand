<?php
namespace Controller;

use System\Core\Controller;
Use System\Core\Router;

Use System\Helper\Form;
Use System\Image;

//Use System\Debug;

/**
 * Eco_service class.
 */
class Eco_service extends Controller
{
    /**
     * __construct function.
     * 
     * @access public
     * @return void
     */
    protected function __construct()
    {  
        $this->styles[] = 'base';
        $this->styles[] = 'reset';
        $this->styles[] = 'eco_service';
        $this->styles[] = 'responsive';

        $this->javascript[] = "main_script";
        
        $this->title = 'Notre annuaire de services';

        /*if (
            empty($_SESSION['administrateur']) OR 
            $_SESSION['administrateur'] != true
        )
            $this->go(BASE);*/
    }

    /**
     * index function.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
	    $formNewService = new Form();
	    if($formNewService->posted()) {
		    $formNewService->verify(empty($formNewService->datas('title')), 'Il manque le titre');
		    $formNewService->verify(empty($formNewService->datas('description')), 'Il manque la description');
		    $formNewService->verify(empty($formNewService->datas('link')), 'Il manque le lien vers le service');
		    $formNewService->verify(!$formNewService->downloadable('logo'), 'Il manque le logo du service');
		    
		    if($formNewService->noErrors()) {
				
				$id = $this->model('Service')->save($formNewService->datas());
				
				if(!is_null($id)) {
				
					if($formNewService->downloadable('logo')) {
						$serviceImageFolder = IMAGE.'eco_service/';
					    $serviceImageName = $id.'.jpg';
					    
					    $formNewService->download('logo', $serviceImageFolder, $serviceImageName);
					    
					    $photo = new Image(ROOT.$serviceImageFolder.$serviceImageName);
					    $photo->resize(null, 240);				    
					}
					
					$formNewService->reset();
				}
			}
	    }
	    
	    $services = $this->model('Service')->getAll();
	    $categories = $this->model('ServiceCategory')->all();
	    
	    $categoriesSelection = [];
	    foreach($categories as $categorie) {
		    $categoriesSelection[$categorie->id] = $categorie->title;
	    }
	    
	    $this->datas = compact('formNewService','services', 'categories', 'categoriesSelection');
	    
        $this->view();
        //Debug::show($this->datas);
    }
}
