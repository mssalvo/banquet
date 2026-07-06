<?php

	//cmd: composer dump-autoload

	require __DIR__ . '/vendor/autoload.php';


	$response = new \Banquet\Core\Response();
	$response->addHeader('Content-Type: text/html; charset=utf-8');
	$response->setCompression(NULL);

	\Banquet\Core\EnvLoader::load(__DIR__ . '/.env');

	$container = new \Banquet\Core\Container();
 
	// salva globalmente
	$GLOBALS['app'] = $container;


	\Banquet\Core\Factory::setContainer($container);


 

        if (!session_id()) {
		$time = 1200; 
		$ses = 'mssesid';
		session_set_cookie_params($time);
		session_name($ses);
		//session_regenerate_id(true);
		session_start();
                    \Banquet\Core\Log::writeInfo("index session_start -> true");
		if(isset($_COOKIE[$ses])){
		setcookie($ses, $_COOKIE[$ses], time() + $time, "/");
			\Banquet\Core\Log::writeInfo("index setcookie -> ".$ses);
		}
	}

	\Banquet\Core\Factory::setResponse($response);


	\Banquet\Core\Factory::execute();// output(\Banquet\Core\Action::getAction());
 
 
     
?> 
