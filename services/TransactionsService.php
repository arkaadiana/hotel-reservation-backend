<?php
include_once 'models/TransactionsModel.php';

class TransactionsService
{
    private $transactionsModel;

    public function __construct(TransactionsModel $transactionsmodel)
    {
        $this->transactionsModel = $transactionsmodel;
    }

    public function fetchAllTransactions()
    {
        $stmt = $this->transactionsModel->readAllTransactions();
        $transactions_array = array();
        $transactions_array["records"] = array();
        while ($rows = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($rows);
            $transactions_item = array (
                "transaction_id" => $transaction_id,
                "customer_id" => $customer_id,
                "total_price" => $total_price
            );
            array_push($transactions_array["records"], $transactions_item);
        }
        
        return $transactions_array;
    }

    public function addTransactions($data)
    {
        $stmt = $this->transactionsModel->insertTransactions($data);
        return $stmt;
    }

    public function updateTransactions($id, $data)
    {
        $isTransactionIdExists = $this->transactionsModel->isTransactionIdExists($id);
        if (is_string($isTransactionIdExists)) {
            return $isTransactionIdExists;
        }

        if (!$isTransactionIdExists) {
            return "Transaction not found.";
        }

        $rowCount = $this->transactionsModel->updateTransactions($id, $data);

        if (is_string($rowCount)) {
            return $rowCount;
        } else {
            if ($rowCount > 0) {
                return true;
            } else {
                return "No changes made.";
            }
        }
    }

    public function deleteTransactions($id)
    {
        $isTransactionIdExists = $this->transactionsModel->isTransactionIdExists($id);
        if (is_string($isTransactionIdExists)) {
            return $isTransactionIdExists;
        }

        if (!$isTransactionIdExists) {
            return "Transaction not found.";
        }

        $rowCount = $this->transactionsModel->deleteTransactions($id);

        if (is_string($rowCount)) {
            return $rowCount;
        } else {
            if ($rowCount > 0) {
                return true;
            } else {
                return "No changes made.";
            }
        }
    }
}