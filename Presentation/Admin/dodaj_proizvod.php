<?php

session_start();

require_once __DIR__ . "/../../business/ProductService.php";
require_once __DIR__ . "/../../business/CategoryService.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$message = "";

$database = new Database();
$connection = $database->getConnection();

$statement = $connection->prepare(
    "SELECT * FROM categories ORDER BY name"
);

$statement->execute();

$categories = $statement->fetchAll(PDO::FETCH_ASSOC);


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

    <title>Dodaj proizvod</title>

</head>

<body>

<h1>Dodaj novi proizvod</h1>

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
        required
    >

    <br><br>


    <label>Opis:</label>
    <br>

    <textarea
        name="description"
        rows="5"
        cols="40"
    ></textarea>

    <br><br>


    <label>Cena:</label>
    <br>

    <input
        type="number"
        name="price"
        step="0.01"
        min="0"
        required
    >

    <br><br>


    <label>Kategorija:</label>
    <br>

    <select name="category_id" required>

        <option value="">
            -- Izaberite kategoriju --
        </option>

        <?php foreach ($categories as $category): ?>

            <option value="<?php echo $category["id"]; ?>">

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
        placeholder="npr. rtx4060.jpg"
    >

    <br><br>


    <button type="submit">
        Dodaj proizvod
    </button>

</form>

<br>

<a href="dashboard.php">
    Nazad na admin panel
</a>

</body>

</html>