<?php

include_once __DIR__ . '/../model/User.php';
include_once __DIR__ . '/../model/Advert.php';

class DB
{
    private string $charset = 'utf8mb4';
    private array $config;
    private PDO $conn;
    private array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    public function __construct()
    {

        $this->config = json_decode(file_get_contents(__DIR__ . "/../../config/config.json"),
            true);
        $username = $this->config["db"]["user"];
        $password = $this->config["db"]["password"];
        $db_name = $this->config["db"]["db_name"];
        $dsn = "mysql:host=localhost;dbname=$db_name;charset=$this->charset";
        try {

            $this->conn = new PDO($dsn, $username, $password, $this->options);
        } catch (Exception $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    //Inserts a user into the user table and returns false if unique constraint fails.
    public function registerUser(User $user): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO `users` (`id`, `title`, `fname`, `lname`, `address`, `plz`, 
                     `city`, `email`, `password`, `picture`, `admin`) 
                     VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
        $pw = $user->getPassword();
        $hash = password_hash($pw, PASSWORD_DEFAULT);
        try {
            $stmt->execute([$user->getTitle(), $user->getFname(), $user->getLname(), $user->getAddress(),
                $user->getPlz(), $user->getCity(), $user->getEmail(), $hash, $user->getPicture(), $user->isAdmin()]);
            return true;
        } catch (PDOException $e) {
            $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
            if (strpos($e->getMessage(), $existingkey) !== FALSE) { // duplicate username
                return false;
            } else {
                throw $e;
            }
        }
    }
    public function getPost($post_id){
        $stmt = $this->conn->prepare("SELECT * FROM adv WHERE id = ?;");
        $stmt_user = $this->conn->prepare("SELECT * FROM users WHERE id = ?;");
        try {
            $stmt->execute([(int)$post_id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (count($result) > 0 && array_key_exists('user_id', $result)) {
                $stmt_user->execute([$result['user_id']]);
                $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
            }
            return ['post' => $result, 'author' => $user];
        } catch (PDOException $e) {
            return [];
        }
    }
    public function createAdv( Advert $adv): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO `adverts` (`id`, `title`, `price`, `user_id`, `createdAt`, 
                     `text`) 
                     VALUES (NULL, ?, ?,  ?, 1,?);");
        try {
            $stmt->execute([$adv->getTitle(), $adv->getPrice(),
                $adv->getUserId(),$adv->getDescription()]);
            return true;
        } catch (PDOException $e) {
            $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
            if (strpos($e->getMessage(), $existingkey) !== FALSE) { // duplicate username
                return false;
            } else {
                throw $e;
            }
        }
    }

}