<?php
include_once 'models/ReservationsModel.php';
include_once 'models/CustomersModel.php';
include_once 'models/RoomsModel.php';

class ReservationsService
{
    private $reservationsModel;
    private $customersModel;
    private $roomsModel;
    
    public function __construct(ReservationsModel $reservationsModel, CustomersModel $customersModel, RoomsModel $roomsModel)
    {
        $this->reservationsModel = $reservationsModel;
        $this->customersModel = $customersModel;
        $this->roomsModel = $roomsModel;
    }

    // Reservation operations
    public function getRoomStatus($data, $exclude_reservation_id = null)
    {
        // Check if the room_id exists
        if (!$this->roomsModel->isRoomIdExists($data['room_id'])) {
            return json_encode(array("status" => "error", "message" => "Room not found."));
        }

        // Check if the room is booked for the given date range
        $isBooked = $this->reservationsModel->isRoomBooked($data, $exclude_reservation_id);
        
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

        $errorMessages = [];

        if (!$this->customersModel->isCustomerIdExists($data['customer_id'])) {
            $errorMessages[] = "Customer not found.";
        }
        
        if (!$this->roomsModel->isRoomIdExists($data['room_id'])) {
            $errorMessages[] = "Room not found.";
        }
        
        if ($roomStatus["status"] === "booked") {
            $errorMessages[] = "Room is not available for the selected dates.";
        }
        
        if (!empty($errorMessages)) {
            return $errorMessages;
        }
        
        return $this->reservationsModel->insertReservations($data);
    }

    public function updateReservation($id, $data)
    {
        $roomStatus = json_decode($this->getRoomStatus($data, $id), true);

        $errorMessages = [];

        $isReservationIdExists = $this->reservationsModel->isReservationIdExists($id);
        if (is_string($isReservationIdExists)) {
            $errorMessages[] = $isReservationIdExists;
        }
        
        if (!$isReservationIdExists) {
            $errorMessages[] = "Reservation not found.";
        }
        
        if (!$this->customersModel->isCustomerIdExists($data['customer_id'])) {
            $errorMessages[] = "Customer not found.";
        }
        
        if (!$this->roomsModel->isRoomIdExists($data['room_id'])) {
            $errorMessages[] = "Room not found.";
        }
        
        if ($roomStatus["status"] === "booked") {
            $errorMessages[] = "Room is not available for the selected dates.";
        }
        
        if (!empty($errorMessages)) {
            return $errorMessages;
        }

        $rowCount = $this->reservationsModel->updateReservations($id, $data);
    
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
