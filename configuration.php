<?php
/*
/* ██████████████████████████████████████████████████████████████████████████
/* ██   ██   ██ ████ █     █   ██   ██ ███ █    ███   ██   █   ██   ██ ████ █
/* █ ████ ███ █  ███ ██ █████ ██ █████ ███ █ ███ █ ███ ██ ███ ██ ███ █  ███ █
/* █ ████ ███ █ █ ██ ██  ████ ██ ██  █ ███ █ ▀▀▄██     ██ ███ ██ ███ █ █ ██ █
/* █ ████ ███ █ ██ █ ██ █████ ██ ███ █ ███ █ ██ ██ ███ ██ ███ ██ ███ █ ██ █ █
/* ██   ██   ██ ███  █   ███   ██   ███   ██ ███ █ ███ ██ ██   ██   ██ ███  █
/* ██████████████████████████████████████████████████████████████████████████
*/
// ERRORS
ini_set('display_errors', true); error_reporting(E_ALL);

// SESSION
session_start();

// DEFAULT
define('DEFAULT_CONTROLLER'  ,    'Connexion');
define('DEFAULT_ACTION'      ,    'index');
define('DEFAULT_LANGUAGE'    ,    'fr');
define('MULTILINGUAL'        ,    false);
define('TIMEZONE'            ,    'Europe/Paris');
define('SALT'                ,    '^msziéçà&76(sfé1ù*$');

// ACCESS
define('WEBROOT'             ,    str_replace('index.php','',$_SERVER['SCRIPT_NAME']));
define('ROOT'                ,    $_SERVER['DOCUMENT_ROOT']);
define('DOMAIN'              ,    $_SERVER['HTTP_HOST']);
define('PROTOCOL'            ,    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https://' : 'http://');
define('ADDRESS'             ,    PROTOCOL.DOMAIN.WEBROOT);
define('URL'                 ,    PROTOCOL.DOMAIN.$_SERVER['REQUEST_URI']);
define('PREVIOUS'            ,    isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : WEBROOT);

// FOLDERS
define('ASSET'               ,    WEBROOT.'Asset/');
define('IMAGE'               ,    ASSET.'Image/');
define('STYLE'               ,    ASSET.'Style/');
define('JAVASCRIPT'          ,    ASSET.'Javascript/');
define('RFM'            	 ,    ASSET.'Filemanager/');
define('RFM_FILE'      		 ,    ASSET.'Source/');
define('RFM_THUMB'      	 ,    ASSET.'Thumbs/');

// MYSQL
define('MYSQL_HOST'          ,    DOMAIN == "localhost:8888" ? 'localhost' : '');
define('MYSQL_DATABASE'      ,    DOMAIN == "localhost:8888" ? 'GreenHand' : '');
define('MYSQL_LOGIN'         ,    DOMAIN == "localhost:8888" ? 'root' : '');
define('MYSQL_PASSWORD'      ,    DOMAIN == "localhost:8888" ? '' : '');

// SHORTCUTS (no need for FOLDERS CONSTs)
define('RFM_OPEN'       	 ,    RFM.'dialog.php');
define('JQUERY'              ,    'jquery/jquery');
define('FANCYBOX'            ,    'jquery/fancybox/fancybox');
define('FANCYBOX_INIT'       ,    'jquery/fancybox/init');
define('FANCYBOX_CSS'        ,    '../Javascript/jquery/fancybox/fancybox');
define('TINYMCE'             ,    'tinyMCE/tinymce.min');
define('TINYMCE_INIT'        ,    'tinyMCE/init');
define('CHART'               ,    'chart/chart');

// CONSTANT CREATED DURING INITIALIZATION
// --> BASE = root of the website + language = WEBROOT/LANGUAGE/
// --> CONTROLLER = name of the current controller
// --> ACTION = name of the current action
// --> LANGUAGE = actual language of the site