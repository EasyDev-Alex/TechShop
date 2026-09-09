<?php

session_start();

require_once __DIR__ . "/../business/OrderService.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$cart = $_SESSION["cart"] ?? [];

if (empty($cart)) {
    header("Location: korpa.php");
    exit;
}

$orderService = new OrderService();

try {

    $orderId = $orderService->createOrder(
        $_SESSION["user_id"],
        $cart
    );

    // Pražnjenje korpe nakon uspešne kupovine
    $_SESSION["cart"] = [];

} catch (Exception $e) {

    die(
        "Došlo je do greške prilikom kreiranja porudžbine."
    );
}

?>

<!DOCTYPE html>
<html lang="sr">

<head>

    <meta charset="UTF-8">

    <title>TechShop - Porudžbina</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 100px auto;
            background-color: white;
            padding: 40px;
            text-align: center;
            border-radius: 10px;
        }

        h1 {
            color: #222;
        }

        .order-number {
            font-size: 24px;
            font-weight: bold;
            margin: 25px;
        }

        a {
            display: inline-block;
            margin: 10px;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Porudžbina je uspešno kreirana!</h1>

    <p>
        Hvala vam na kupovini,
        <?php echo htmlspecialchars($_SESSION["username"]); ?>!
    </p>

    <div class="order-number">

        Broj porudžbine:
        #<?php echo $orderId; ?>

    </div>

    <p>
        Vaša porudžbina je uspešno sačuvana u sistemu.
    </p>

    <a href="proizvodi.php">
        Nastavi kupovinu
    </a>

    <a href="logout.php">
        Odjavi se
    </a>

</div>

</body>

</html>