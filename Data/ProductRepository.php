<?php

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/Product.php";

class ProductRepository
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function getAllProducts()
    {
        $sql = "SELECT products.*, categories.name AS category_name
                FROM products
                LEFT JOIN categories
                ON products.category_id = categories.id
                ORDER BY products.id DESC";

        $statement = $this->connection->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":id" => $id
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct(Product $product)
    {
        $sql = "INSERT INTO products
                (name, description, price, category_id, image)
                VALUES
                (:name, :description, :price, :category_id, :image)";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":name" => $product->getName(),
            ":description" => $product->getDescription(),
            ":price" => $product->getPrice(),
            ":category_id" => $product->getCategoryId(),
            ":image" => $product->getImage()
        ]);
    }

    public function updateProduct($id, Product $product)
    {
        $sql = "UPDATE products
                SET name = :name,
                    description = :description,
                    price = :price,
                    category_id = :category_id,
                    image = :image
                WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":name" => $product->getName(),
            ":description" => $product->getDescription(),
            ":price" => $product->getPrice(),
            ":category_id" => $product->getCategoryId(),
            ":image" => $product->getImage(),
            ":id" => $id
        ]);
    }

    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = :id";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":id" => $id
        ]);
    }
}

?>