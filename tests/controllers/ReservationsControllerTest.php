<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/controllers/ReservationsControllerTest.php
use PHPUnit\Framework\TestCase;

require_once 'controllers/ReservationsController.php';

class ReservationsControllerTest extends TestCase
{
    private $reservationsService;
    private $reservationsController;
    private $conn;

    protected function setUp(): void
    {
        // Create a mock for the ReservationsService class
        $this->reservationsService = $this->createMock(ReservationsService::class);

        // Create a mock for the connection
        $this->conn = $this->createMock(PDO::class);

        // Mock the prepare method to return a statement mock
        $stmtMock = $this->createMock(PDOStatement::class);
        $this->conn->method('prepare')->willReturn($stmtMock);

        // Initialize the ReservationsController
        $this->reservationsController = new ReservationsController($this->conn);

        // Inject the mock service into the controller using reflection
        $reflection = new ReflectionClass($this->reservationsController);
        $property = $reflection->getProperty('reservationsService');
        $property->setAccessible(true);
        $property->setValue($this->reservationsController, $this->reservationsService);
    }

    public function testReadReservations()
    {
        // Prepare a mock statement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturnOnConsecutiveCalls(
            [
                'reservation_id' => 1,
                'customer_id' => 1,
                'room_id' => 1,
                'check_in_datetime' => '2024-06-01 14:00:00',
                'check_out_datetime' => '2024-06-05 12:00:00',
                'total_price' => 500
            ],
            false
        );

        // Mock the fetchAllReservations method to return the mock statement
        $this->reservationsService->method('fetchAllReservations')->willReturn([
            "records" => [
                [
                    "reservation_id" => 1,
                    "customer_id" => 1,
                    "room_id" => 1,
                    "check_in_datetime" => "2024-06-01 14:00:00",
                    "check_out_datetime" => "2024-06-05 12:00:00",
                    "total_price" => 500
                ]
            ]
        ]);

        $result = $this->reservationsController->readReservations();

        $expected = json_encode([
            "records" => [
                [
                    "reservation_id" => 1,
                    "customer_id" => 1,
                    "room_id" => 1,
                    "check_in_datetime" => "2024-06-01 14:00:00",
                    "check_out_datetime" => "2024-06-05 12:00:00",
                    "total_price" => 500
                ]
            ]
        ]);

        $this->assertEquals($expected, $result);
    }
}
?>
