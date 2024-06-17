<?php
include_once 'controllers/CustomersController.php';
include_once 'controllers/RoomsController.php';
include_once 'controllers/ReservationsController.php';
include_once 'config/database.php'; 
include_once 'middleware/Router.php';

$database = new Database();
$db = $database->getConnection();

$router = new Router();
$router->register('GET', '/api/customers', [new CustomersController($db), 'readCustomers']);
$router->register('POST', '/api/customers', [new CustomersController($db), 'addCustomers']);
$router->register('PUT', '/api/customers', [new CustomersController($db), 'updateCustomers']);
$router->register('DELETE', '/api/customers', [new CustomersController($db), 'deleteCustomers']);

$router->register('GET', '/api/rooms', [new RoomsController($db), 'readRooms']);
$router->register('GET', '/api/rooms/status', [new RoomsController($db), 'checkRoomStatus']);
$router->register('POST', '/api/rooms', [new RoomsController($db), 'addRooms']);
$router->register('PUT', '/api/rooms', [new RoomsController($db), 'updateRooms']);
$router->register('DELETE', '/api/rooms', [new RoomsController($db), 'deleteRooms']);

$router->register('GET', '/api/reservations/room-status', [new ReservationsController($db), 'checkRoomStatus']);
$router->register('GET', '/api/reservations', [new ReservationsController($db), 'readReservations']);
$router->register('POST', '/api/reservations', [new ReservationsController($db), 'addReservations']);
$router->register('DELETE', '/api/reservations', [new ReservationsController($db), 'deleteReservations']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
