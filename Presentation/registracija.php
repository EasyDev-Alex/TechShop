<?php

require_once __DIR__ . "/../business/UserService.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $userService = new UserService();

    $result = $userService->register(
        $username,
        $email,
        $password
    );

    if ($result === "success") {
        $message = "Registracija je uspešna!";
    } else {
        $message = $result;
    }
}

?>

<!DOCTYPE html>
<html lang="sr">

<head>
    <meta charset="UTF-8">
    <title>TechShop - Registracija</title>
</head>

<body>

<h1>TechShop</h1>

<h2>Registracija</h2>

<?php if ($message !== ""): ?>

    <p>
        <?php echo htmlspecialchars($message); ?>
    </p>

<?php endif; ?>


<form method="POST">

    <label>Korisničko ime:</label>
    <br>

    <input
        type="text"
        name="username"
        required
    >

    <br><br>


    <label>Email:</label>
    <br>

    <input
        type="email"
        name="email"
        required
    >

    <br><br>


    <label>Lozinka:</label>
    <br>

    <input
        type="password"
        name="password"
        required
    >

    <br><br>

    <button type="submit">
        Registruj se
    </button>

</form>

</body>

</html>