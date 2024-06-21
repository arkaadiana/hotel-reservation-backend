<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/controllers/RoomsControllerTest.php
use PHPUnit\Framework\TestCase;

require_once 'controllers/RoomsController.php';

class RoomsControllerTest extends TestCase
{
    private $roomsService;
    private $roomsController;
    private $conn;

    protected function setUp(): void
    {
        // Create a mock for the RoomsService class
        $this->roomsService = $this->createMock(RoomsService::class);

        // Create a mock for the connection
        $this->conn = $this->createMock(PDO::class);

        // Mock the prepare method to return a statement mock
        $stmtMock = $this->createMock(PDOStatement::class);
        $this->conn->method('prepare')->willReturn($stmtMock);

        // Initialize the RoomsController
        $this->roomsController = new RoomsController($this->conn);

        // Inject the mock service into the controller using reflection
        $reflection = new ReflectionClass($this->roomsController);
        $property = $reflection->getProperty('roomsService');
        $property->setAccessible(true);
        $property->setValue($this->roomsController, $this->roomsService);
    }

    public function testReadRooms()
    {
        // Prepare a mock statement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturnOnConsecutiveCalls(
            ['room_id' => 1, 'room_type' => 'Deluxe', 'price' => 200],
            false
        );

        // Mock the fetchAllRooms method to return the mock statement
        $this->roomsService->method('fetchAllRooms')->willReturn([
            "records" => [
                [
                    "room_id" => 1,
                    "room_type" => "Single",
                    "price" => 200
                ]
            ]
        ]);

        $result = $this->roomsController->readRooms();

        $expected = json_encode([
            "records" => [
                [
                    "room_id" => 1,
                    "room_type" => "Single",
                    "price" => 200
                ]
            ]
        ]);

        $this->assertEquals($expected, $result);
    }
}
