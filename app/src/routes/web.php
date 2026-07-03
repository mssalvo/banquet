<?php


$router = new \Banquet\Core\Router();

if(!defined('FOLDER_HOME')) {
   define('FOLDER_HOME', '');
}

// Login Autenticazione REST genera jwt token 
$router->post(FOLDER_HOME.'/api/login', \Banquet\Actions\Auth\LoginAuthRest::class);
// Logout Autenticazione REST revoca jwt token 
$router->post(FOLDER_HOME.'/api/logout', \Banquet\Actions\Auth\LogoutAuthRest::class);
// Attenzione: queste rotte sono necessarie per il corretto funzionamento dell'autenticazione JWT.
// Non rimuoverle se utilizzi login/logout per le tue API.

// Homepage
$router->get(FOLDER_HOME.'/', \Banquet\Actions\Home::class);
$router->get(FOLDER_HOME.'/home', \Banquet\Actions\Home::class);
$router->get(FOLDER_HOME.'/rest/{id}', \Banquet\Actions\Rest::class);

//   
$router->get(FOLDER_HOME.'/doc/{tipo}/{id}', \Banquet\Actions\Doc::class);
$router->get(FOLDER_HOME.'/doc', \Banquet\Actions\Doc::class);
$router->get(FOLDER_HOME.'/start', \Banquet\Actions\Start::class);
$router->get(FOLDER_HOME.'/rest', \Banquet\Actions\Rest::class);
//con slug + id
$router->get(FOLDER_HOME.'/rest/{slug}-{id}', \Banquet\Actions\Rest::class);
// con autenticazione
$router->get(FOLDER_HOME.'/user/{id}/{code}', \Banquet\Actions\Rest::class)->middleware('auth');
// esempio 
$router->get(FOLDER_HOME.'/utente/{id}', \Banquet\Actions\Home::class)->middleware('auth');
$router->get(FOLDER_HOME.'/login', \Banquet\Actions\Login::class);
// Form POST
$router->post(FOLDER_HOME.'/login', \Banquet\Actions\Login::class);


 


return $router;