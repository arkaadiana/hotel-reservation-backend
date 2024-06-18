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
   
    public function addRooms()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(array("message" => "Invalid JSON format."));
            return;
        }
    
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

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(array("message" => "Invalid JSON format."));
            return;
        }
    
        if (!isset($data['room_id']) || empty($data['room_id'])) {
            echo json_encode(array("message" => "Room ID is required."));
            return;
        }
    
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

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(array("message" => "Invalid JSON format."));
            return;
        }
    
        if (!isset($data['room_id']) || empty($data['room_id'])) {
            echo json_encode(["message" => "Room ID is required."]);
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

