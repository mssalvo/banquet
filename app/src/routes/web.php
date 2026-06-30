<?php


$router = new \Banquet\Core\Router();

// Homepage
$router->get('/', \Banquet\Actions\Home::class);
$router->get('/home', \Banquet\Actions\Home::class);
$router->get('/rest/{id}', \Banquet\Actions\Rest::class);

//   
$router->get('/doc/{tipo}/{id}', \Banquet\Actions\Doc::class);
$router->get('/doc', \Banquet\Actions\Doc::class);
$router->get('/start', \Banquet\Actions\Start::class);
$router->get('/rest', \Banquet\Actions\Rest::class);
//con slug + id
$router->get('/rest/{slug}-{id}', \Banquet\Actions\Rest::class);
// con autenticazione
$router->get('/rest/{id}/{code}', \Banquet\Actions\Rest::class)->middleware('auth');
// esempio 
$router->get('/utente/{id}', \Banquet\Actions\Home::class)->middleware('auth');
$router->get('/login', \Banquet\Actions\Login::class);
// Form POST
$router->post('/login', \Banquet\Actions\Login::class);
 
 

 

 

$router->get('/api/corsi', \Banquet\Actions\Api\CorsiRest::class);
$router->get('/api/corsi/{id}', \Banquet\Actions\Api\CorsiRest::class);
$router->post('/api/corsi', \Banquet\Actions\Api\CorsiRest::class);
$router->put('/api/corsi', \Banquet\Actions\Api\CorsiRest::class);
$router->delete('/api/corsi/{id}', \Banquet\Actions\Api\CorsiRest::class);
$router->get('/corsi', \Banquet\Actions\Corsi::class);

return $router;