<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_POST["product_id"])) {
    header("Location: proizvodi.php");
    exit;
}

$productId = (int) $_POST["product_id"];

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

if (isset($_SESSION["cart"][$productId])) {

    $_SESSION["cart"][$productId]++;

} else {

    $_SESSION["cart"][$productId] = 1;

}

header("Location: proizvodi.php");

exit;

?>