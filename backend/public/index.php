<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
	http_response_code(200);
	exit(0);
}


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/core/Router.php';
require_once __DIR__ . '/../src/core/Response.php';
require_once __DIR__ . '/../src/controllers/CidadaoController.php';
require_once __DIR__ . '/../src/controllers/DefaultController.php';



$router = new Router();


$router->addRoute('GET','/','DefaultController::index');
$router->addRoute('GET', '/cidadaos', 'CidadaoController::getCidadaos');
$router->addRoute('GET', '/cidadaos/{id}', 'CidadaoController::getCidadao');
$router->addRoute('POST', '/cidadaos', 'CidadaoController::createCidadao');
$router->addRoute('PUT', '/cidadaos/{id}', 'CidadaoController::updateCidadao');

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = strtok( $_SERVER['REQUEST_URI'], '?');

$router->dispatch($requestMethod, $requestUri);
