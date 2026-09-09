<?php

session_start();

if (isset($_SESSION["user_id"])) {

    if ($_SESSION["role"] === "admin") {
        header("Location: presentation/admin/dashboard.php");
        exit;
    }

    header("Location: presentation/proizvodi.php");
    exit;
}

header("Location: presentation/login.php");
exit;

?>