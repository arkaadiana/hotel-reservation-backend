<?php
include_once 'models/RoomsModel.php';
include_once 'services/RoomsService.php';

class RoomsController
{
    private $roomsService;

    public function __construct($conn)
    {
        $roomsModel = new RoomsModel($conn);
        $this->roomsService = new RoomsService($roomsModel);
    }

    public function readRooms()
    {
        $rooms = $this->roomsService->fetchAllRooms();
        return json_encode($rooms);
    }

    public function checkRoomStatus()
    {
        $room_id = $_GET['room_id'] ?? '';
        $check_in_date = $_GET['check_in_date'] ?? '';
        $check_out_date = $_GET['check_out_date'] ?? '';
    
        $errorMessages = [];
    
        if (empty($room_id)) {
            $errorMessages[] = "Room ID is required.";
        }
        
        if (empty($check_in_date)) {
            $errorMessages[] = "Check-in date is required.";
        } elseif (!strtotime($check_in_date)) {
            $errorMessages[] = "Invalid check-in date format.";
        }
    
        if (empty($check_out_date)) {
            $errorMessages[] = "Check-out date is required.";
        } elseif (!strtotime($check_out_date)) {
            $errorMessages[] = "Invalid check-out date format.";
        }
    
        if (!empty($errorMessages)) {
            echo json_encode(["message" => $errorMessages]);
            return;
        }
    
        $status = $this->roomsService->checkRoomStatus($room_id, $check_in_date, $check_out_date);
        return json_encode(["status" => $status]);
    }
    
    public function addRooms()
    {
        $data = json_decode(file_get_contents("php://input"), true);
    
        $errorMessages = [];
    
        if (empty($data['room_type'])) {
            $errorMessages[] = "Room type is required.";
        } else {
            $roomType = strtolower(trim($data['room_type']));
            if ($roomType === 'single') {
                $data['room_type'] = 'Single';
            } elseif ($roomType === 'double') {
                $data['room_type'] = 'Double';
            } elseif ($roomType === 'suite') {
                $data['room_type'] = 'Suite';
            } else {
                $errorMessages[] = "Invalid room type. Allowed values are: Single, Double, Suite.";
            }
        }
    
        if (empty($data['price'])) {
            $errorMessages[] = "Price is required.";
        } elseif (!is_numeric($data['price'])) {
            $errorMessages[] = "Price must be a number.";
        }
    
        if (!empty($errorMessages)) {
            echo json_encode(["message" => $errorMessages]);
            return;
        }
    
        $result = $this->roomsService->addRooms($data);
        if ($result === true) {
            echo json_encode(["message" => "Room added successfully."]);
        } else {
            echo json_encode(["message" => $result]);
        }
        exit();
    }

    public function updateRooms()
    {
        $data = json_decode(file_get_contents("php://input"), true);
    
        $errorMessages = [];
    
        if (isset($data['room_type'])) {
            $roomType = strtolower(trim($data['room_type']));
            if ($roomType === 'single') {
                $data['room_type'] = 'Single';
            } elseif ($roomType === 'double') {
                $data['room_type'] = 'Double';
            } elseif ($roomType === 'suite') {
                $data['room_type'] = 'Suite';
            } else {
                $errorMessages[] = "Invalid room type. Allowed values are: Single, Double, Suite.";
            }
        }
    
        if (isset($data['price']) && !is_numeric($data['price'])) {
            $errorMessages[] = "Price must be a number.";
        }
    
        if (!empty($errorMessages)) {
            echo json_encode(["message" => $errorMessages]);
            return;
        }
    
        $id = $data['room_id'];
        $result = $this->roomsService->updateRooms($id, $data);
        if ($result === true) {
            echo json_encode(["message" => "Room updated successfully."]);
        } else {
            echo json_encode(["message" => $result]);
        }
        exit();
    
    }
    
    public function deleteRooms()
    {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['room_id']) || empty($data['room_id'])) {
            echo json_encode(["message" => "ID is required."]);
            return;
        }
    
        $id = $data['room_id'];
        $result = $this->roomsService->deleteRooms($id);
        if ($result === true) {
            echo json_encode(["message" => "Room deleted successfully."]);
        } else {
            echo json_encode(["message" => $result]);
        }
        exit();
    }
}

