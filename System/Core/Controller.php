<?php
namespace System\Core;

/**
 * Controller main class - this class must be extended by all controller.
 * This class allows controllers to use some common methods and attributes.
 * It mainly allows to generate, organize and call views and models
 *
 * @package IRON
 * @link ... nothing yet...
 * @author Mickaël Boidin <mickael.boidin@icloud.com>
 */
class Controller
{
	/**
	 * Instance of the called controller.
	 *
	 * @var Controller
	 * @static
	 * @access private
	 */
	private static $instance = null;
	
	/**
	 * The content of the title meta tag of the current web page.
	 *
	 * @var string
	 * @access protected
	 */
	protected $title;
	
	/**
	 * List of metadatas used by the current web page.
	 * This is list allows to build the meta tags
	 *
	 * @var array
	 * @access protected
	 */
	protected $metadatas = [
        'viewport' => 'width=device-width, initial-scale=1',
        'og' => [
            'url' => URL,
        ]
    ];
    
    /**
	 * List of stylesheets used by the current web page.
	 * This is list allows to build the link tags
	 *
	 * @var array
	 * @access protected
	 */
    protected $styles = [
        'base',
    ];
    
    /**
	 * List of JavaScripts used by the current web page.
	 * This is list allows to build the script tags
	 *
	 * @var array
	 * @access protected
	 */
    protected $javascript = [];
    
	/**
	 * List of datas/vars that will be transmitted to the view
	 * This list will be "extracted" in order to use simple vars in view
	 *
	 * @var array
	 * @access protected
	 */
	protected $datas = [];

    /**
     * List of loaded models. Simplify the use of models.
     *
     * @var array
     * @access private
     */
    private $_models = [];

    /**
     * The current layout used by the current page.
     * A layout is a wrap for the content of the page.
     * It contains usually headers and footers
     *
     * @var string
     * @access protected
     * @static
     */
    protected $layout = 'default';

    /**
     * The content of the actual web page.
     * Must be used in layouts. Layout + Content = View.
     *
     * @var mixed
     * @access private
     */
    private $_contentForLayout;

    /**
     * Constructor of the controller.
     *
     * @access protected
     * @return void
     */
    protected function __construct()
    {
	    //Example: "Home - index"
	    $this->title = ucfirst(CONTROLLER).' - '.ACTION;   
    }

    /**
     * Call and organize models instances.
     * Create and instance of the called models in the _models var if doesn't exist.
     * Otherwise it just return it.
     *
     * @access protected
     * @param string $name The name of the called model (Class)
     * @return Model
     */
    protected function model($name)
    {
        if (empty($this->_models[$name])) {
	        //we call the name of the model dynamically. A model is in the namespace \Model\
            $model = '\Model\\'.$name;
            //example: $this->model('User') -> $this->_models['User'] = new \Model\User()
            $this->_models[$name] = new $model;
        }

        return $this->_models[$name];
    }

    /**
     * Call a view for the current page.
     * A view is a Layout + it content
     *
     * @access protected
     * @param string $name The name of the view. By default is the name of the called action
     * @return void
     */
    protected function view($name = ACTION)
    {
	    //we store the display in memory in order to use it in a var (_contentForLayout)
        ob_start();

		//extraction create vars from an array : ['foo' => 1] => $foo = 1
		//we extract alls datas from controller in order to simply their use in te view (simple vars)
        extract($this->datas);
        
        //views are in the View folder at the root of the website. Each controller has it view folder
        require 'View/'.CONTROLLER.'/'.$name.'.php';
		
		//we take the display (view) and put in the _contentForLayout var -> will be put in Layout
        $this->_contentForLayout = ob_get_clean();
		
		//if we don't need a layout we just diplay the content
        if ($this->layout != null)
            require 'View/'.$this->layout.'.php';
        else
            echo $this->_contentForLayout;
    }
    
    /**
     * Create instance of called controller and execute the called action.
     * 
     * @access public
     * @static
     * @return Controller
     */
    public static function instance()
    {
	    //instance must be created just once (singleton)
	    if (self::$instance == null) {	        
	        date_default_timezone_set(TIMEZONE);  
		    
	        //GET['p'] is cut by slash to make array -> settings
 	        $settings = array_filter(explode('/', $_GET['p']));
	        
	        //if we allow multilingual content we use the first settings as the language
	        //we build current language and the base. Base = Webroot + Language
	        //array_shift remove the first content of an array and return it
	        if (MULTILINGUAL === true) {
		        define('LANGUAGE'	, !empty($settings) ? array_shift($settings) : DEFAULT_LANGUAGE );	
		        define('BASE'		, WEBROOT.LANGUAGE.'/');
	        } else {
		        define('LANGUAGE'	, DEFAULT_LANGUAGE);
	            define('BASE'		, WEBROOT);
	        }
	        
	        //we set translation for local uses (example: dates -> February / Février)
	        setlocale(LC_ALL, 
	                  LANGUAGE.'.UTF-8', 
	                  LANGUAGE.'_'.LANGUAGE.'.UTF-8');  
	                           
	        //we set the name of the called contoller with the new first setting
	        //if the settings are empty or the controller doesn't exist, the default controller is called
	        define('CONTROLLER',
	        	!empty($settings) && file_exists('Controller/'.$settings[0].'.php') ?
	            array_shift($settings) :
	            DEFAULT_CONTROLLER
	        );
	
	        //we set the name of the called action with the new first setting
	        //if the settings are empty or the action doesn't exist, the default action is called
	        define('ACTION',
	         	!empty($settings) && method_exists('\Controller\\'.CONTROLLER, $settings[0]) ?
	            array_shift($settings) :
	            DEFAULT_ACTION
	        );
	        
	        //we create the instance
	        $controller = '\Controller\\'.ucfirst(CONTROLLER);
	        self::$instance = new $controller;    
	        
	        //we execute the action with the rest of the settings
	        //example of uses : controller/action/foo/faa -> (new controller)->action(foo, faa)
	        call_user_func_array([self::$instance, ACTION], $settings);
        }
        
        return self::$instance;
    }
    
    /**
     * Redirection to other URL.
     * 
     * @access public
     * @static
     * @param string $url
     * @return void
     */
    public static function go($url)
    {
        header('location: '.$url);
        //we prevent the execution of more code (security)
        exit;        
    }
}
