<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();

require_once __DIR__ . '/../vendor/autoload.php';


use App\Controllers\HomeController;
use App\Controllers\KHSController;
use App\Controllers\KRSController;
use App\Controllers\MahasiswaController;

$dotenv = \Dotenv\Dotenv::createMutable(dirname(__DIR__));
$dotenv->load();

$router = new \App\Router;

$router->get('/', HomeController::class, 'index');
$router->get('/mahasiswa', MahasiswaController::class, 'index');
$router->post('/mahasiswa/store', MahasiswaController::class, 'store');
$router->post('/mahasiswa/update/{nim}', MahasiswaController::class, 'update');
$router->post('/mahasiswa/delete/{nim}', MahasiswaController::class, 'delete');

$router->get('/krs', KRSController::class, 'index');
$router->post('/krs/store', KRSController::class, 'store');
$router->post('/krs/update/{kode}', KRSController::class, 'update');
$router->post('/krs/delete/{kode}', KRSController::class, 'delete');

$router->get('/khs', KHSController::class, 'index');
$router->post('/khs/store', KHSController::class, 'store');
$router->post('/khs/update/{kode}', KHSController::class, 'update');
$router->post('/khs/delete/{kode}', KHSController::class, 'delete');

$router->run();
