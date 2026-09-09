<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$productService = new ProductService();

$products = $productService->getAllProducts();

?>

<!DOCTYPE html>
<html lang="sr">

<head>

    <meta charset="UTF-8">

    <title>TechShop - Admin Panel</title>

</head>

<body>

    <h1>TechShop - Admin Panel</h1>

    <p>
        Dobrodošao, <?php echo htmlspecialchars($_SESSION["username"]); ?>!
    </p>

    <hr>

    <h2>Proizvodi</h2>

    <a href="dodaj_proizvod.php">
        + Dodaj novi proizvod
    </a>

    <br><br>

    <a href="porudzbine.php">
        Pregled porudžbina
    </a>

    <br><br>

    <table border="1" cellpadding="10">

        <tr>

            <th>ID</th>
            <th>Naziv</th>
            <th>Kategorija</th>
            <th>Cena</th>
            <th>Akcije</th>

        </tr>

        <?php foreach ($products as $product): ?>

            <tr>

                <td>
                    <?php echo $product["id"]; ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($product["name"]); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($product["category_name"] ?? "Bez kategorije"); ?>
                </td>

                <td>
                    <?php echo number_format($product["price"], 2, ",", "."); ?> RSD
                </td>

                <td>

                    <a href="izmeni_proizvod.php?id=<?php echo $product["id"]; ?>">
                        Izmeni
                    </a>

                    |

                    <a href="obrisi_proizvod.php?id=<?php echo $product["id"]; ?>"
                        onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj proizvod?');">
                        Obriši
                    </a>

                </td>

            </tr>

        <?php endforeach; ?>

    </table>

    <br>

    <a href="../logout.php">
        Odjavi se
    </a>

</body>

</html>