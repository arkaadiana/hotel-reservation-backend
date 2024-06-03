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

            return $stmt->execute();
        
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }

    public function updateCustomers($id, $data)
    {
        try
        {
            $query = "UPDATE " . $this->table_name . " SET name = :name, email = :email, phone_number = :phone_number WHERE customer_id = :customer_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":customer_id", $id);
            $stmt->bindParam(":name", $data['name']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":phone_number", $data['phone_number']);

            return $stmt->execute();
        }
        catch (PDOException $e)
        {
            echo "Error: " . $e->getMessage();
        }
    }
}