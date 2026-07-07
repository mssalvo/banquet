<?php
return array (
  'GET' => 
  array (
    '/api/corsi' => 
    array (
      'controller' => 'Banquet\\Actions\\Api\\CorsiRest',
      'metodo' => 'getAll',
    ),
    '/api/corsi/{id}' => 
    array (
      'controller' => 'Banquet\\Actions\\Api\\CorsiRest',
      'metodo' => 'getById',
    ),
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
    '/corsi' => 
    array (
      'controller' => 'Banquet\\Actions\\Corsi',
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
    '/api/corsi' => 
    array (
      'controller' => 'Banquet\\Actions\\Api\\CorsiRest',
      'metodo' => 'getInsert',
    ),
    '/login' => 
    array (
      'controller' => 'Banquet\\Actions\\Login',
      'metodo' => 'send',
    ),
  ),
  'UPDATE' => 
  array (
    '/api/corsi' => 
    array (
      'controller' => 'Banquet\\Actions\\Api\\CorsiRest',
      'metodo' => 'getUpdate',
    ),
  ),
  'DELETE' => 
  array (
    '/api/corsi/{id}' => 
    array (
      'controller' => 'Banquet\\Actions\\Api\\CorsiRest',
      'metodo' => 'getDelete',
    ),
  ),
);