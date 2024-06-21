<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/models/CustomersModelTest.php
use PHPUnit\Framework\TestCase;

require_once 'models/CustomersModel.php';

class CustomersModelTest extends TestCase
{
    private $db;
    private $customersModel;

    protected function setUp(): void
    {
        // Create a mock for the PDO class
        $this->db = $this->createMock(PDO::class);

        // Initialize the CustomersModel with the mocked PDO
        $this->customersModel = new CustomersModel($this->db);
    }

    public function testIsCustomerIdExists()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('fetch')->willReturn(['customer_id' => 1]);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertTrue($this->customersModel->isCustomerIdExists(1));
    }

    public function testReadAllCustomers()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertInstanceOf(PDOStatement::class, $this->customersModel->readAllCustomers());
    }

    public function testInsertCustomers()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789'
        ];

        $this->assertTrue($this->customersModel->insertCustomers($data));
    }

    public function testInsertCustomersDuplicateEmail()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->will($this->throwException(new PDOException("Duplicate entry 'john.doe@example.com' for key 'email'", '23000')));

        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789'
        ];

        $this->assertEquals("Duplicate email detected", $this->customersModel->insertCustomers($data));
    }

    public function testInsertCustomersDuplicatePhoneNumber()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->will($this->throwException(new PDOException("Duplicate entry '123456789' for key 'phone_number'", '23000')));

        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789'
        ];

        $this->assertEquals("Duplicate phone number detected", $this->customersModel->insertCustomers($data));
    }

    public function testUpdateCustomers()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789'
        ];

        $this->assertEquals(1, $this->customersModel->updateCustomers(1, $data));
    }

    public function testUpdateCustomersDuplicateEmail()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->will($this->throwException(new PDOException("Duplicate entry 'john.doe@example.com' for key 'email'", '23000')));

        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789'
        ];

        $this->assertEquals("Duplicate email detected.", $this->customersModel->updateCustomers(1, $data));
    }

    public function testUpdateCustomersDuplicatePhoneNumber()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->will($this->throwException(new PDOException("Duplicate entry '123456789' for key 'phone_number'", '23000')));

        $this->db->method('prepare')->willReturn($stmt);

        $data = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'phone_number' => '123456789'
        ];

        $this->assertEquals("Duplicate phone number detected.", $this->customersModel->updateCustomers(1, $data));
    }

    public function testRemoveCustomers()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->willReturn(true);
        $stmt->method('rowCount')->willReturn(1);

        // Expect the prepare method to be called and return the mock statement
        $this->db->method('prepare')->willReturn($stmt);

        $this->assertEquals(1, $this->customersModel->removeCustomers(1));
    }

    public function testRemoveCustomersForeignKeyConstraint()
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('execute')->will($this->throwException(new PDOException("Cannot delete or update a parent row: a foreign key constraint fails", '23000')));

        $this->db->method('prepare')->willReturn($stmt);

        $this->assertEquals("Foreign key constraint violation: Cannot delete customer because of existing related records.", $this->customersModel->removeCustomers(1));
    }
}
