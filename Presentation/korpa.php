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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <title>TechShop - Korpa</title>

</head>


<body class="bg-light">


<nav class="navbar navbar-dark bg-dark navbar-expand-lg">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="proizvodi.php"
        >
            TechShop
        </a>


        <div class="navbar-nav ms-auto">

            <a
                class="nav-link"
                href="proizvodi.php"
            >
                Proizvodi
            </a>

            <a
                class="nav-link active"
                href="korpa.php"
            >
                🛒 Korpa
            </a>

            <a
                class="nav-link"
                href="moje_porudzbine.php"
            >
                Moje porudžbine
            </a>

            <a
                class="nav-link"
                href="logout.php"
            >
                Odjavi se
            </a>

        </div>

    </div>

</nav>


<div class="container py-5">


    <div class="mb-4">

        <h1 class="h2">

            🛒 Vaša korpa

        </h1>

        <p class="text-muted">

            Korisnik:
            <?php echo htmlspecialchars($_SESSION["username"]); ?>

        </p>

    </div>


    <?php if (empty($cartProducts)): ?>


        <div class="card shadow-sm">

            <div class="card-body text-center p-5">

                <h3>
                    Vaša korpa je prazna
                </h3>

                <p class="text-muted">

                    Dodajte proizvode da biste nastavili kupovinu.

                </p>

                <a
                    href="proizvodi.php"
                    class="btn btn-dark mt-3"
                >
                    Pogledaj proizvode
                </a>

            </div>

        </div>


    <?php else: ?>


        <div class="card shadow-sm">

            <div class="card-body p-0">


                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>
                                    Proizvod
                                </th>

                                <th>
                                    Cena
                                </th>

                                <th>
                                    Količina
                                </th>

                                <th>
                                    Ukupno
                                </th>

                                <th>
                                    Akcija
                                </th>

                            </tr>

                        </thead>


                        <tbody>


                        <?php foreach ($cartProducts as $item): ?>


                            <tr>


                                <td class="fw-semibold">

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
                                        class="d-flex gap-2"
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
                                            class="form-control"
                                            style="width: 80px;"
                                        >


                                        <button
                                            type="submit"
                                            class="btn btn-outline-dark btn-sm"
                                        >
                                            Izmeni
                                        </button>


                                    </form>


                                </td>


                                <td class="fw-semibold">


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
                                            class="btn btn-outline-danger btn-sm"
                                        >
                                            Ukloni
                                        </button>


                                    </form>


                                </td>


                            </tr>


                        <?php endforeach; ?>


                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <div
            class="card shadow-sm mt-4"
        >

            <div
                class="card-body d-flex justify-content-between align-items-center"
            >

                <h3 class="mb-0">

                    Ukupna cena:

                </h3>


                <h3 class="mb-0 fw-bold">

                    <?php
                    echo number_format(
                        $totalPrice,
                        2,
                        ",",
                        "."
                    );
                    ?>

                    RSD

                </h3>

            </div>

        </div>


        <div class="mt-4 d-flex justify-content-between">


            <a
                href="proizvodi.php"
                class="btn btn-outline-dark"
            >
                ← Nastavi kupovinu
            </a>


            <a
                href="porudzbina.php"
                class="btn btn-success btn-lg"
            >
                Nastavi na poručivanje →
            </a>


        </div>


    <?php endif; ?>


</div>


</body>

</html>