<?php

session_start();

require_once __DIR__ . "/../business/OrderService.php";


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}


// POST = kreiranje nove porudžbine
if ($_SERVER["REQUEST_METHOD"] === "POST") {

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

        if ($orderId === false) {
            header("Location: korpa.php");
            exit;
        }

        // Praznimo korpu
        $_SESSION["cart"] = [];

        // POST → Redirect → GET
        header(
            "Location: porudzbina.php?success=1&order_id=" .
            (int) $orderId
        );

        exit;

    } catch (Exception $e) {

        die(
            "Došlo je do greške prilikom kreiranja porudžbine."
        );
    }
}


// GET = prikaz uspešne porudžbine
if (
    isset($_GET["success"]) &&
    $_GET["success"] === "1" &&
    isset($_GET["order_id"])
) {

    $orderId = (int) $_GET["order_id"];

    if ($orderId <= 0) {
        header("Location: proizvodi.php");
        exit;
    }

    ?>

    <!DOCTYPE html>
    <html lang="sr">

    <head>

        <meta charset="UTF-8">

        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0"
        >

        <title>Porudžbina uspešna - TechShop</title>

        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
        >

    </head>

    <body>

        <nav class="navbar navbar-dark bg-dark">

            <div class="container">

                <a
                    class="navbar-brand"
                    href="proizvodi.php"
                >
                    TechShop
                </a>

                <div class="d-flex gap-2">

                    <a
                        href="proizvodi.php"
                        class="btn btn-outline-light"
                    >
                        Prodavnica
                    </a>

                    <a
                        href="moje_porudzbine.php"
                        class="btn btn-outline-light"
                    >
                        Moje porudžbine
                    </a>

                    <a
                        href="logout.php"
                        class="btn btn-danger"
                    >
                        Odjavi se
                    </a>

                </div>

            </div>

        </nav>


        <div class="container py-5">

            <div class="row justify-content-center">

                <div class="col-md-7 col-lg-6">

                    <div class="card shadow-sm text-center">

                        <div class="card-body p-5">

                            <div class="display-1 mb-3">
                                ✓
                            </div>

                            <h1 class="h3 mb-3">
                                Porudžbina je uspešno kreirana!
                            </h1>

                            <p class="text-muted mb-4">
                                Hvala što kupujete u TechShop prodavnici.
                            </p>

                            <div class="alert alert-light border">

                                <strong>
                                    Broj porudžbine:
                                </strong>

                                #<?php echo $orderId; ?>

                            </div>

                            <div class="d-flex flex-column gap-2">

                                <a
                                    href="moje_porudzbine.php"
                                    class="btn btn-dark"
                                >
                                    Moje porudžbine
                                </a>

                                <a
                                    href="proizvodi.php"
                                    class="btn btn-outline-secondary"
                                >
                                    Nastavi kupovinu
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </body>

    </html>

    <?php

    exit;
}


// Ako korisnik samo ručno otvori porudzbina.php
header("Location: korpa.php");
exit;

?>