<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();

require_once __DIR__ . '/../vendor/autoload.php';


use App\Controllers\HomeController;
use App\Controllers\MahasiswaController;

$dotenv = \Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

$router = new \App\Router;
$router->get('/', HomeController::class, 'index');
$router->get('/mahasiswa', MahasiswaController::class, 'index');
$router->post('/mahasiswa/store', MahasiswaController::class, 'store');
$router->post('/mahasiswa/update/{nim}', MahasiswaController::class, 'update');
$router->post('/mahasiswa/delete/{nim}', MahasiswaController::class, 'delete');

$router->run();
