<?php
class CustomersModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['customer'];
    }

    public function isCustomerIdExists($id)
    {
        try 
        {
            $query = "SELECT customer_id FROM " . $this->table_name . " WHERE customer_id = :customer_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":customer_id", $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return !empty($result);
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function readAllCustomers()
    {
        try
        {
            $query = "SELECT * FROM " . $this->table_name;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
    
            return $stmt;
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function insertCustomers($data)
    {
        try 
        {
            $query = "INSERT INTO " . $this->table_name . " (name, email, phone_number) VALUES (:name, :email, :phone_number)";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":phone_number", $data['phone_number']);
    
            $stmt->execute();
            return true;
        } 
        catch (PDOException $e) 
        {
            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'email') !== false) {
                    return "Duplicate email detected";
                } elseif (strpos($errorMessage, 'phone_number') !== false) {
                    return "Duplicate phone number detected";
                } else {
                    return "Integrity constraint violation: " .  $e->getMessage();
                }
            } else {
                echo "Error: " . $e->getMessage();
                return false;
            }
        }
    }

    public function updateCustomers($id, $data)
    {
        try
        {
            $query = "UPDATE " . $this->table_name . " SET ";
            $params = array();
            
            if(isset($data['name'])) {
                $query .= "name = :name, ";
                $params[':name'] = $data['name'];
            }
            if(isset($data['email'])) {
                $query .= "email = :email, ";
                $params[':email'] = $data['email'];
            }
            if(isset($data['phone_number'])) {
                $query .= "phone_number = :phone_number, ";
                $params[':phone_number'] = $data['phone_number'];
            }
            
            $query = rtrim($query, ', ');
            $query .= " WHERE customer_id = :customer_id";
            
            $params[':customer_id'] = $id;
    
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);
    
            return $stmt->rowCount();
        }
        catch (PDOException $e)
        {
            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'email') !== false) {
                    return "Duplicate email detected.";
                } elseif (strpos($errorMessage, 'phone_number') !== false) {
                    return "Duplicate phone number detected.";
                } else {
                    return "Integrity constraint violation: " . $e->getMessage();
                }
            } else {
                return "Error: " . $e->getMessage();
            }
        }
    }
    
    public function removeCustomers($id)
    {
        try
        {
            $query = "DELETE FROM " . $this->table_name . " WHERE customer_id = :customer_id";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":customer_id", $id);

            $stmt->execute();
            return $stmt->rowCount();
        }
        catch (PDOException $e)
        {
            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'foreign key constraint') !== false) {
                    return "Foreign key constraint violation: Cannot delete customer because of existing related records.";
                } else {
                    return "Integrity constraint violation: " . $e->getMessage();
                }
            } else {
                return "Error: " . $e->getMessage();
            }
        }
    }
}