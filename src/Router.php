<?php

use CoffeeCode\Router\Router;

$router = new Router(SITE['url']);
$router->namespace('Src\Controllers');

/**
 * WEB
 */
$router->group(null);
$router->get('/', 'Web:login', 'web.login');
$router->get('/cadastrar', 'Web:register', 'web.register');
$router->get('/recuperar', 'Web:forget', 'web.forget');
$router->get('/senha/{email}/{forget}', 'Web:reset', 'web.reset');

/**
 * AUTH
 */
$router->group(null);
$router->get('/login', 'Auth:login', 'auth.login');
$router->post('/register', 'Auth:register', 'auth.register');

/**
 * AUTH SOCIAL
 */

/**
 * PROFILE
 */

/**
 * ERRORS
 */
$router->group('ops');
$router->get('/{errcode}', 'Web:error', 'web.error');

/**
 * ROUTE PROCESS
 */
$router->dispatch();

/**
 * ROUTE PROCESS ERRORS
 */
if ($router->error()) {
  $router->redirect('web.error', ['errcode' => $router->error()]);
}
