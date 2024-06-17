<?php
include_once 'models/ReservationsModel.php';

class ReservationsService
{
    private $reservationsModel;

    public function __construct(ReservationsModel $reservationsModel)
    {
        $this->reservationsModel = $reservationsModel;
    }

    // Reservation operations
    public function getRoomStatus($data)
    {
        // Check if the room is booked for the given date range
        $isBooked = $this->reservationsModel->isRoomBooked($data);
    
        // Return "booked" if the room is booked, otherwise return "available"
        $status = $isBooked ? "booked" : "available";
        return json_encode(array("status" => $status));
    }

    public function fetchAllReservations()
    {
        $stmt = $this->reservationsModel->readAllReservations();
        $reservations_array = array();
        $reservations_array["records"] = array();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $reservations_item = array (
                "reservation_id" => $reservation_id,
                "customer_id" => $customer_id, 
                "room_id" => $room_id,
                "check_in_datetime" => $check_in_datetime,
                "check_out_datetime" => $check_out_datetime,
                "total_price" => $total_price 
            );
            array_push($reservations_array["records"], $reservations_item);
        }
        
        return $reservations_array;
    }

    public function addReservations($data)
    {
        $roomStatus = json_decode($this->getRoomStatus($data), true);
        
        if ($roomStatus["status"] === "booked") {
            return "Room is not available for the selected dates.";
        }
    
        return $this->reservationsModel->insertReservations($data);
    }

    public function deleteReservations($id)
    {
        $isReservationIdExists = $this->reservationsModel->isReservationIdExists($id);
        
        if (!$isReservationIdExists) {
            return "Reservation not found.";
        }
        $rowCount = $this->reservationsModel->removeReservations($id);
        
        if (is_string($rowCount)) {
            return $rowCount;
        } else {
            if ($rowCount > 0) {
                return true;
            } else {
                return "Failed to delete reservation.";
            }
        }
    }
}
?>
