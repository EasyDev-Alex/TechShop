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

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>TechShop - Proizvodi</title>



</head>

<body>

    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">

        <div class="container">

            <a class="navbar-brand fw-bold" href="proizvodi.php">
                TechShop
            </a>

            <div class="navbar-nav ms-auto">

                <a class="nav-link active" href="proizvodi.php">
                    Proizvodi
                </a>

                <a class="nav-link" href="korpa.php">
                    🛒 Korpa
                </a>

                <a class="nav-link" href="moje_porudzbine.php">
                    Moje porudžbine
                </a>

                <a class="nav-link" href="logout.php">
                    Odjavi se
                </a>

            </div>

        </div>

    </nav>

    <div class="container">

        <div class="py-4">

            <h2 class="mb-1">
                Dobrodošao,
                <?php echo htmlspecialchars($_SESSION["username"]); ?>!
            </h2>

            <p class="text-muted">
                Pogledaj našu ponudu računara, komponenti i elektronike.
            </p>

        </div>

        <h2 class="mb-4">
            Naši proizvodi
        </h2>

        <div class="row g-4">

    <?php foreach ($products as $product): ?>

        <div class="col-md-6 col-lg-4">

            <div class="card h-100 shadow-sm">

                <?php if (!empty($product["image"])): ?>

                    <img
                        src="../assets/images/<?php echo htmlspecialchars($product["image"]); ?>"
                        class="card-img-top p-3"
                        style="height: 220px; object-fit: contain;"
                        alt="<?php echo htmlspecialchars($product["name"]); ?>"
                    >

                <?php else: ?>

                    <div
                        class="d-flex align-items-center justify-content-center bg-light"
                        style="height: 220px;"
                    >
                        <span class="text-muted">
                            Nema slike
                        </span>
                    </div>

                <?php endif; ?>


                <div class="card-body d-flex flex-column">

                    <h5 class="card-title">

                        <?php
                        echo htmlspecialchars(
                            $product["name"]
                        );
                        ?>

                    </h5>


                    <p class="text-muted small mb-2">

                        Kategorija:

                        <?php
                        echo htmlspecialchars(
                            $product["category_name"]
                            ?? "Bez kategorije"
                        );
                        ?>

                    </p>


                    <p class="card-text">

                        <?php
                        echo htmlspecialchars(
                            $product["description"]
                        );
                        ?>

                    </p>


                    <div class="mt-auto">

                        <p class="fs-4 fw-bold mb-3">

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


                        <form
                            method="POST"
                            action="dodaj_u_korpu.php"
                        >

                            <input
                                type="hidden"
                                name="product_id"
                                value="<?php echo $product["id"]; ?>"
                            >


                            <button
                                type="submit"
                                class="btn btn-dark w-100"
                            >
                                🛒 Dodaj u korpu
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    <?php endforeach; ?>

</div>

    </div>

</body>

</html>