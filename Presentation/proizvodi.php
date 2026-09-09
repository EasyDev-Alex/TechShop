<?php

session_start();

require_once __DIR__ . "/../business/ProductService.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$productService = new ProductService();

$products = $productService->getAllProducts();

?>

<!DOCTYPE html>
<html lang="sr">

<head>

    <meta charset="UTF-8">

    <title>TechShop - Proizvodi</title>

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
            max-width: 1200px;
            margin: 30px auto;
        }

        .welcome {
            margin-bottom: 25px;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .product {
            background-color: white;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        .product h3 {
            margin-top: 0;
        }

        .category {
            color: #777;
            font-size: 14px;
        }

        .description {
            min-height: 50px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
        }

        button {
            background-color: #222;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #444;
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

        <h1>TechShop</h1>

    </header>

    <div class="container">

        <div class="welcome">

            <h2>
                Dobrodošao,
                <?php echo htmlspecialchars($_SESSION["username"]); ?>!
            </h2>

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

        </div>

        <h2>Naši proizvodi</h2>

        <div class="products">

            <?php foreach ($products as $product): ?>

                <div class="product">

                    <h3>
                        <?php echo htmlspecialchars($product["name"]); ?>
                    </h3>

                    <p class="category">

                        Kategorija:
                        <?php
                        echo htmlspecialchars(
                            $product["category_name"] ?? "Bez kategorije"
                        );
                        ?>

                    </p>

                    <p class="description">

                        <?php
                        echo htmlspecialchars($product["description"]);
                        ?>

                    </p>

                    <p class="price">

                        <?php
                        echo number_format(
                            $product["price"],
                            2,
                            ",",
                            "."
                        );
                        ?>
                        RSD

                    </p>

                    <form method="POST" action="dodaj_u_korpu.php">

                        <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">

                        <button type="submit">
                            Dodaj u korpu
                        </button>

                    </form>

                </div>

            <?php endforeach; ?>

        </div>

    </div>

</body>

</html>