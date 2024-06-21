<?php
include_once 'models/ReservationsModel.php';
include_once 'models/RoomsModel.php';
include_once 'services/ReservationsService.php';

class ReservationsController
{
    private $reservationsService;

    public function __construct($conn)
    {
        $reservationsModel = new ReservationsModel($conn);
        $customersModel = new CustomersModel($conn);
        $roomsModel = new RoomsModel($conn);
        $this->reservationsService = new ReservationsService($reservationsModel, $customersModel, $roomsModel);
    }

    public function checkRoomStatus()
    {
        $room_id = isset($_GET['room_id']) ? $_GET['room_id'] : null;
        $check_in_datetime = isset($_GET['check_in_date']) ? $_GET['check_in_date'] : null;
        $check_out_datetime = isset($_GET['check_out_date']) ? $_GET['check_out_date'] : null;
    
        $dateTimeFormat = '/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';
    
        $errorMessages = [];
    
        // Validate room_id
        if (empty($room_id)) {
            $errorMessages[] = 'Room ID is required.';
        }
    
        // Validate check-in datetime
        if (empty($check_in_datetime)) {
            $errorMessages[] = 'Check-in datetime is required.';
        } elseif (!preg_match($dateTimeFormat, $check_in_datetime)) {
            $errorMessages[] = 'Invalid check-in datetime format. Expected format: YYYY-MM-DD HH:MM:SS';
        }
    
        // Validate check-out datetime
        if (empty($check_out_datetime)) {
            $errorMessages[] = 'Check-out datetime is required.';
        } elseif (!preg_match($dateTimeFormat, $check_out_datetime)) {
            $errorMessages[] = 'Invalid check-out datetime format. Expected format: YYYY-MM-DD HH:MM:SS';
        }
    
        // If there are any errors, return them
        if (!empty($errorMessages)) {
            http_response_code(400);
            echo json_encode([
                'message' => $errorMessages
            ]);
            exit();
        }
    
        $data = array(
            'room_id' => $room_id,
            'check_in_datetime' => $check_in_datetime,
            'check_out_datetime' => $check_out_datetime
        );
    
        // Call the service method
        $roomStatus = $this->reservationsService->getRoomStatus($data);
    
        // Prepare and return the response
        $response = json_decode($roomStatus, true);
        if ($response['status'] === "available") {
            echo json_encode([
                'status' => 'available',
                'message' => 'Room is available for the selected dates.'
            ]);
        } elseif ($response['status'] === "booked") {
            echo json_encode([
                'status' => 'booked',
                'message' => 'Room is already booked for the selected dates.'
            ]);
        } else {
            echo json_encode([
                'message' => $response['message']
            ]);
        }
        exit();
    }
    
    public function readReservations()
    {
        $reservations = $this->reservationsService->fetchAllReservations();
        return json_encode($reservations);
    }

    public function addReservations()
    {
        $data = json_decode(file_get_contents("php://input"), true);
    
        $errorMessages = [];
    
        if (empty($data['customer_id'])) {
            $errorMessages[] = "Customer ID is required.";
        }
    
        if (empty($data['room_id'])) {
            $errorMessages[] = "Room ID is required.";
        }
    
        if (empty($data['check_in_datetime'])) {
            $errorMessages[] = "Check-in datetime is required.";
        } elseif (!strtotime($data['check_in_datetime'])) {
            $errorMessages[] = "Invalid check-in datetime format.";
        }
        
        if (empty($data['check_out_datetime'])) {
            $errorMessages[] = "Check-out datetime is required.";
        } elseif (!strtotime($data['check_out_datetime'])) {
            $errorMessages[] = "Invalid check-out datetime format.";
        }
        
        if (empty($data['total_price'])) {
            $errorMessages[] = "Total price is required.";
        } elseif (!is_numeric($data['total_price'])) {
            $errorMessages[] = "Invalid total price format.";
        }
    
        if (!empty($errorMessages)) {
            echo json_encode(array("message" => $errorMessages));
            return;
        }
        
        $result = $this->reservationsService->addReservations($data);
        if ($result === true) {
            echo json_encode(array("message" => "Reservation added successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }

    public function updateReservations() 
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['reservation_id']) || empty($data['reservation_id'])) {
            echo json_encode(["message" => "Reservation ID is required."]);
            return;
        }

        $errorMessages = [];
        // Validasi khusus untuk tanggal dan waktu
        if (isset($data['check_in_datetime'])) {
            $datetime_parts = explode(' ', $data['check_in_datetime']);
            if (count($datetime_parts) !== 2 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datetime_parts[0]) || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $datetime_parts[1])) {
                $errorMessages[] = "Invalid check-in datetime format. Use YYYY-MM-DD HH:MM:SS.";
            }
        }
        
        if (isset($data['check_out_datetime'])) {
            $datetime_parts = explode(' ', $data['check_out_datetime']);
            if (count($datetime_parts) !== 2 || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $datetime_parts[0]) || !preg_match('/^\d{2}:\d{2}:\d{2}$/', $datetime_parts[1])) {
                $errorMessages[] = "Invalid check-out datetime format. Use YYYY-MM-DD HH:MM:SS.";
            }
        }
    
        // Validasi format total price jika ada
        if (isset($data['total_price']) && !is_numeric($data['total_price'])) {
            $errorMessages[] = "Invalid total price format. Must be a number.";
        }
    
        if (!empty($errorMessages)) {
            echo json_encode(array("message" => $errorMessages));
            return;
        }
    
    
        $id = $data['reservation_id'];
        $result = $this->reservationsService->updateReservation($id, $data);
        if ($result === true) {
            echo json_encode(array("message" => "Reservation updated successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }
    
    public function deleteReservations()
    {
        $data = json_decode(file_get_contents("php://input"), true);
    
        if (!isset($data['reservation_id']) || empty($data['reservation_id'])) {
            echo json_encode(["message" => "Reservation ID is required."]);
            return;
        }
    
        $reservation_id = $data['reservation_id'];
        $result = $this->reservationsService->deleteReservations($reservation_id);
        if ($result === true) {
            echo json_encode(["message" => "Reservation deleted successfully."]);
        } else {
            echo json_encode(["message" => $result]);
        }
        exit();
    }
}
?>
