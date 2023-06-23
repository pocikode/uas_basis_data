<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once __DIR__ . '/../vendor/autoload.php';


use App\Controllers\HomeController;

$dotenv = \Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

$router = new \App\Router;
$router->get('/', HomeController::class, 'index');
$router->run();
