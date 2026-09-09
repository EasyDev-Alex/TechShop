<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";
require_once __DIR__ . "/../../business/CategoryService.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: dashboard.php");
    exit;
}

$id = $_GET["id"];

$productService = new ProductService();

$product = $productService->getProductById($id);

if ($product === false) {
    die("Proizvod ne postoji.");
}


$categoryService = new CategoryService();

$categories = $categoryService->getAllCategories();


$message = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];
    $categoryId = $_POST["category_id"];
    $image = trim($_POST["image"]);

    $result = $productService->updateProduct(
        $id,
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

    <title>TechShop - Izmeni proizvod</title>

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
                    Izmeni proizvod
                </h1>

                <p class="text-muted">
                    Izmenite podatke o proizvodu.
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
                                value="<?php echo htmlspecialchars($product["name"]); ?>"
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
                            ><?php echo htmlspecialchars($product["description"]); ?></textarea>

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
                                    value="<?php echo htmlspecialchars($product["price"]); ?>"
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

                                <?php foreach ($categories as $category): ?>

                                    <option
                                        value="<?php echo $category["id"]; ?>"
                                        <?php
                                        if (
                                            $category["id"]
                                            == $product["category_id"]
                                        ) {
                                            echo "selected";
                                        }
                                        ?>
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
                                value="<?php echo htmlspecialchars($product["image"] ?? ""); ?>"
                            >

                            <div class="form-text">

                                Slika treba da se nalazi u
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
                                class="btn btn-primary"
                            >
                                Sačuvaj izmene
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