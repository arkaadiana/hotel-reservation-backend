<?php
class RoomsModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['room'];
    }

    public function isRoomIdExists($room_id)
    {
        try 
        {
            $query = "SELECT room_id FROM " . $this->table_name . " WHERE room_id = :room_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':room_id', $room_id);
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

    public function readAllRooms()
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

    public function insertRooms($data)
    {
        try 
        {
            $query = "INSERT INTO " . $this->table_name . " (room_type, price) VALUES (:room_type, :price)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':room_type', $data['room_type']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->execute();
            return true;
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function updateRooms($id, $data) 
    {
        try 
        {
            $query = "UPDATE " . $this->table_name . " SET ";
            $params = array();

            if (isset($data['room_type'])) {
                $query .= "room_type = :room_type, ";
                $params[':room_type'] = $data['room_type'];
            }

            if (isset($data['price'])) {
                $query .= "price = :price, ";
                $params[':price'] = $data['price'];
            }

            $query = rtrim($query, ', ');
            $query .= " WHERE room_id = :room_id";

            $params[':room_id'] = $id;

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return $stmt->rowCount();
        } 
        catch (PDOException $e) 
        {
            return "Error: " . $e->getMessage();
        }
    }

    public function removeRooms($id) 
    {
        try 
        {
            $query = "DELETE FROM " . $this->table_name . " WHERE room_id = :room_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':room_id', $id);

            $stmt->execute();
            return $stmt->rowCount();
        } 
        catch (PDOException $e) 
        {
            if ($e->getCode() == '23000') {
                $errorMessage = $e->getMessage();
                if (strpos($errorMessage, 'foreign key constraint') !== false) {
                    return "Foreign key constraint violation: Cannot delete room because of existing related records.";
                } else {
                    return "Integrity constraint violation: " . $e->getMessage();
                }
            } else {
                return "Error: " . $e->getMessage(); 
            }
        }
    }
}
