<?php
include_once 'controllers/CustomersController.php';
include_once 'controllers/RoomsController.php';
include_once 'controllers/TransactionsController.php';

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

$router->register('GET', '/api/transactions', [new TransactionsController($db), 'readTransactions']);
$router->register('POST', '/api/transactions', [new TransactionsController($db), 'addTransactions']);
$router->register('PUT', '/api/transactions', [new TransactionsController($db), 'updateTransactions']);
$router->register('DELETE', '/api/transactions', [new TransactionsController($db), 'deleteTransactions']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
