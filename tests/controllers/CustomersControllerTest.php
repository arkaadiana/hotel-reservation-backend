<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/controllers/CustomersControllerTest.php
use PHPUnit\Framework\TestCase;

require_once 'controllers/CustomersController.php';

class CustomersControllerTest extends TestCase
{
    private $customersService;
    private $customersController;
    private $conn;

    protected function setUp(): void
    {
        // Create a mock for the CustomersService class
        $this->customersService = $this->createMock(CustomersService::class);

        // Create a mock for the connection
        $this->conn = $this->createMock(PDO::class);

        // Mock the prepare method to return a statement mock
        $stmtMock = $this->createMock(PDOStatement::class);
        $this->conn->method('prepare')->willReturn($stmtMock);

        // Initialize the CustomersController
        $this->customersController = new CustomersController($this->conn);

        // Inject the mock service into the controller using reflection
        $reflection = new ReflectionClass($this->customersController);
        $property = $reflection->getProperty('customersService');
        $property->setAccessible(true);
        $property->setValue($this->customersController, $this->customersService);
    }

    public function testReadCustomers()
    {
        // Prepare a mock statement
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturnOnConsecutiveCalls(
            ['customer_id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'phone_number' => '1234567890'],
            false
        );

        // Mock the fetchAllCustomers method to return the mock statement
        $this->customersService->method('fetchAllCustomers')->willReturn([
            "records" => [
                [
                    "customer_id" => 1,
                    "name" => "John Doe",
                    "email" => "john@example.com",
                    "phone_number" => "1234567890"
                ]
            ]
        ]);

        $result = $this->customersController->readCustomers();

        $expected = json_encode([
            "records" => [
                [
                    "customer_id" => 1,
                    "name" => "John Doe",
                    "email" => "john@example.com",
                    "phone_number" => "1234567890"
                ]
            ]
        ]);

        $this->assertEquals($expected, $result);
    }
}
