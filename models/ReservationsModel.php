<?php
class ReservationsModel
{
    private $conn;
    private $table_name;

    public function __construct($db)
    {
        $this->conn = $db;
        $tables = include('config/table.php');
        $this->table_name = $tables['reservation'];
    }

    public function isReservationIdExists($reservation_id)
    {
        try 
        {
            $query = "SELECT reservation_id FROM " . $this->table_name . " WHERE reservation_id = :reservation_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':reservation_id', $reservation_id);
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

    public function readAllReservations()
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

    public function isRoomBooked($data)
    {
        try 
        {
            $query = "SELECT COUNT(*) FROM " . $this->table_name . " WHERE room_id = :room_id 
                      AND ((:check_in_datetime <= check_out_datetime) AND (:check_out_datetime >= check_in_datetime))";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':room_id', $data['room_id']);
            $stmt->bindParam(':check_in_datetime', $data['check_in_datetime']);
            $stmt->bindParam(':check_out_datetime', $data['check_out_datetime']);
            $stmt->execute();
            return $stmt->fetchColumn() > 0;
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function insertReservations($data)
    {
        try 
        {
            $query = "INSERT INTO " . $this->table_name . " (customer_id, room_id, check_in_datetime, check_out_datetime, total_price) 
                      VALUES (:customer_id, :room_id, :check_in_datetime, :check_out_datetime, :total_price)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':customer_id', $data['customer_id']);
            $stmt->bindParam(':room_id', $data['room_id']);
            $stmt->bindParam(':check_in_datetime', $data['check_in_datetime']);
            $stmt->bindParam(':check_out_datetime', $data['check_out_datetime']);
            $stmt->bindParam(':total_price', $data['total_price']);

            $stmt->execute();
            return true;
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function removeReservations($reservation_id) 
    {
        try 
        {
            $query = "DELETE FROM " . $this->table_name . " WHERE reservation_id = :reservation_id";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':reservation_id', $reservation_id);

            $stmt->execute();
            return $stmt->rowCount();
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
?>
