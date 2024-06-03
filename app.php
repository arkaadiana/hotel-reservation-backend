<?php
include_once 'controllers/CustomersController.php';
include_once 'config/database.php'; 
include_once 'middleware/Router.php';

$database = new Database();
$db = $database->getConnection();

$router = new Router();
$router->register('GET', '/api/customers', [new CustomersController($db), 'readCustomers']);
$router->register('POST', '/api/customers', [new CustomersController($db), 'addCustomers']);
$router->register('PUT', '/api/customers', [new CustomersController($db), 'updateCustomers']);

$router->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

