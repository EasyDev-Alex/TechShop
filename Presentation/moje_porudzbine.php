<?php

session_start();

require_once __DIR__ . "/../business/OrderService.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$orderService = new OrderService();

$orders = $orderService->getOrdersByUserId(
    $_SESSION["user_id"]
);

?>

<!DOCTYPE html>
<html lang="sr">

<head>

    <meta charset="UTF-8">

    <title>TechShop - Moje porudžbine</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #222;
            color: white;
            padding: 20px;
        }

        header h1 {
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
        }

        .navigation {
            margin-bottom: 25px;
        }

        .navigation a {
            margin-right: 15px;
        }

        .order {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
            margin-bottom: 15px;
        }

        .order-number {
            font-size: 20px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
        }

        .empty {
            background-color: white;
            padding: 30px;
            text-align: center;
        }

    </style>

</head>

<body>

<header>

    <h1>TechShop</h1>

</header>

<div class="container">

    <div class="navigation">

        <a href="proizvodi.php">
            Proizvodi
        </a>

        <a href="korpa.php">
            Korpa
        </a>

        <a href="moje_porudzbine.php">
            Moje porudžbine
        </a>

        <a href="logout.php">
            Odjavi se
        </a>

    </div>

    <h2>
        Moje porudžbine
    </h2>

    <?php if (empty($orders)): ?>

        <div class="empty">

            <h3>Nemate nijednu porudžbinu.</h3>

            <p>
                Kada izvršite kupovinu, ona će se pojaviti ovde.
            </p>

            <a href="proizvodi.php">
                Pogledaj proizvode
            </a>

        </div>

    <?php else: ?>

        <?php foreach ($orders as $order): ?>

            <?php

            $items = $orderService->getOrderItems(
                $order["id"]
            );

            ?>

            <div class="order">

                <div class="order-header">

                    <div class="order-number">

                        Porudžbina
                        #<?php echo $order["id"]; ?>

                    </div>

                    <div>

                        <?php
                        echo date(
                            "d.m.Y. H:i",
                            strtotime($order["order_date"])
                        );
                        ?>

                    </div>

                </div>

                <table>

                    <tr>

                        <th>Proizvod</th>

                        <th>Cena</th>

                        <th>Količina</th>

                        <th>Ukupno</th>

                    </tr>

                    <?php foreach ($items as $item): ?>

                        <tr>

                            <td>

                                <?php
                                echo htmlspecialchars(
                                    $item["product_name"]
                                    ?? "Obrisan proizvod"
                                );
                                ?>

                            </td>

                            <td>

                                <?php
                                echo number_format(
                                    $item["price"],
                                    2,
                                    ",",
                                    "."
                                );
                                ?>

                                RSD

                            </td>

                            <td>

                                <?php
                                echo $item["quantity"];
                                ?>

                            </td>

                            <td>

                                <?php

                                $subtotal =
                                    $item["price"]
                                    * $item["quantity"];

                                echo number_format(
                                    $subtotal,
                                    2,
                                    ",",
                                    "."
                                );

                                ?>

                                RSD

                            </td>

                        </tr>

                    <?php endforeach; ?>

                </table>

                <div class="total">

                    Ukupno:

                    <?php
                    echo number_format(
                        $order["total_price"],
                        2,
                        ",",
                        "."
                    );
                    ?>

                    RSD

                </div>

            </div>

        <?php endforeach; ?>

    <?php endif; ?>

</div>

</body>

</html>