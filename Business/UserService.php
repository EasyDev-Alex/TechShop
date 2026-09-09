<?php

require_once __DIR__ . "/../data/UserRepository.php";

class UserService
{
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register($username, $email, $password)
    {
        if (empty($username) || empty($email) || empty($password)) {
            return "Sva polja su obavezna.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Email nije ispravan.";
        }

        if (strlen($password) < 6) {
            return "Lozinka mora imati najmanje 6 karaktera.";
        }

        if ($this->userRepository->usernameExists($username)) {
            return "Korisničko ime već postoji.";
        }

        if ($this->userRepository->emailExists($email)) {
            return "Email već postoji.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new User(
            $username,
            $email,
            $hashedPassword,
            "user"
        );

        $this->userRepository->createUser($user);

        return "success";
    }

    public function login($username, $password)
    {
        $user = $this->userRepository->findByUsername($username);

        if ($user === false) {
            return false;
        }

        if (!password_verify($password, $user["password"])) {
            return false;
        }

        return $user;
    }
}

?>