<?php
namespace Controller;

use System\Core\Controller;
Use System\Core\Router;

/**
 * accueil class.
 */
class Accueil extends Controller
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
        $this->styles[] = 'accueil';

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
