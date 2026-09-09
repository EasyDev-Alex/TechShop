<?php

session_start();

require_once __DIR__ . "/../business/UserService.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $userService = new UserService();

    $user = $userService->login($username, $password);

    if ($user !== false) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

        if ($user["role"] === "admin") {

            header("Location: admin/dashboard.php");
            exit;

        } else {

            header("Location: proizvodi.php");
            exit;
        }

    } else {

        $message = "Pogrešno korisničko ime ili lozinka.";
    }
}

?>

<!DOCTYPE html>
<html lang="sr">

<head>

    <meta charset="UTF-8">

    <title>TechShop - Login</title>

</head>

<body>

<h1>TechShop</h1>

<h2>Prijava</h2>

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


    <label>Lozinka:</label>

    <br>

    <input
        type="password"
        name="password"
        required
    >

    <br><br>


    <button type="submit">
        Prijavi se
    </button>

</form>

<br>

<a href="registracija.php">
    Nemate nalog? Registrujte se
</a>

</body>

</html>