<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/services/RoomsServiceTest.php
use PHPUnit\Framework\TestCase;

require_once 'services/RoomsService.php';

class RoomsServiceTest extends TestCase
{
    private $roomsModel;
    private $roomsService;

    protected function setUp(): void
    {
        // Create a mock for the RoomsModel class
        $this->roomsModel = $this->createMock(RoomsModel::class);

        // Initialize the RoomsService with the mocked RoomsModel
        $this->roomsService = new RoomsService($this->roomsModel);
    }

    public function testFetchAllRooms()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturnOnConsecutiveCalls(
            ['room_id' => 1, 'room_type' => 'Single', 'price' => 100],
            false
        );

        // Expect the readAllRooms method to be called and return the mock statement
        $this->roomsModel->method('readAllRooms')->willReturn($stmt);

        $result = $this->roomsService->fetchAllRooms();
        
        $expected = [
            "records" => [
                [
                    "room_id" => 1,
                    "room_type" => "Single",
                    "price" => 100
                ]
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testAddRooms()
    {
        $data = [
            'room_type' => 'Double',
            'price' => 150
        ];

        // Expect the insertRooms method to be called and return true
        $this->roomsModel->method('insertRooms')->willReturn(true);

        $result = $this->roomsService->addRooms($data);

        $this->assertTrue($result);
    }

    public function testUpdateRooms()
    {
        $data = [
            'room_type' => 'Double',
            'price' => 150
        ];

        // Mock the behavior of isRoomIdExists and updateRooms methods
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->roomsModel->method('updateRooms')->willReturn(1);

        $result = $this->roomsService->updateRooms(1, $data);

        $this->assertTrue($result);
    }

    public function testUpdateRoomsNotFound()
    {
        $data = [
            'room_type' => 'Double',
            'price' => 150
        ];

        // Mock the behavior of isRoomIdExists method to return false
        $this->roomsModel->method('isRoomIdExists')->willReturn(false);

        $result = $this->roomsService->updateRooms(1, $data);

        $this->assertEquals("Room not found.", $result);
    }

    public function testDeleteRooms()
    {
        // Mock the behavior of isRoomIdExists and removeRooms methods
        $this->roomsModel->method('isRoomIdExists')->willReturn(true);
        $this->roomsModel->method('removeRooms')->willReturn(1);

        $result = $this->roomsService->deleteRooms(1);

        $this->assertTrue($result);
    }

    public function testDeleteRoomsNotFound()
    {
        // Mock the behavior of isRoomIdExists method to return false
        $this->roomsModel->method('isRoomIdExists')->willReturn(false);

        $result = $this->roomsService->deleteRooms(1);

        $this->assertEquals("Room not found.", $result);
    }
}
