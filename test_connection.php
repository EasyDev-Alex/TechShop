<?php

require_once "data/Database.php";

try {

    $database = new Database();

    $connection = $database->getConnection();

    echo "Uspešno ste povezani sa TechShop bazom!";

} catch (Exception $e) {

    echo "Greška: " . $e->getMessage();

}

?>