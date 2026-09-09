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

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>TechShop - Prijava</title>

</head>


<body class="bg-light">

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">

        <div class="card shadow" style="width: 100%; max-width: 450px;">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <h1 class="h3 fw-bold">
                        TechShop
                    </h1>

                    <p class="text-muted">
                        Prijavite se na svoj nalog
                    </p>

                </div>

                

                <form method="POST">

                    <div class="mb-3">

                        <label for="username" class="form-label">
                            Korisničko ime
                        </label>

                        <input type="text" class="form-control" id="username" name="username" required>

                    </div>


                    <div class="mb-4">

                        <label for="password" class="form-label">
                            Lozinka
                        </label>

                        <input type="password" class="form-control" id="password" name="password" required>

                    </div>


                    <button type="submit" class="btn btn-dark w-100">
                        Prijavi se
                    </button>

                </form>


                <hr>


                <div class="text-center">

                    <p class="mb-0">

                        Nemate nalog?

                        <a href="registracija.php">
                            Registrujte se
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>