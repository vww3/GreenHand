<?php
namespace System\Core;

/**
 * Controller class.
 *
 * Main class for controllers. Must be extended !
 */
class Controller
{	
	private static $instance = null;
	
	protected $title;
	
	protected $metadatas = [
        'viewport' => 'width=device-width, initial-scale=1',
        'og' => [
            'url' => URL,
        ]
    ];
    
    protected $styles = [
        'base',
    ];
    
    protected $javascript = [];
    
	/**
	 * datas
	 *
	 * (default value: [])
	 *
	 * @var mixed
	 * @access protected
	 */
	protected $datas = [];

    /**
     * _models
     *
     * (default value: [])
     *
     * @var mixed
     * @access private
     */
    private $_models = [];

    /**
     * layout
     *
     * (default value: 'default')
     *
     * @var string
     * @access protected
     * @static
     */
    protected $layout = 'default';

    /**
     * _contentForLayout
     *
     * @var mixed
     * @access private
     */
    private $_contentForLayout;

    /**
     * __construct function.
     *
     * @access protected
     * @return void
     */
    protected function __construct()
    {
	    $this->title = ucfirst(CONTROLLER).' - '.ACTION;   
    }

    /**
     * model loader function.
     *
     * @access protected
     * @param string $name
     * @return Model
     */
    protected function model(string $name)
    {
        if (empty($this->_models[$name])) {
            $model = '\Model\\'.$name;
            $this->_models[$name] = new $model;
        }

        return $this->_models[$name];
    }

    /**
     * view loader function.
     *
     * Automaticly, it will load a view and inject all of it in the template
     *
     * @access protected
     * @param string $name (default: __ACTION__)
     * @return void
     */
    protected function view(string $name = ACTION)
    {
        ob_start();

        extract($this->datas);
        require 'View/'.CONTROLLER.'/'.$name.'.php';

        $this->_contentForLayout = ob_get_clean();

        if ($this->layout != null)
            require 'View/'.$this->layout.'.php';
        else
            echo $this->_contentForLayout;
    }
    
    /**
     * instance function.
     * 
     * @access public
     * @static
     * @return controller instance
     */
    public static function instance()
    {   
	    if (self::$instance == null) {	        
	        //Définition du fuseau horaire
	        date_default_timezone_set(TIMEZONE);  
		    
	        //Découpage des paramètres par slashes
	        $settings = array_filter(explode('/', $_GET['p']));
	        
	        //Définition du site en multi langue ou non
	        if (MULTILINGUAL === true) {
		        define('LANGUAGE'	, !empty($settings) ? array_shift($settings) : DEFAULT_LANGUAGE );	
		        define('BASE'		, WEBROOT.LANGUAGE.'/');
	        } else {
		        define('LANGUAGE'	, DEFAULT_LANGUAGE);
	            define('BASE'		, WEBROOT);
	        }
	        
	        //Définition de la langue en locale
	        setlocale(LC_ALL, 
	                  LANGUAGE.'.UTF-8', 
	                  LANGUAGE.'_'.LANGUAGE.'.UTF-8');  
	                           
	        //Extraction du nom du controller
	        define('CONTROLLER',
	        	!empty($settings) && file_exists('Controller/'.$settings[0].'.php') ?
	            array_shift($settings) :
	            DEFAULT_CONTROLLER
	        );
	
	        //Extraction de l'action        
	         define('ACTION',
	         	!empty($settings) && method_exists('\Controller\\'.CONTROLLER, $settings[0]) ?
	            array_shift($settings) :
	            DEFAULT_ACTION
	        );
	        
	        $controller = '\Controller\\'.ucfirst(CONTROLLER);
	        self::$instance = new $controller;    
	                
	        call_user_func_array([self::$instance, ACTION], $settings);
        }
        
        return self::$instance;
    }
    
    /**
     * redirection to URL function.
     * 
     * @access public
     * @static
     * @param string $url
     * @return void
     */
    public static function go(string $url)
    {
        header('location: '.$url);
        exit;        
    }
}
