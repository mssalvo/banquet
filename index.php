<?php

	//cmd: composer dump-autoload

	require __DIR__ . '/vendor/autoload.php';


	$response = new \Banquet\Ms\Core\Response();
	$response->addHeader('Content-Type: text/html; charset=utf-8');
	$response->setCompression(NULL);

	\Banquet\Ms\Core\EnvLoader::load(__DIR__ . '/.env');

	$container = new \Banquet\Ms\Core\Container();
 
	// salva globalmente
	$GLOBALS['app'] = $container;


	\Banquet\Ms\Core\Factory::setContainer($container);


 

        if (!session_id()) {
		$time = 1200; 
		$ses = 'mssesid';
		session_set_cookie_params($time);
		session_name($ses);
		//session_regenerate_id(true);
		session_start();
        \Banquet\Ms\Core\Log::writeInfo("index session_start -> true");
		if(isset($_COOKIE[$ses])){
		setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
		\Banquet\Ms\Core\Log::writeInfo("index setcookie -> ".$ses);
		}
	}

	\Banquet\Ms\Core\Factory::setResponse($response);

 
// In locale metti true (ricarica sempre), 
// in produzione metti false (usa la cache super veloce)
$isDevelopment = true; 
$cachePath = __DIR__ . '/cache/routes.php';

$router = new \Banquet\Ms\Core\RouterClass($cachePath, $isDevelopment);

$router->resolve();







     
?> 
