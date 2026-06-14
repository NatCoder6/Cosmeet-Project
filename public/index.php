<?php
// ============================================================
// COSMEET — Entry Point
// ============================================================
declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Cosmeet\Core\Auth;
use Cosmeet\Core\Router;

Auth::start();

$router = new Router();

// Public routes
$router->get('/',                             ['HomeController',        'index']);
$router->get('/missions',                     ['MissionController',     'index']);
$router->get('/missions/{slug}',              ['MissionController',     'show']);

// Auth routes
$router->get('/register',                     ['AuthController',        'showRegister']);
$router->post('/register',                    ['AuthController',        'register']);
$router->get('/login',                        ['AuthController',        'showLogin']);
$router->post('/login',                       ['AuthController',        'login']);
$router->get('/logout',                       ['AuthController',        'logout']);

// Reservation routes
$router->get('/reserve/{slug}',               ['ReservationController', 'create']);
$router->post('/reserve',                     ['ReservationController', 'store']);
$router->get('/my-reservations',              ['ReservationController', 'myReservations']);
$router->post('/cancel-reservation/{id}',     ['ReservationController', 'cancel']);

// Payment routes
$router->get('/payment/{code}',               ['PaymentController',     'show']);
$router->post('/payment/process',             ['PaymentController',     'process']);
$router->get('/receipt/{txId}',               ['PaymentController',     'receipt']);

// Dashboard
$router->get('/dashboard',                    ['DashboardController',   'index']);

// Readiness Assessment
$router->get('/readiness',                    ['ReadinessController',   'show']);
$router->post('/readiness',                   ['ReadinessController',   'submit']);

// Admin routes
$router->get('/admin',                        ['AdminController',       'dashboard']);
$router->get('/admin/missions',               ['AdminController',       'missions']);
$router->post('/admin/missions',              ['AdminController',       'storeMission']);
$router->post('/admin/missions/delete/{id}',  ['AdminController',       'deleteMission']);
$router->get('/admin/reservations',           ['AdminController',       'reservations']);
$router->get('/admin/users',                  ['AdminController',       'users']);

// Dispatch
$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Strip base path if running in subdirectory (XAMPP)
$base = '/cosmeet/public';
if (str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}
$uri = $uri ?: '/';

$router->dispatch($method, $uri);
