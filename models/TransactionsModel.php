<?php
class TransactionsModel 
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['transaction'];
    }

    public function isTransactionIdExists($id)
    {
        try 
        {
            $query = "SELECT transaction_id FROM " . $this->table_name . " WHERE transaction_id = :transaction_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(":transaction_id", $id);
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

    public function readAllTransactions()
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

    public function insertTransactions($data)
    {
        try 
        {
            $query = "INSERT INTO " . $this->table_name . " (customer_id, total_price) VALUES (:customer_id, :total_price)";
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":customer_id", $data['customer_id']);
            $stmt->bindParam(":total_price", $data['total_price']);
    
            $stmt->execute();
            return true;
        } 
        catch (PDOException $e) 
        {
            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'foreign key constraint') !== false) {
                    return "Foreign key constraint violation: Cannot insert transaction due to related record constraints.";
                } else {
                    return "Integrity constraint violation: " . $e->getMessage();
                }
            } else {
                return "Error: " . $e->getMessage(); 
            }
        }
    }
    

    public function updateTransactions($id, $data)
    {
        try 
        {
            $query = "UPDATE " . $this->table_name . " SET ";
            $params = array();

            if (isset($data['customer_id'])) {
                $query .= "customer_id = :customer_id, ";
                $params[':customer_id'] = $data['customer_id'];
            }

            if (isset($data['total_price'])) {
                $query .= "total_price = :total_price, ";
                $params[':total_price'] = $data['total_price'];
            }

            $query = rtrim($query, ', ');
            $query .= " WHERE transaction_id = :transaction_id";

            $params[':transaction_id'] = $id;

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return $stmt->rowCount();
        } 
        catch (PDOException $e) 
        {
            return "Error: " . $e->getMessage();
        }
    }

    public function deleteTransactions($id) 
    {
        try 
        {
            $query = "DELETE FROM " . $this->table_name . " WHERE transaction_id = :transaction_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(":transaction_id", $id);

            $stmt->execute();
            return $stmt->rowCount();
        } 
        catch (PDOException $e) 
        {
            return "Error: " . $e->getMessage();
        }
    }
}
