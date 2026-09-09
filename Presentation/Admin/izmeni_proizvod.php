<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";
require_once __DIR__ . "/../../data/Database.php";

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


$database = new Database();
$connection = $database->getConnection();

$statement = $connection->prepare(
    "SELECT * FROM categories ORDER BY name"
);

$statement->execute();

$categories = $statement->fetchAll(PDO::FETCH_ASSOC);


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

    <title>Izmeni proizvod</title>

</head>

<body>

<h1>Izmeni proizvod</h1>

<?php if ($message !== ""): ?>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

<?php endif; ?>


<form method="POST">

    <label>Naziv proizvoda:</label>
    <br>

    <input
        type="text"
        name="name"
        value="<?php echo htmlspecialchars($product["name"]); ?>"
        required
    >

    <br><br>


    <label>Opis:</label>
    <br>

    <textarea
        name="description"
        rows="5"
        cols="40"
    ><?php echo htmlspecialchars($product["description"]); ?></textarea>

    <br><br>


    <label>Cena:</label>
    <br>

    <input
        type="number"
        name="price"
        step="0.01"
        min="0"
        value="<?php echo $product["price"]; ?>"
        required
    >

    <br><br>


    <label>Kategorija:</label>
    <br>

    <select name="category_id" required>

        <?php foreach ($categories as $category): ?>

            <option
                value="<?php echo $category["id"]; ?>"
                <?php
                if ($category["id"] == $product["category_id"]) {
                    echo "selected";
                }
                ?>
            >

                <?php echo htmlspecialchars($category["name"]); ?>

            </option>

        <?php endforeach; ?>

    </select>

    <br><br>


    <label>Slika:</label>
    <br>

    <input
        type="text"
        name="image"
        value="<?php echo htmlspecialchars($product["image"] ?? ""); ?>"
    >

    <br><br>


    <button type="submit">
        Sačuvaj izmene
    </button>

</form>

<br>

<a href="dashboard.php">
    Nazad na admin panel
</a>

</body>

</html>