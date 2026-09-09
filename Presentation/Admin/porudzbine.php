<?php

session_start();

require_once __DIR__ . "/../../business/OrderService.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$orderService = new OrderService();

$orders = $orderService->getAllOrders();

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

    <title>TechShop - Porudžbine</title>

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
                class="nav-link"
                href="dashboard.php"
            >
                Proizvodi
            </a>

            <a
                class="nav-link active"
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


    <div class="mb-4">

        <h1 class="h2">
            Pregled porudžbina
        </h1>

        <p class="text-muted">
            Pregled svih porudžbina korisnika.
        </p>

    </div>


    <?php if (empty($orders)): ?>


        <div class="card shadow-sm">

            <div class="card-body text-center p-5">

                <h3>
                    Nema porudžbina
                </h3>

                <p class="text-muted mb-0">

                    Trenutno nije napravljena nijedna porudžbina.

                </p>

            </div>

        </div>


    <?php else: ?>


        <?php foreach ($orders as $order): ?>


            <?php

            $items = $orderService->getOrderItems(
                $order["id"]
            );

            ?>


            <div class="card shadow-sm mb-4">


                <div class="card-header bg-dark text-white">


                    <div
                        class="d-flex justify-content-between align-items-center"
                    >


                        <div>

                            <h5 class="mb-1">

                                Porudžbina
                                #<?php echo $order["id"]; ?>

                            </h5>


                            <div class="small">

                                Korisnik:
                                <?php
                                echo htmlspecialchars(
                                    $order["username"]
                                );
                                ?>

                            </div>


                            <div class="small">

                                Email:
                                <?php
                                echo htmlspecialchars(
                                    $order["email"]
                                );
                                ?>

                            </div>

                        </div>


                        <div class="text-end">

                            <div class="small">
                                Datum porudžbine
                            </div>

                            <strong>

                                <?php

                                echo date(
                                    "d.m.Y. H:i",
                                    strtotime(
                                        $order["order_date"]
                                    )
                                );

                                ?>

                            </strong>

                        </div>


                    </div>


                </div>


                <div class="card-body">


                    <div class="table-responsive">


                        <table
                            class="table table-hover align-middle"
                        >


                            <thead>

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

                                </tr>

                            </thead>


                            <tbody>


                                <?php foreach ($items as $item): ?>


                                    <?php

                                    $subtotal =
                                        $item["price"]
                                        * $item["quantity"];

                                    ?>


                                    <tr>


                                        <td class="fw-semibold">

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


                                        <td class="fw-semibold">

                                            <?php

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


                            </tbody>


                        </table>


                    </div>


                    <div
                        class="border-top pt-3 text-end"
                    >

                        <span class="fs-5">

                            Ukupna cena:

                        </span>


                        <strong class="fs-4 ms-2">

                            <?php

                            echo number_format(
                                $order["total_price"],
                                2,
                                ",",
                                "."
                            );

                            ?>

                            RSD

                        </strong>

                    </div>


                </div>


            </div>


        <?php endforeach; ?>


    <?php endif; ?>


</div>


</body>

</html>