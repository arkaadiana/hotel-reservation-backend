<?php

include_once 'models/CustomersModel.php';
include_once 'services/CustomersService.php';

class CustomersController
{
    private $customersService;

    public function __construct($conn)
    {
        $customersModel = new CustomersModel($conn);
        $this->customersService = new CustomersService($customersModel);
    }

    public function readCustomers()
    {
        $users = $this->customersService->fetchAllCustomers();
        return json_encode($users);
    }

    public function addCustomers()
    {
        $data = json_decode(file_get_contents("php://input"), true);    
        $result = $this->customersService->addCustomers($data);
        return json_encode(["message"=>$result]);
    }
}
