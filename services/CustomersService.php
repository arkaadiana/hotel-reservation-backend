<?php
include_once 'models/CustomersModel.php';

class CustomersService
{
    private $customersModel;

    public function __construct(CustomersModel $customersmodel)
    {
        $this->customersModel = $customersmodel;
    }

    public function fetchAllCustomers()
    {
        $stmt = $this->customersModel->readAllCustomers();
        $customers_array = array();
        $customers_array["records"] = array();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $customers_item = array (
                "customer_id" => $customer_id,
                "name" => $name,
                "email" => $email,
                "phone_number" => $phone_number
            );
            array_push($customers_array["records"], $customers_item);
        }
        
        return $customers_array;
    }

    public function addCustomers($data)
    {
        $stmt = $this->customersModel->insertCustomers($data);
        return $stmt;
    }

    public function updateCustomers($id, $data) 
    {
        $isCustomerIdExists = $this->customersModel->isCustomerIdExists($id);
        if (is_string($isCustomerIdExists)) {
            return $isCustomerIdExists;
        }
    
        if (!$isCustomerIdExists) {
            return "Customer not found.";
        }
    
        $rowCount = $this->customersModel->updateCustomers($id, $data);

        if (is_string($rowCount)) {
            return $rowCount;
        } else {
            if ($rowCount > 0) {
                return true;
            } else {
                return "No changes made.";
            }
        }
    }
    
    public function deleteCustomers($id) 
    {
        $isCustomerIdExists = $this->customersModel->isCustomerIdExists($id);
        
        if (!$isCustomerIdExists) {
            return "Customer not found.";
        }
    
        $rowCount = $this->customersModel->removeCustomers($id);
    
        if (is_string($rowCount)) {
            return $rowCount;
        } else {
            if ($rowCount > 0) {
                return true;
            } else {
                return "Failed to delete customer.";
            }
        }
    }
}


