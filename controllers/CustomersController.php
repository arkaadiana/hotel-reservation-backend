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
        $customers = $this->customersService->fetchAllCustomers();
        return json_encode($customers);
    }

    public function addCustomers()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $errorMessages = [];

        if (!isset($data['name']) || empty($data['name'])) {
            $errorMessages[] = "Name is required.";
        }
    
        if (empty($data['email'])) {
            $errorMessages[] = "Email is required.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMessages[] = "Invalid email format.";
        }
    
        if (!isset($data['phone_number']) || empty($data['phone_number'])) {
            $errorMessages[] = "Phone number is required.";
        } elseif (!preg_match("/^\d{10,}$/", $data['phone_number'])) {
            $errorMessages[] = "Invalid phone number format.";
        }
    
        if (!empty($errorMessages)) {
            echo json_encode(array("message" => $errorMessages));
            return;
        }

        $result = $this->customersService->addCustomers($data);
        if ($result === true) {
            echo json_encode(array("message" => "Customer added successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }
    
    public function updateCustomers() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['customer_id']) || empty($data['customer_id'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
    
        $id = $data['customer_id'];
        $result = $this->customersService->updateCustomers($id, $data);
        if ($result === true) {
            echo json_encode(array("message" => "Customer updated successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }
    
    public function deleteCustomers() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['customer_id']) || empty($data['customer_id'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }

        $id = $data['customer_id'];
        $result = $this->customersService->deleteCustomers($id);
        if ($result === true) {
            echo json_encode(array("message" => "Customer deleted successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }
}
