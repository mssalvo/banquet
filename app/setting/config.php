<?php
//DIR APP
define('DIR_APP', dirname(__DIR__));

// HTTP
define('HTTP_SERVER', 'http://localhost:8000/');

// HTTPS
define('HTTPS_SERVER', 'https://localhost:8000/');

define('HTTP_SRC', 'http://localhost:8000/');
define('BRAND', 'http://localhost:8000/app/brand/'); 

// DIR applicazione
define('DIR_APPLICATION', DIR_APP.'/src/');
define('DIR_TEMPLATE', DIR_APP.'/src/view/');
define('DIR_TEMPLATE_MASTER', DIR_APP.'/src/view/master/'); 
define('DIR_LOAD', DIR_APP.'/src/view/language/');

//ms core
define('DIR_SYSTEM', DIR_APP.'/src/ms/');
define('DIR_ACTION_NAME', DIR_APP.'/setting/prop/');
define('DIR_DATABASE', DIR_APP.'/src/ms/driver/'); 

//base folder name
define('BASE_SEPARATOR', '/');
define('BASE_ACTION', 'actions');
define('BASE_MODEL', 'model');
define('BASE_VIEW', 'view');
define('BASE_PAGES', 'pages');
define('BASE_LANGUAGE', 'language');
define('BASE_BRAND', 'brand');
//extention file
define('PHP_EXT', '.php');
define('TEMPLATE_EXT', '.php');
//language
define('KEY_LANG', 'mslanguage');
define('LANG_DEFAULT', 'it');
//page 
define('ACTION_PAGE_INIT', 'home'); 
define('ACTION_PAGE_404', 'notfound/notfound'); 

define('LOG_DIR_NAME', dirname(DIR_APP).'/');
define('LOG_FILE_NAME', 'log.txt'); 
define('IS_LOG', 'ALL'); //ERROR - INFO - ALL
define('LOG_MAX_SIZE',1048576); // 1 MB
define('ACTION_NAME_TEXT', 'action');
define('ACTION_DEF', 'home');


?>