<?php
//DIR APP
define('DIR_APP', dirname(__DIR__));

//FOLDER_HOME IL NOME DELLA CARTELLA DI BASE DELL'APPLICAZIONE, 
//INSERISCI DOPPI APICI ('') SE SI TROVA NELLA DIRECTORY PRINCIPALE. 

define('FOLDER_HOME', '');

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
define('DIR_ACTION_NAME', DIR_APP.'/setting/prop/'); 

//extention file
define('TEMPLATE_EXT', '.php');
//language
define('KEY_LANG', 'mslanguage');
define('LANG_DEFAULT', 'it');
//page 
define('ACTION_PAGE_404', 'notfound/notfound'); 

define('LOG_DIR_NAME', dirname(DIR_APP).'/');
define('LOG_FILE_NAME', 'log.txt'); 
define('IS_LOG', 'ALL'); //ERROR - INFO - ALL
define('LOG_MAX_SIZE',1048576); // 1 MB
define('ACTION_NAME_TEXT', 'action');
define('ACTION_DEF', 'home');


?>