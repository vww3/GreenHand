<?php
namespace System;

/**
 * Debug static class. This class can help you to develop your website but must be unused for the render.
 *
 * @package IRON
 * @link ... nothing yet...
 * @author Mickaël Boidin <mickael.boidin@icloud.com>
 */
class Debug
{	
	/**
     * Show datas.
     * 
     * @access public
     * @static
     * @param mixed $element The datas to debug
     * @param string $title The title of the debug zone
     * @param string $background The color of the debug zone
     * @return void
     */
	public static function show($element, $title = null, $background = "#333")
	{    
		if ($title) {
			$titleStyle = "color: $background; background: white; padding: 15px 45px; margin: 0 -45px 15px;";
			$title = "<h1 style='$titleStyle'>$title</h1>";
		}
		$print = str_replace(
			['[',']'],
			['<b style="color:yellow;">[', ']</b>'],
			filter_var(print_r($element, true), FILTER_SANITIZE_SPECIAL_CHARS)
		);
		$style = "
			box-sizing: content-box;
			color: white; font-size: 16px;
			box-shadow: 0 -5px 10px 0 rgba(0,0,0,.33);
			padding: 30px 40px; margin: 0; 
			overflow-x: auto;
		";
		
        echo "<pre style='background: $background; $style'>$title $print</pre>";
    }

	/**
     * Show multiple datas. This function can use any number of parameters
     * 
     * @access public
     * @static
     * @return void
     */
    public static function multi()
    {
	    foreach (func_get_args() as $var) {
		    self::show($var);
	    }
    }
	
	/**
     * Show session datas.
     * 
     * @access public
     * @static
     * @param string $color The color of the debug zone
     * @return void
     */
    public static function session($color = '#C0392B')
    {
	    $session = $_SESSION ? print_r($_SESSION, true) : 'Session non-initialisée';
	    echo self::show($session, 'Session', $color);
    }
    
    /**
     * Show loaded class files (see \Core\Loader class).
     * 
     * @access public
     * @static
     * @param string $color The color of the debug zone
     * @return void
     */
    public static function loader($color = '#4183D7')
    {
	    $loader = Core\Loader::whoIsLoaded();
	    echo self::show($loader, 'Loaded Class', $color);
    }
}
