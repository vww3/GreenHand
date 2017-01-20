<?php
namespace Controller;

use System\Core\Controller;
Use System\Core\Router;

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
        $this->styles[] = 'accueil';
        $this->styles[] = 'eco_service';
        $this->styles[] = 'responsive';

        $this->javascript[] = "main_script";

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
        $this->view();
    }
}
