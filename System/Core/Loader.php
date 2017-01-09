<?php
namespace System\Core;

/**
 * Loader class.
 */
class Loader
{
	/**
	 * _loaded
	 * 
	 * (default value: [])
	 * 
	 * @var mixed
	 * @access private
	 * @static
	 */
	private static $_loaded = [];

    /**
     * auto function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function auto()
    {
        spl_autoload_register([__CLASS__, 'load']);
    }
    
    /**
     * load function.
     * 
     * @access public
     * @static
     * @param $class
     * @return void
     */
    public static function load($class)
    {
	    $file = str_replace('\\', '/', $class);
	    self::$_loaded[] = $class;
	    
	    sort(self::$_loaded);
	    
	    require $file.'.php';

    }
    
    /**
     * whoIsLoaded function.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function whoIsLoaded()
    {
	    return self::$_loaded;
    }
}
