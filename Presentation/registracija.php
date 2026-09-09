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
        header("Location: login.php");
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

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>TechShop - Registracija</title>

</head>


<body class="bg-light">

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">

        <div class="card shadow" style="width: 100%; max-width: 500px;">

            <div class="card-body p-4">

                <div class="text-center mb-4">

                    <h1 class="h3 fw-bold">
                        TechShop
                    </h1>

                    <p class="text-muted">
                        Kreirajte novi nalog
                    </p>

                </div>


                <?php if (!empty($error)): ?>

                    <div class="alert alert-danger">

                        <?php
                        echo htmlspecialchars($error);
                        ?>

                    </div>

                <?php endif; ?>


                <?php if (!empty($success)): ?>

                    <div class="alert alert-success">

                        <?php
                        echo htmlspecialchars($success);
                        ?>

                    </div>

                <?php endif; ?>


                <form method="POST">


                    <div class="mb-3">

                        <label for="username" class="form-label">
                            Korisničko ime
                        </label>

                        <input type="text" class="form-control" id="username" name="username" required>

                    </div>


                    <div class="mb-3">

                        <label for="email" class="form-label">
                            Email
                        </label>

                        <input type="email" class="form-control" id="email" name="email" required>

                    </div>


                    <div class="mb-4">

                        <label for="password" class="form-label">
                            Lozinka
                        </label>

                        <input type="password" class="form-control" id="password" name="password" required>

                    </div>


                    <button type="submit" class="btn btn-dark w-100">
                        Registruj se
                    </button>


                </form>


                <hr>


                <div class="text-center">

                    <p class="mb-0">

                        Već imate nalog?

                        <a href="login.php">
                            Prijavite se
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</body>

</html>