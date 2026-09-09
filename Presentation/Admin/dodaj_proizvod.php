<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";
require_once __DIR__ . "/../../business/CategoryService.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$message = "";

$categoryService = new CategoryService();

$categories = $categoryService->getAllCategories();


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];
    $categoryId = $_POST["category_id"];
    $image = trim($_POST["image"]);

    $productService = new ProductService();

    $result = $productService->createProduct(
        $name,
        $description,
        $price,
        $categoryId,
        $image
    );

    if ($result === "success") {

        header("Location: dashboard.php");
        exit;

    } else {

        $message = $result;
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

    <title>TechShop - Dodaj proizvod</title>

</head>


<body class="bg-light">


<nav class="navbar navbar-dark bg-dark">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="dashboard.php"
        >
            🛠️ TechShop Admin
        </a>


        <div class="navbar-nav flex-row gap-3">

            <a
                class="nav-link"
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


    <div class="row justify-content-center">

        <div class="col-lg-8">


            <div class="mb-4">

                <h1 class="h2">
                    Dodaj novi proizvod
                </h1>

                <p class="text-muted">
                    Unesite podatke o novom proizvodu.
                </p>

            </div>


            <?php if (!empty($message)): ?>

                <div class="alert alert-info">

                    <?php
                    echo htmlspecialchars($message);
                    ?>

                </div>

            <?php endif; ?>


            <div class="card shadow-sm">


                <div class="card-body p-4">


                    <form method="POST">


                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Naziv proizvoda
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="name"
                                name="name"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="description"
                                class="form-label"
                            >
                                Opis proizvoda
                            </label>

                            <textarea
                                class="form-control"
                                id="description"
                                name="description"
                                rows="4"
                            ></textarea>

                        </div>


                        <div class="mb-3">

                            <label
                                for="price"
                                class="form-label"
                            >
                                Cena
                            </label>

                            <div class="input-group">

                                <input
                                    type="number"
                                    class="form-control"
                                    id="price"
                                    name="price"
                                    step="0.01"
                                    min="0.01"
                                    required
                                >

                                <span class="input-group-text">
                                    RSD
                                </span>

                            </div>

                        </div>


                        <div class="mb-3">

                            <label
                                for="category_id"
                                class="form-label"
                            >
                                Kategorija
                            </label>

                            <select
                                class="form-select"
                                id="category_id"
                                name="category_id"
                                required
                            >

                                <option value="">
                                    -- Izaberite kategoriju --
                                </option>


                                <?php foreach ($categories as $category): ?>

                                    <option
                                        value="<?php echo $category["id"]; ?>"
                                    >

                                        <?php
                                        echo htmlspecialchars(
                                            $category["name"]
                                        );
                                        ?>

                                    </option>

                                <?php endforeach; ?>


                            </select>

                        </div>


                        <div class="mb-4">

                            <label
                                for="image"
                                class="form-label"
                            >
                                Naziv slike
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="image"
                                name="image"
                                placeholder="npr. rtx4060.jpg"
                            >

                            <div class="form-text">

                                Unesite naziv slike koja se nalazi u
                                <code>assets/images</code> folderu.

                            </div>

                        </div>


                        <div class="d-flex justify-content-between">


                            <a
                                href="dashboard.php"
                                class="btn btn-outline-secondary"
                            >
                                ← Nazad
                            </a>


                            <button
                                type="submit"
                                class="btn btn-success"
                            >
                                + Dodaj proizvod
                            </button>


                        </div>


                    </form>


                </div>

            </div>


        </div>

    </div>


</div>


</body>

</html>