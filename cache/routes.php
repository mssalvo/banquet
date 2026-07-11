<?php
return array (
  'GET' => 
  array (
    '/api/login' => 
    array (
      'controller' => 'Banquet\\Actions\\Auth\\LoginAuthRest',
      'metodo' => 'send',
    ),
    '/api/logout' => 
    array (
      'controller' => 'Banquet\\Actions\\Auth\\LogoutAuthRest',
      'metodo' => 'send',
    ),
    '/doc' => 
    array (
      'controller' => 'Banquet\\Actions\\Documentazione\\Doc',
      'metodo' => 'send',
    ),
    '/rest' => 
    array (
      'controller' => 'Banquet\\Actions\\Documentazione\\Rest',
      'metodo' => 'send',
    ),
    '/start' => 
    array (
      'controller' => 'Banquet\\Actions\\Documentazione\\Start',
      'metodo' => 'send',
    ),
    '/' => 
    array (
      'controller' => 'Banquet\\Actions\\Home',
      'metodo' => 'send',
    ),
    '/home' => 
    array (
      'controller' => 'Banquet\\Actions\\Home',
      'metodo' => 'send',
    ),
    '/limit' => 
    array (
      'controller' => 'Banquet\\Actions\\Info\\Limit',
      'metodo' => 'send',
    ),
    '/login' => 
    array (
      'controller' => 'Banquet\\Actions\\Login',
      'metodo' => 'send',
    ),
    '/logout' => 
    array (
      'controller' => 'Banquet\\Actions\\Logout',
      'metodo' => 'send',
    ),
    '/notauthorization' => 
    array (
      'controller' => 'Banquet\\Actions\\Notfound\\Notauthorization',
      'metodo' => 'send',
    ),
    '/notfound' => 
    array (
      'controller' => 'Banquet\\Actions\\Notfound\\Notfound',
      'metodo' => 'send',
    ),
  ),
  'POST' => 
  array (
    '/login' => 
    array (
      'controller' => 'Banquet\\Actions\\Login',
      'metodo' => 'send',
    ),
  ),
);