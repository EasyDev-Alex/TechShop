<?php

session_start();

require_once __DIR__ . "/../business/ProductService.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$productService = new ProductService();

$cart = $_SESSION["cart"] ?? [];

$cartProducts = [];

$totalPrice = 0;

foreach ($cart as $productId => $quantity) {

    $product = $productService->getProductById($productId);

    if ($product !== false) {

        $subtotal = $product["price"] * $quantity;

        $totalPrice += $subtotal;

        $cartProducts[] = [
            "product" => $product,
            "quantity" => $quantity,
            "subtotal" => $subtotal
        ];
    }
}

?>

<!DOCTYPE html>
<html lang="sr">

<head>

    <meta charset="UTF-8">

    <title>TechShop - Korpa</title>

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

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th,
        td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .total {
            margin-top: 20px;
            padding: 20px;
            background-color: white;
            text-align: right;
            font-size: 24px;
            font-weight: bold;
        }

        .empty {
            background-color: white;
            padding: 30px;
            text-align: center;
        }

        input[type="number"] {
            width: 60px;
            padding: 5px;
        }

        button {
            background-color: #222;
            color: white;
            border: none;
            padding: 7px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #444;
        }

        .remove {
            background-color: #b00020;
        }

        .navigation {
            margin-bottom: 25px;
        }

        .navigation a {
            margin-right: 15px;
        }

    </style>

</head>

<body>

<header>

    <h1>TechShop - Korpa</h1>

</header>

<div class="container">

    <div class="navigation">

        <a href="proizvodi.php">
            ← Nastavi kupovinu
        </a>

        <a href="logout.php">
            Odjavi se
        </a>

    </div>

    <h2>
        Korpa korisnika:
        <?php echo htmlspecialchars($_SESSION["username"]); ?>
    </h2>

    <?php if (empty($cartProducts)): ?>

        <div class="empty">

            <h3>Korpa je prazna.</h3>

            <p>
                Dodajte neki proizvod da biste nastavili kupovinu.
            </p>

            <a href="proizvodi.php">
                Pogledaj proizvode
            </a>

        </div>

    <?php else: ?>

        <table>

            <tr>

                <th>Proizvod</th>

                <th>Cena</th>

                <th>Količina</th>

                <th>Ukupno</th>

                <th>Akcija</th>

            </tr>

            <?php foreach ($cartProducts as $item): ?>

                <tr>

                    <td>

                        <?php
                        echo htmlspecialchars(
                            $item["product"]["name"]
                        );
                        ?>

                    </td>

                    <td>

                        <?php
                        echo number_format(
                            $item["product"]["price"],
                            2,
                            ",",
                            "."
                        );
                        ?>

                        RSD

                    </td>

                    <td>

                        <form
                            method="POST"
                            action="izmeni_kolicinu.php"
                        >

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?php
                                echo $item["product"]["id"];
                                ?>"
                            >

                            <input
                                type="number"
                                name="quantity"
                                value="<?php
                                echo $item["quantity"];
                                ?>"
                                min="1"
                                required
                            >

                            <button type="submit">
                                Izmeni
                            </button>

                        </form>

                    </td>

                    <td>

                        <?php
                        echo number_format(
                            $item["subtotal"],
                            2,
                            ",",
                            "."
                        );
                        ?>

                        RSD

                    </td>

                    <td>

                        <form
                            method="POST"
                            action="ukloni_iz_korpe.php"
                        >

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?php
                                echo $item["product"]["id"];
                                ?>"
                            >

                            <button
                                type="submit"
                                class="remove"
                            >
                                Ukloni
                            </button>

                        </form>

                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

        <div class="total">

            Ukupna cena:

            <?php
            echo number_format(
                $totalPrice,
                2,
                ",",
                "."
            );
            ?>

            RSD

        </div>

        <br>

        <button
            onclick="window.location.href='porudzbina.php'"
        >
            Nastavi na poručivanje
        </button>

    <?php endif; ?>

</div>

</body>

</html>