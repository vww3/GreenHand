<?php 

define('WEBROOT', str_replace('index.php', '',$_SERVER['SCRIPT_NAME']));

define('ROOT', str_replace('index.php', '',$_SERVER['SCRIPT_FILENAME']));

//inclure tous les fichiers du core
require(ROOT.'core/Model.php');
require(ROOT.'core/Controller.php');


//on récupère sous forme de tableau les éléments de l'URL  
$param = explode('/', $_GET['p']);

$controller = $param[0];
$action = isset($param[1]) ? $param[1] : 'index';

require('controller/'.$controller.'.php');

$controller = new $controller();

//on vérifie si l'action du controller existe
if(method_exists($controller, $action)){
	unset($param[0]); unset($param[1]); 
	call_user_func_array(array($controller, $action),$param);
 	//$controller->$action();
}else{
	echo "error 404";
}



 
