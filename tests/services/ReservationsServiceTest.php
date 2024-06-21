<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/services/ReservationsServiceTest.php
use PHPUnit\Framework\TestCase;

require_once 'services/ReservationsService.php';

class ReservationsServiceTest extends TestCase
{
    private $reservationsModel;
    private $customersModel;
    private $roomsModel;
    private $reservationsService;

    protected function setUp(): void
    {
        // Create mocks for the model classes
        $this->reservationsModel = $this->createMock(ReservationsModel::class);
        $this->customersModel = $this->createMock(CustomersModel::class);
        $this->roomsModel = $this->createMock(RoomsModel::class);

        // Initialize the ReservationsService with the mocked models
        $this->reservationsService = new ReservationsService($this->reservationsModel, $this->customersModel, $this->roomsModel);
    }

    public function testGetRoomStatusBooked()
    {
        $data = [
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00'
        ];

        // Mock the behavior of isRoomIdExists and isRoomBooked methods
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(true);

        $result = $this->reservationsService->getRoomStatus($data);

        $expected = json_encode(["status" => "booked"]);
        $this->assertEquals($expected, $result);
    }

    public function testGetRoomStatusAvailable()
    {
        $data = [
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00'
        ];

        // Mock the behavior of isRoomIdExists and isRoomBooked methods
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(false);

        $result = $this->reservationsService->getRoomStatus($data);

        $expected = json_encode(["status" => "available"]);
        $this->assertEquals($expected, $result);
    }

    public function testFetchAllReservations()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturnOnConsecutiveCalls(
            [
                'reservation_id' => 1,
                'customer_id' => 1,
                'room_id' => 1,
                'check_in_datetime' => '2024-06-01 12:00:00',
                'check_out_datetime' => '2024-06-05 12:00:00',
                'total_price' => 500
            ],
            false
        );

        // Expect the readAllReservations method to be called and return the mock statement
        $this->reservationsModel->method('readAllReservations')->willReturn($stmt);

        $result = $this->reservationsService->fetchAllReservations();

        $expected = [
            "records" => [
                [
                    "reservation_id" => 1,
                    "customer_id" => 1,
                    "room_id" => 1,
                    "check_in_datetime" => '2024-06-01 12:00:00',
                    "check_out_datetime" => '2024-06-05 12:00:00',
                    "total_price" => 500
                ]
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testAddReservationsCustomerNotFound()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];
    
        // Mock the behavior of isCustomerIdExists to return false
        $this->customersModel->method('isCustomerIdExists')->willReturn(false);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
    
        $result = $this->reservationsService->addReservations($data);
    
        $this->assertEquals(["Customer not found."], $result);
    }

    public function testAddReservationsRoomNotFound()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];
    
        // Mock the behavior of isRoomIdExists to return false
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(false);
    
        $result = $this->reservationsService->addReservations($data);
    
        $this->assertEquals(["Room not found."], $result);
    }
    

    public function testAddReservationsRoomBooked()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];

        // Mock the behavior of isCustomerIdExists, isRoomIdExists, and isRoomBooked methods
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(true);

        $result = $this->reservationsService->addReservations($data);

        $this->assertEquals(["Room is not available for the selected dates."], $result);
    }

    public function testAddReservationsSuccess()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];

        // Mock the behavior of isCustomerIdExists, isRoomIdExists, isRoomBooked, and insertReservations methods
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(false);
        $this->reservationsModel->method('insertReservations')->willReturn(true);

        $result = $this->reservationsService->addReservations($data);

        $this->assertTrue($result);
    }

    public function testUpdateReservationNotFound()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];

        // Mock the behavior of isReservationIdExists method to return false
        $this->reservationsModel->method('isReservationIdExists')->willReturn(false);
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(false);

        $result = $this->reservationsService->updateReservation(1, $data);

        $this->assertEquals(["Reservation not found."], $result);
    }

    public function testUpdateReservationCustomerNotFound()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];
    
        // Mock the behavior of isCustomerIdExists to return false
        $this->reservationsModel->method('isReservationIdExists')->willReturn(true);
        $this->customersModel->method('isCustomerIdExists')->willReturn(false);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(false);
    
        $result = $this->reservationsService->updateReservation(1, $data);
    
        $this->assertEquals(["Customer not found."], $result);
    }

    public function testUpdateReservationRoomNotFound()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];
    
        // Mock the behavior of isRoomIdExists to return false
        $this->reservationsModel->method('isReservationIdExists')->willReturn(true);
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(false);
        $this->reservationsModel->method('isRoomBooked')->willReturn(false);
    
        $result = $this->reservationsService->updateReservation(1, $data);
    
        $this->assertEquals(["Room not found."], $result);
    }
    
    public function testUpdateReservationRoomBooked()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];

        // Mock the behavior of isReservationIdExists, isCustomerIdExists, isRoomIdExists, and isRoomBooked methods
        $this->reservationsModel->method('isReservationIdExists')->willReturn(true);
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(true);

        $result = $this->reservationsService->updateReservation(1, $data);

        $this->assertEquals(["Room is not available for the selected dates."], $result);
    }

    public function testUpdateReservationSuccess()
    {
        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2024-06-01 12:00:00',
            'check_out_datetime' => '2024-06-05 12:00:00',
            'total_price' => 500
        ];

        // Mock the behavior of isReservationIdExists, isCustomerIdExists, isRoomIdExists, isRoomBooked, and updateReservations methods
        $this->reservationsModel->method('isReservationIdExists')->willReturn(true);
        $this->customersModel->method('isCustomerIdExists')->willReturn(true);
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->reservationsModel->method('isRoomBooked')->willReturn(false);
        $this->reservationsModel->method('updateReservations')->willReturn(1);

        $result = $this->reservationsService->updateReservation(1, $data);

        $this->assertTrue($result);
    }

    public function testDeleteReservationsNotFound()
    {
        // Mock the behavior of isReservationIdExists method to return false
        $this->reservationsModel->method('isReservationIdExists')->willReturn(false);

        $result = $this->reservationsService->deleteReservations(1);

        $this->assertEquals("Reservation not found.", $result);
    }

    public function testDeleteReservationsSuccess()
    {
        // Mock the behavior of isReservationIdExists and removeReservations methods
        $this->reservationsModel->method('isReservationIdExists')->willReturn(true);
        $this->reservationsModel->method('removeReservations')->willReturn(1);

        $result = $this->reservationsService->deleteReservations(1);

        $this->assertTrue($result);
    }
}
?>
