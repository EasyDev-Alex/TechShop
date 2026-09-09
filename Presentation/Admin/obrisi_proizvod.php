<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";


if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "admin"
) {
    header("Location: ../login.php");
    exit;
}


if (
    $_SERVER["REQUEST_METHOD"] !== "POST" ||
    !isset($_POST["id"])
) {
    header("Location: dashboard.php");
    exit;
}


$id = (int) $_POST["id"];


if ($id <= 0) {
    header("Location: dashboard.php");
    exit;
}


$productService = new ProductService();

$productService->deleteProduct($id);


header("Location: dashboard.php");

exit;

?>