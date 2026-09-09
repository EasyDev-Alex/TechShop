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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <title>TechShop - Admin panel</title>

</head>


<body class="bg-light">


<nav class="navbar navbar-dark bg-dark navbar-expand-lg">

    <div class="container">


        <a
            class="navbar-brand fw-bold"
            href="dashboard.php"
        >
            🛠️ TechShop Admin
        </a>


        <div class="navbar-nav ms-auto">


            <a
                class="nav-link active"
                href="dashboard.php"
            >
                Proizvodi
            </a>


            <a
                class="nav-link"
                href="porudzbine.php"
            >
                Porudžbine
            </a>


            <a
                class="nav-link"
                href="../proizvodi.php"
            >
                Prodavnica
            </a>


            <a
                class="nav-link"
                href="../logout.php"
            >
                Odjavi se
            </a>


        </div>


    </div>

</nav>


<div class="container py-5">


    <div
        class="d-flex justify-content-between align-items-center mb-4"
    >


        <div>

            <h1 class="h2 mb-1">

                Upravljanje proizvodima

            </h1>


            <p class="text-muted mb-0">

                Dodavanje, izmena i brisanje proizvoda.

            </p>

        </div>


        <a
            href="dodaj_proizvod.php"
            class="btn btn-success"
        >
            + Dodaj proizvod
        </a>


    </div>


    <?php if (empty($products)): ?>


        <div class="card shadow-sm">

            <div class="card-body text-center p-5">


                <h3>
                    Nema proizvoda
                </h3>


                <p class="text-muted">

                    Trenutno nema proizvoda u prodavnici.

                </p>


                <a
                    href="dodaj_proizvod.php"
                    class="btn btn-dark"
                >
                    Dodaj prvi proizvod
                </a>


            </div>

        </div>


    <?php else: ?>


        <div class="card shadow-sm">


            <div class="card-body p-0">


                <div class="table-responsive">


                    <table
                        class="table table-hover align-middle mb-0"
                    >


                        <thead class="table-dark">


                            <tr>


                                <th>
                                    ID
                                </th>


                                <th>
                                    Proizvod
                                </th>


                                <th>
                                    Kategorija
                                </th>


                                <th>
                                    Cena
                                </th>


                                <th>
                                    Slika
                                </th>


                                <th>
                                    Akcije
                                </th>


                            </tr>


                        </thead>


                        <tbody>


                            <?php foreach ($products as $product): ?>


                                <tr>


                                    <td>

                                        <?php
                                        echo $product["id"];
                                        ?>

                                    </td>


                                    <td class="fw-semibold">

                                        <?php

                                        echo htmlspecialchars(
                                            $product["name"]
                                        );

                                        ?>

                                    </td>


                                    <td>


                                        <?php

                                        echo htmlspecialchars(
                                            $product["category_name"]
                                            ?? "Bez kategorije"
                                        );

                                        ?>


                                    </td>


                                    <td class="fw-semibold">


                                        <?php

                                        echo number_format(
                                            $product["price"],
                                            2,
                                            ",",
                                            "."
                                        );

                                        ?>

                                        RSD


                                    </td>


                                    <td>


                                        <?php if (!empty($product["image"])): ?>


                                            <img
                                                src="../../assets/images/<?php echo htmlspecialchars($product["image"]); ?>"
                                                alt="<?php echo htmlspecialchars($product["name"]); ?>"
                                                style="width: 60px; height: 60px; object-fit: contain;"
                                            >


                                        <?php else: ?>


                                            <span class="text-muted">

                                                Nema slike

                                            </span>


                                        <?php endif; ?>


                                    </td>


                                    <td>


                                        <div class="d-flex gap-2">


                                            <a
                                                href="izmeni_proizvod.php?id=<?php echo $product["id"]; ?>"
                                                class="btn btn-outline-primary btn-sm"
                                            >
                                                Izmeni
                                            </a>


                                            <a
                                                href="obrisi_proizvod.php?id=<?php echo $product["id"]; ?>"
                                                class="btn btn-outline-danger btn-sm"
                                                onclick="return confirm('Da li ste sigurni da želite da obrišete ovaj proizvod?');"
                                            >
                                                Obriši
                                            </a>


                                        </div>


                                    </td>


                                </tr>


                            <?php endforeach; ?>


                        </tbody>


                    </table>


                </div>


            </div>


        </div>


    <?php endif; ?>


</div>


</body>

</html>