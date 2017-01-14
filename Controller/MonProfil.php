<?php
namespace Controller;

use System\Core\Controller;
Use System\Core\Router;

/**
 * MonProfil class.
 */
class MonProfil extends Controller
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
        $this->styles[] = 'monprofil';

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
