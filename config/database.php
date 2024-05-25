<?php
class Database
{
    private $host;
    private $dbname;
    private $username;
    private $password;
    private $conn;

    public function __construct()
    {
        if (!file_exists(dirname(__DIR__) . '/.env'))
        {
            die('.env file not found!');
        }
        $line = file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($line as $line)
        {
            if(strpos(trim($line), '#') === 0) continue; // Skip comments
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_ENV))
            {
                $_ENV[$name] = $value;
            }
        }

        $this->host = $_ENV['DB_HOST'];
        $this->dbname = $_ENV['DB_NAME'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function getConnection()
    {
        $this->conn = null;

        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->username, $this->password);
        }

        catch (PDOException $excepetion)
        {
            echo "Connection error: " . $excepetion->getMessage();
        }

        return $this->conn;
    }

    public function __destruct()
    {
        $this->conn = null; // Close the PDO connection
    }
}