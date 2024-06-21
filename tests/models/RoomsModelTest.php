<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/models/RoomsModelTest.php
use PHPUnit\Framework\TestCase;

require_once 'models/RoomsModel.php';

class RoomsModelTest extends TestCase
{
    private $db;
    private $roomsModel;

    protected function setUp(): void
    {
        // Create a mock for the PDO class
        $this->db = $this->createMock(PDO::class);

        // Initialize the RoomsModel with the mocked PDO
        $this->roomsModel = new RoomsModel($this->db);
    }

    public function testIsRoomIdExists()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetch')->willReturn(['room_id' => 1]);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertTrue($this->roomsModel->isRoomIdExists(1));
    }

    public function testReadAllRooms()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertInstanceOf(PDOStatement::class, $this->roomsModel->readAllRooms());
    }

    public function testInsertRooms()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'room_type' => 'Single',
            'price' => 100
        ];

        $this->assertTrue($this->roomsModel->insertRooms($data));
    }

    public function testUpdateRooms()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'room_type' => 'Double',
            'price' => 150
        ];

        $this->assertEquals(1, $this->roomsModel->updateRooms(1, $data));
    }

    public function testRemoveRooms()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertEquals(1, $this->roomsModel->removeRooms(1));
    }

    public function testRemoveRoomsForeignKeyConstraint()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->will($this->throwException(new PDOException("Cannot delete or update a parent row: a foreign key constraint fails", '23000')));

        $this->db->method('prepare')->willReturn($stmt);

        $this->assertEquals("Foreign key constraint violation: Cannot delete room because of existing related records.", $this->roomsModel->removeRooms(1));
    }
}
