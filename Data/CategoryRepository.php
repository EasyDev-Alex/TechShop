<?php

require_once __DIR__ . "/Database.php";

class CategoryRepository
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function getAllCategories()
    {
        $sql = "SELECT *
                FROM categories
                ORDER BY name";

        $statement = $this->connection->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>