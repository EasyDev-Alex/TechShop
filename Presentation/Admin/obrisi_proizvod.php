<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];

$productService = new ProductService();

$productService->deleteProduct($id);

header("Location: dashboard.php");
exit;

?>