<?php

require_once __DIR__ . "/Database.php";

class OrderRepository
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function createOrder($userId, $totalPrice, $items)
    {
        try {

            $this->connection->beginTransaction();

            // Kreiranje porudžbine
            $sql = "INSERT INTO orders (user_id, total_price)
                    VALUES (:user_id, :total_price)";

            $statement = $this->connection->prepare($sql);

            $statement->execute([
                ":user_id" => $userId,
                ":total_price" => $totalPrice
            ]);

            $orderId = $this->connection->lastInsertId();

            // Dodavanje proizvoda u order_items
            $sqlItem = "INSERT INTO order_items
                        (order_id, product_id, quantity, price)
                        VALUES
                        (:order_id, :product_id, :quantity, :price)";

            $statementItem = $this->connection->prepare($sqlItem);

            foreach ($items as $item) {

                $statementItem->execute([
                    ":order_id" => $orderId,
                    ":product_id" => $item["product"]["id"],
                    ":quantity" => $item["quantity"],
                    ":price" => $item["product"]["price"]
                ]);

            }

            $this->connection->commit();

            return $orderId;

        } catch (Exception $e) {

            $this->connection->rollBack();

            throw $e;
        }
    }

    public function getOrdersByUserId($userId)
    {
        $sql = "SELECT *
            FROM orders
            WHERE user_id = :user_id
            ORDER BY order_date DESC";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":user_id" => $userId
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItems($orderId)
    {
        $sql = "SELECT
                order_items.*,
                products.name AS product_name
            FROM order_items
            LEFT JOIN products
                ON order_items.product_id = products.id
            WHERE order_items.order_id = :order_id";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":order_id" => $orderId
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrders()
    {
        $sql = "SELECT
                orders.*,
                users.username,
                users.email
            FROM orders
            INNER JOIN users
                ON orders.user_id = users.id
            ORDER BY orders.order_date DESC";

        $statement = $this->connection->prepare($sql);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>