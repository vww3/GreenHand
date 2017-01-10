<?php
namespace System\Core;

/**
 * Loader class. Allow to load manually and automatically class files
 *
 * @package IRON
 * @link ... nothing yet...
 * @author Mickaël Boidin <mickael.boidin@icloud.com>
 */
class Loader
{
	/**
	 * List of loaded files (for debug purpose).
	 * 
	 * @var array
	 * @access private
	 * @static
	 */
	private static $_loaded = [];

    /**
     * Initialize autoloading of class files.
     * 
     * @access public
     * @static
     * @return void
     */
    public static function auto()
    {
	    //__CLASS__ = name of this class (Loader)
        spl_autoload_register([__CLASS__, 'load']);
    }
    
    /**
     * Manual load of class files. We use the namespaces to build the way of the file
     * 
     * @access public
     * @static
     * @param string $class The name of the needed class
     * @return void
     */
    public static function load($class)
    {
	    //the only difference between namespace and way is the / and the \
	    $file = str_replace('\\', '/', $class);
	    self::$_loaded[] = $class;
	    
	    //we sort the _loaded var for better human reading
	    sort(self::$_loaded);
	    
	    require $file.'.php';

    }
    
    /**
     * Return the list of the loaded files.
     * Because files has feelings this is "who" and not "what" ;P
     * 
     * @access public
     * @static
     * @return array
     */
    public static function whoIsLoaded()
    {
	    return self::$_loaded;
    }
}
