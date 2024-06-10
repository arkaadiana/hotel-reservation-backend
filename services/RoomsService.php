<?php
include_once 'models/RoomsModel.php';

class RoomsService
{
    private $roomsModel;

    public function __construct(RoomsModel $roomsmodel)
    {
        $this->roomsModel = $roomsmodel;
    }

    public function fetchAllRooms()
    {
        $stmt = $this->roomsModel->readAllRooms();
        $rooms_array = array();
        $rooms_array["records"] = array();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $rooms_item = array (
                "room_id" => $room_id,
                "room_type" => $room_type,
                "price" => $price
            );
            array_push($rooms_array["records"], $rooms_item);
        }
        
        return $rooms_array;
    }

    public function checkRoomStatus($room_id, $check_in_date, $check_out_date)
    {
        if (!$this->roomsModel->isRoomIdExists($room_id)) {
            return "Room not found";
        }

        $stmt = $this->roomsModel->getRoomStatus($room_id, $check_in_date, $check_out_date);
        if ($stmt) {
            // Room is booked
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['status'];
        } else {
            // Room is available
            return "available";
        }
    }

    public function addRooms($data)
    {
        $stmt = $this->roomsModel->insertRooms($data);
        return $stmt;
    }

    public function updateRooms($id, $data)
    {
        $isRoomIdExists = $this->roomsModel->isRoomIdExists($id);
        if (is_string($isRoomIdExists)) {
            return $isRoomIdExists;
        }
    
        if (!$isRoomIdExists) {
            return "Room not found.";
        }
    
        $rowCount = $this->roomsModel->updateRooms($id, $data);
    
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

    public function deleteRooms($id) 
    {
        $isRoomIdExists = $this->roomsModel->isRoomIdExists($id);
        
        if (!$isRoomIdExists) {
            return "Room not found.";
        }
        $rowCount = $this->roomsModel->removeRooms($id);
        
        if (is_string($rowCount)) {
            return $rowCount;
        } else {
            if ($rowCount > 0) {
                return true;
            } else {
                return "Failed to delete room.";
            }
        }
    }
}


