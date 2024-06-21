<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/models/ReservationsModelTest.php
use PHPUnit\Framework\TestCase;

require_once 'models/ReservationsModel.php';

class ReservationsModelTest extends TestCase
{
    private $db;
    private $reservationsModel;

    protected function setUp(): void
    {
        // Create a mock for the PDO class
        $this->db = $this->createMock(PDO::class);

        // Initialize the ReservationsModel with the mocked PDO
        $this->reservationsModel = new ReservationsModel($this->db);
    }

    public function testIsReservationIdExists()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetch')->willReturn(['reservation_id' => 1]);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertTrue($this->reservationsModel->isReservationIdExists(1));
    }

    public function testReadAllReservations()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertInstanceOf(PDOStatement::class, $this->reservationsModel->readAllReservations());
    }

    public function testIsRoomBooked()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetchColumn')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'room_id' => 1,
            'check_in_datetime' => '2023-07-01 12:00:00',
            'check_out_datetime' => '2023-07-05 12:00:00'
        ];

        $this->assertTrue($this->reservationsModel->isRoomBooked($data));
    }

    public function testInsertReservations()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'customer_id' => 1,
            'room_id' => 1,
            'check_in_datetime' => '2023-07-01 12:00:00',
            'check_out_datetime' => '2023-07-05 12:00:00',
            'total_price' => 500
        ];

        $this->assertTrue($this->reservationsModel->insertReservations($data));
    }

    public function testUpdateReservations()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'customer_id' => 2,
            'room_id' => 2,
            'check_in_datetime' => '2023-08-01 12:00:00',
            'check_out_datetime' => '2023-08-05 12:00:00',
            'total_price' => 600
        ];

        $this->assertEquals(1, $this->reservationsModel->updateReservations(1, $data));
    }

    public function testRemoveReservations()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertEquals(1, $this->reservationsModel->removeReservations(1));
    }
}
