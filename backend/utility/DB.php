<?php

include_once  $_SERVER['DOCUMENT_ROOT'] . '/backend/model/User.php';

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

        $this->config = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/config/config.json"),
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

    //Get a specific user by email
    public function getUser(string $email): ?User
    {
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE email = ?");
        if ($stmt->execute([$email])) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row)) {
                return null;
            } else {
                return new User($row["id"], $row["title"], $row["fname"], $row["lname"],
                    $row["address"], $row["plz"], $row["city"], $row["email"], $row["password"]);
            }
        }
        return null;
    }

    //User-login is performed
    public function loginUser(string $email, string $pw): int
    {
        $stmt = $this->conn->prepare("SELECT password FROM `users` WHERE email = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) { //user does not exist
            return -1;
        } else {
            $user = $this->getUser($email);
            if ($user->isAdmin()) {
                if ($pw == $row["password"]) { //login successful
                    return true;
                } else { // login fails
                    return false;
                }
            } else {
                if (password_verify($pw, $row["password"])) { //login successful
                    return true;
                } else { // login fails
                    return false;
                }
            }
        }
    }

    public function getPost($post_id){
        $stmt = $this->conn->prepare("SELECT * FROM adv WHERE id = ?;");
        $stmt_user = $this->conn->prepare("SELECT * FROM `users` WHERE id = ?;");
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

    public function getAllPosts(): array
    {
        $result = array();
        $sql1 = $this->conn->prepare("SELECT * FROM `adverts`");
        $sql1->execute();
        $posts = $sql1->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($posts)){
           foreach ($posts as $post){
               //array_push($result, $post["text"]);
                array_push($result, new Advert($post["id"], $post["user_id"], $post["title"], $post["price"], $post["text"]));
            }
        }
        return $result;
    }
}