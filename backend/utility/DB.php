<?php

include_once $_SESSION["path"] . '/backend/model/User.php';
include_once $_SESSION["path"] . '/backend/model/Advert.php';

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

        $this->config = json_decode(file_get_contents($_SESSION["path"] . "/config/config.json"),
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

    //Updates user data in the DB.
    public function updateUser(User $user): bool
    {
        $stmt = $this->conn->prepare("UPDATE `users` SET title=?, fname=?, lname=?, address=?, plz=?, city=?, email=? 
                                                WHERE id=?");
        $title = $user->getTitle();
        $fname = $user->getFname();
        $lname = $user->getLname();
        $address = $user->getAddress();
        $plz = $user->getPlz();
        $city = $user->getCity();
        $email = $user->getEmail();
        $id = $user->getId();
        try {
            if (!$stmt->execute([$title, $fname, $lname, $address, $plz, $city, $email, $id])) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            $existingkey = "Integrity constraint violation: 1062 Duplicate entry";
            if (strpos($e->getMessage(), $existingkey) !== FALSE) { // duplicate username
                return false;
            } else {
                throw $e;
            }
        }

    }

    //Updates profile picture in the DB.
    public function updateProfilePic(int $id, string $path): bool
    {
        $stmt = $this->conn->prepare("UPDATE `users` SET picture=?
                                                WHERE id=?");
        if (!$stmt->execute([$path, $id])) {
            return false;
        } else {
            return true;
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
                $user = new User($row["id"], $row["title"], $row["fname"], $row["lname"],
                    $row["address"], $row["plz"], $row["city"], $row["email"], $row["password"], $row["picture"]);
                $favorites = [];
                $favorites = $this->getFavoritesByUser($row["id"]);
                $user->setFavorites($favorites);
                return $user;
            }
        }
        return null;
    }

    public function updateFavoritesForUser($user, $post_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM `favorite` WHERE user_id = ? and advert_id = ?");
        if ($stmt->execute([$user->getId(), $post_id])) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row)) {
                $stmt = $this->conn->prepare("INSERT INTO `favorite` (user_id, advert_id) VALUES (?,?)");
                $stmt->execute([$user->getId(), $post_id]);
            } else {
                $stmt = $this->conn->prepare("DELETE FROM `favorite` WHERE user_id = ? and advert_id = ?");
                $stmt->execute([$user->getId(), $post_id]);
            }
            $favorites = $this->getFavoritesByUser($user->getId());
            $user->setFavorites($favorites);
        }
    }

    public function getFavoritesByUser($user_id)
    {
        $favorites = [];
        $stmt = $this->conn->prepare("SELECT * FROM `favorite` WHERE user_id = ?");
        if ($stmt->execute([$user_id])) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $favorites[] = $row["advert_id"];
            }
            }
            return $favorites;
    }

    public function getFavoritesAdverts($user_id)
    {
        $favorites = [];
        $stmt = $this->conn->prepare("SELECT * FROM `adverts` WHERE id in (SELECT advert_id FROM favorite WHERE user_id = ?)");
        if ($stmt->execute([$user_id])) {
            while ($post = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        array_push($favorites, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
            }
            }
            return $favorites;
    }

    //Updates password in the DB.
    public function updatePassword(User $user): bool
    {
        $stmt = $this->conn->prepare("UPDATE `users` SET password=? WHERE id=?");
        $pw = $user->getPassword();
        $hash = password_hash($pw, PASSWORD_DEFAULT);
        $id = $user->getId();
        if (!$stmt->execute([$hash, $id])) {
            return false;
        } else {
            return true;
        }
    }


    //Get a specific user by id
    public function getUserById(int $id): ?User
    {
        $stmt = $this->conn->prepare("SELECT * FROM `users` WHERE id = ?");
        if ($stmt->execute([$id])) {
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

    public function getAdById(int $post_id): ?Advert
    {
        $stmt = $this->conn->prepare("SELECT * FROM adverts WHERE id = ?;");
        try {
            $stmt->execute([$post_id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (empty($row)) {
                return null;
            } else {
                return new Advert($row["id"], $row["title"], $row["price"], $this->getUserById($row["user_id"]),
                    new DateTime($row["createdAt"]), $row["text"]);
            }
        } catch (PDOException $e) {
            return null;
        }
    }

    public function createAdv(Advert $adv): bool
    {
        $stmt = $this->conn->prepare("INSERT INTO `adverts` (`id`, `title`, `price`, `user_id`, `createdAt`, 
                     `text`) 
                     VALUES (NULL, ?, ?, ?, ?, ?);");
        try {
            $stmt->execute([$adv->getTitle(), $adv->getPrice(),
                $adv->getUser()->getId(), $adv->getCreatedAt(), $adv->getDescription()]);
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

    public function getAllPosts(): array
    {
        $result = array();
        $sql1 = $this->conn->prepare("SELECT * FROM `adverts`");
        $sql1->execute();
        $posts = $sql1->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                    $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
            }
        }
        return $result;
    }
    public function getLatestAdvId():int{
        $sql1 = $this->conn->prepare("SELECT MAX(id) FROM `adverts`");
        $sql1->execute();
        $advId = $sql1->fetch(PDO::FETCH_ASSOC);
        return (($advId["MAX(id)"]) ? $advId["MAX(id)"] : 0);
    }
    //get AdvId by Text
    public function getAdvByText(string $searchText):array{
        $result = array();
        $sql = $this->conn->prepare("SELECT * FROM `adverts` WHERE `text` =? ");
        $sql->execute([$searchText]);
        $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                    $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
            }
        }
        return $result;


    }
}