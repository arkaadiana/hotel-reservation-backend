<?php
// vendor/bin/phpunit --bootstrap vendor/autoload.php tests/services/CustomersServiceTest.php
use PHPUnit\Framework\TestCase;

require_once 'services/CustomersService.php';

class CustomersServiceTest extends TestCase
{
    private $mockCustomersModel;
    private $customersService;

    protected function setUp(): void
    {
        // Create a mock for the CustomersModel class
        $this->mockCustomersModel = $this->createMock(CustomersModel::class);

        // Initialize the CustomersService with the mocked CustomersModel
        $this->customersService = new CustomersService($this->mockCustomersModel);
    }

    public function testFetchAllCustomers()
    {
        // Prepare a mock statement
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->method('fetch')->willReturnOnConsecutiveCalls(
            ['customer_id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'phone_number' => '123456789'],
            ['customer_id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone_number' => '987654321'],
            false
        );

        // Expect the readAllCustomers method to be called and return the mock statement
        $this->mockCustomersModel->method('readAllCustomers')->willReturn($stmt);

        // Call the method and assert the result
        $result = $this->customersService->fetchAllCustomers();

        $expected = [
            "records" => [
                ["customer_id" => 1, "name" => "John Doe", "email" => "john@example.com", "phone_number" => "123456789"],
                ["customer_id" => 2, "name" => "Jane Smith", "email" => "jane@example.com", "phone_number" => "987654321"]
            ]
        ];

        $this->assertEquals($expected, $result);
    }

    public function testAddCustomers()
    {
        $data = [
            'name' => 'New Customer',
            'email' => 'new@example.com',
            'phone_number' => '555555555'
        ];

        // Expect the insertCustomers method to be called and return true
        $this->mockCustomersModel->method('insertCustomers')->willReturn(true);

        // Call the method and assert the result
        $result = $this->customersService->addCustomers($data);

        $this->assertTrue($result);
    }

    public function testUpdateCustomers()
    {
        $customerId = 1;
        $data = ['name' => 'Updated Name'];

        // Mock the behavior of isCustomerIdExists and updateCustomers methods
        $this->mockCustomersModel->method('isCustomerIdExists')->willReturn(true);
        $this->mockCustomersModel->method('updateCustomers')->willReturn(1);

        // Call the method and assert the result
        $result = $this->customersService->updateCustomers($customerId, $data);

        $this->assertTrue($result);
    }

    public function testUpdateCustomersNotFound()
    {
        $customerId = 1;
        $data = ['name' => 'Updated Name'];

        // Mock the behavior of isCustomerIdExists method to return false
        $this->mockCustomersModel->method('isCustomerIdExists')->willReturn(false);

        // Call the method and assert the result
        $result = $this->customersService->updateCustomers($customerId, $data);

        $this->assertEquals("Customer not found.", $result);
    }

    public function testDeleteCustomers()
    {
        $customerId = 1;

        // Mock the behavior of isCustomerIdExists and removeCustomers methods
        $this->mockCustomersModel->method('isCustomerIdExists')->willReturn(true);
        $this->mockCustomersModel->method('removeCustomers')->willReturn(1);

        // Call the method and assert the result
        $result = $this->customersService->deleteCustomers($customerId);

        $this->assertTrue($result);
    }

    public function testDeleteCustomersNotFound()
    {
        $customerId = 1;

        // Mock the behavior of isCustomerIdExists method to return false
        $this->mockCustomersModel->method('isCustomerIdExists')->willReturn(false);

        // Call the method and assert the result
        $result = $this->customersService->deleteCustomers($customerId);

        $this->assertEquals("Customer not found.", $result);
    }
}
