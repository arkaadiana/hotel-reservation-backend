<?php
include_once 'models/TransactionsModel.php';
include_once 'services/TransactionsService.php';

class TransactionsController
{
    private $transactionsService;

    public function __construct($conn)
    {
        $transactionsModel = new TransactionsModel($conn);
        $this->transactionsService = new TransactionsService($transactionsModel);
    }

    public function readTransactions()
    {
        $transactions = $this->transactionsService->fetchAllTransactions();
        return json_encode($transactions);
    }

    public function addTransactions()
    {
        $data = json_decode(file_get_contents("php://input"), true);

        $errorMessages = [];

        if (empty($data['customer_id'])) {
            $errorMessages[] = "Customer ID is required.";
        }

        if (empty($data['total_price'])) {
            $errorMessages[] = "Price is required.";
        } elseif (!is_numeric($data['total_price'])) {
            $errorMessages[] = "Price must be a number.";
        }

        if (!empty($errorMessages)) {
            echo json_encode(array("message" => $errorMessages));
            return;
        }

        $result = $this->transactionsService->addTransactions($data);
        if ($result === true) {
            echo json_encode(array("message" => "Transaction added successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }
    
    public function updateTransactions() 
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['transaction_id']) || empty($data['transaction_id'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }
    
        $id = $data['transaction_id'];
        $result = $this->transactionsService->updateTransactions($id, $data);
        if ($result === true) {
            echo json_encode(array("message" => "Transaction updated successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }
    
    public function deleteTransactions() 
    {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['transaction_id']) || empty($data['transaction_id'])) {
            echo json_encode(array("message" => "ID is required."));
            return;
        }

        $id = $data['transaction_id'];
        $result = $this->transactionsService->deleteTransactions($id);
        if ($result === true) {
            echo json_encode(array("message" => "Transaction deleted successfully."));
        } else {
            echo json_encode(array("message" => $result));
        }
        exit();
    }

}