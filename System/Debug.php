<?php
namespace System;

/**
 * Debug class.
 */
class Debug
{	

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

    public static function multi()
    {
	    foreach (func_get_args() as $var) {
		    echo self::show($var);
	    }
    }

    public static function session($color = '#C0392B')
    {
	    $session = $_SESSION ? print_r($_SESSION, true) : 'Session non-initialisée';
	    echo self::show($session, 'Session', $color);
    }
    
    public static function loader($color = '#4183D7')
    {
	    $loader = Core\Loader::whoIsLoaded();
	    echo self::show($loader, 'Loaded Class', $color);
    }
}
