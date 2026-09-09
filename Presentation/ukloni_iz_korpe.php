<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST["product_id"])) {
    header("Location: korpa.php");
    exit;
}

$productId = (int) $_POST["product_id"];

if (isset($_SESSION["cart"][$productId])) {

    unset($_SESSION["cart"][$productId]);

}

header("Location: korpa.php");

exit;

?>