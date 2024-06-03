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
        if ($result) {
            echo json_encode(array("message" => "User updated successfully."));
        } else {
            echo json_encode(array("message" => "Failed to update user."));
        }
        exit();
    }

    public function updateCustomers()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if (!isset($data['customer_id'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
        $id = $data['customer_id'];
        $result = $this->customersService->updateCustomers($id, $data);
        if ($result) {
            echo json_encode(array("message" => "User updated successfully."));
        } else {
            echo json_encode(array("message" => "Failed to update user."));
        }
        exit();
    }
}
