<?php

require_once __DIR__ . "/../config/config.php";

class Database
{
    private $connection;

    public function __construct()
    {
        try {

            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";

            $this->connection = new PDO(
                $dsn,
                DB_USER,
                DB_PASSWORD
            );

            $this->connection->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

        } catch (PDOException $e) {

            die("Greška pri povezivanju sa bazom: " . $e->getMessage());

        }
    }


    public function getConnection()
    {
        return $this->connection;
    }
}

?>