<?php

require_once __DIR__ . "/../data/OrderRepository.php";
require_once __DIR__ . "/ProductService.php";

class OrderService
{
    private $orderRepository;
    private $productService;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
        $this->productService = new ProductService();
    }

    public function createOrder($userId, $cart)
    {
        if (empty($cart)) {
            return false;
        }

        $items = [];

        $totalPrice = 0;

        foreach ($cart as $productId => $quantity) {

            $product = $this->productService
                ->getProductById($productId);

            if ($product === false) {
                continue;
            }

            $quantity = (int) $quantity;

            if ($quantity < 1 || $quantity > 100) {
                continue;
            }

            $subtotal = $product["price"] * $quantity;

            $totalPrice += $subtotal;

            $items[] = [
                "product" => $product,
                "quantity" => $quantity,
                "subtotal" => $subtotal
            ];
        }

        if (empty($items)) {
            return false;
        }

        return $this->orderRepository->createOrder(
            $userId,
            $totalPrice,
            $items
        );
    }

    public function getOrdersByUserId($userId)
    {
        return $this->orderRepository->getOrdersByUserId($userId);
    }

    public function getOrderItems($orderId)
    {
        return $this->orderRepository->getOrderItems($orderId);
    }

    public function getAllOrders()
    {
        return $this->orderRepository->getAllOrders();
    }
}

?>