<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST["product_id"]) || !isset($_POST["quantity"])) {
    header("Location: korpa.php");
    exit;
}

$productId = (int) $_POST["product_id"];

$quantity = (int) $_POST["quantity"];

if ($quantity < 1) {
    $quantity = 1;
}

if ($quantity > 100) {
    $quantity = 100;
}

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (isset($_SESSION["cart"][$productId])) {

    $_SESSION["cart"][$productId] = $quantity;

}

header("Location: korpa.php");

exit;

?>