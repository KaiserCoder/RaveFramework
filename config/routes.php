<?php

use rave\core\Config;

use rave\core\Error;
use rave\core\router\Router;
use rave\core\exception\RouterException;

/**
* Instantiation of the Router object
*/
$router = new Router($_GET['url'] ?? '/');

$router->get('/', ['Main' => 'index']);

/**
* Error routes
*/
$router->get(Config::getError('404'), ['Error' => 'notFound']);

$router->get(Config::getError('403'), ['Error' => 'forbidden']);

$router->get(Config::getError('500'), ['Error' => 'internalServerError']);

/**
* Run the router. If an exception is caught, the user
* will be redirected to a 404 error page.
*/
try {
    $router->run();
} catch (RouterException $exception) {
    Error::create($exception->getMessage(), 404);
}