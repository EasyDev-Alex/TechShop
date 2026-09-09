<?php

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/User.php";

class UserRepository
{
    private $connection;

    public function __construct()
    {
        $database = new Database();
        $this->connection = $database->getConnection();
    }

    public function createUser(User $user)
    {
        $sql = "INSERT INTO users (username, email, password, role)
                VALUES (:username, :email, :password, :role)";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":username" => $user->getUsername(),
            ":email" => $user->getEmail(),
            ":password" => $user->getPassword(),
            ":role" => $user->getRole()
        ]);
    }

    public function usernameExists($username)
    {
        $sql = "SELECT id FROM users WHERE username = :username";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":username" => $username
        ]);

        return $statement->fetch() !== false;
    }

    public function emailExists($email)
    {
        $sql = "SELECT id FROM users WHERE email = :email";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":email" => $email
        ]);

        return $statement->fetch() !== false;
    }

    public function findByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = :username";

        $statement = $this->connection->prepare($sql);

        $statement->execute([
            ":username" => $username
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}

?>