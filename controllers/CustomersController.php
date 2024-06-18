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

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(array("message" => "Invalid JSON format."));
            return;
        }

        $errorMessages = [];

        if (empty($data['name'])) {
            $errorMessages[] = "Name is required.";
        }
    
        if (empty($data['email'])) {
            $errorMessages[] = "Email is required.";
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMessages[] = "Invalid email format.";
        }
    
        if (empty($data['phone_number'])) {
            $errorMessages[] = "Phone number is required.";
        } elseif (!preg_match("/^\d{10,}$/", $data['phone_number'])) {
            $errorMessages[] = "Invalid phone number format. Must be at least 10 digits.";
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
    
    public function updateCustomers() 
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(array("message" => "Invalid JSON format."));
            return;
        }
    
        if (!isset($data['customer_id']) || empty($data['customer_id'])) {
            echo json_encode(array("message" => "Customer ID is required."));
            return;
        }

        $errorMessages = [];

        if (isset($data['name']) && empty(trim($data['name']))) {
            $errorMessages[] = "Name cannot be empty.";
        }

        // Validasi format email jika ada
        if (isset($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMessages[] = "Invalid email format.";
        }
    
        // Validasi format phone_number jika ada
        if (isset($data['phone_number']) && !preg_match("/^\d{10,}$/", $data['phone_number'])) {
            $errorMessages[] = "Invalid phone number format. Must be at least 10 digits.";
        }
    
        // Jika ada kesalahan validasi, kirim pesan kesalahan kembali
        if (!empty($errorMessages)) {
            echo json_encode(array("message" => $errorMessages));
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
    
    public function deleteCustomers() 
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(array("message" => "Invalid JSON format."));
            return;
        }

        if (!isset($data['customer_id']) || empty($data['customer_id'])) {
            echo json_encode(array("message" => "Customer ID is required."));
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
