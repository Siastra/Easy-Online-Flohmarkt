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
     public function updateProfilePic( int $id, string $path ): bool {
        $stmt = $this->conn->prepare( "UPDATE `users` SET picture=?
                                                WHERE id=?" );
        if ( !$stmt->execute( [$path, $id] ) ) {
            return false;
        } else {
            $this->updateProfilePicPathInChatTable( $id, $path );
            return true;
        }
    }

    public function updateProfilePicPathInChatTable( int $id, string $path ): bool {
        $stmt = $this->conn->prepare( "UPDATE `chat` SET senderPic=?
                                                WHERE senderId=?" );
        if ( !$stmt->execute( [$path, $id] ) ) {
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
                    $row["address"], $row["plz"], $row["city"], $row["email"], $row["password"], $row["picture"], $row["admin"], $row["created_at"]);
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
                $stmt = $this->conn->prepare("SELECT AVG(score) AS score FROM `comment` WHERE user_id = ? GROUP BY user_id");
                if ($stmt->execute([$id])) {
                    $row_score = $stmt->fetch(PDO::FETCH_ASSOC);
                    $user = new User($row["id"], $row["title"], $row["fname"], $row["lname"],
                        $row["address"], $row["plz"], $row["city"], $row["email"], $row["password"],$row["picture"], $row["admin"], $row["created_at"] );
                    if ($row_score)
                        $user->setScore($row_score["score"]);
                    return $user;
                }

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

    public function getAdsByUser(int $u_id): ?array
    {
        $result = array();
        $stmt = $this->conn->prepare("SELECT * FROM adverts WHERE user_id = ?;");
        try {
            $stmt->execute([$u_id]);
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!empty($res)) {
                foreach ($res as $post) {
                    array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                        $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                }
            }
            return $result;
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

    public function getLatestAdvId(): int
    {
        $sql1 = $this->conn->prepare("SELECT MAX(id) FROM `adverts`");
        $sql1->execute();
        $advId = $sql1->fetch(PDO::FETCH_ASSOC);
        return (($advId["MAX(id)"]) ? $advId["MAX(id)"] : 0);
    }

    //get AdvId by Text
    public function getAdvByText(string $searchText): array
    {
        $result = array();
        $searchText = "%" . $searchText . "%";
        $sql = $this->conn->prepare("SELECT * FROM `adverts` WHERE `text` LIKE  ? OR `title` LIKE ? ");
        $sql->execute([$searchText,$searchText]);
        $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($posts)) {
            foreach ($posts as $post) {
                array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                    $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
            }
        }
        return $result;


    }

    public function getAllCategories(): array
    {
        $result = array();
        $sql = $this->conn->prepare("SELECT * FROM `categories`");
        $sql->execute();
        $categories = $sql->fetchAll(PDO::FETCH_ASSOC);


        return $categories;
    }

    public function assignCategories($advertId, $categoryId): bool
    {
        var_dump($categoryId);
        $stmt = $this->conn->prepare("SELECT * FROM `is_assigned` WHERE `advert_id`=?");
        if($stmt->execute([$advertId])){
            $stmt2= $this->conn->prepare("DELETE FROM `is_assigned` WHERE `advert_id`=?");
            $stmt2->execute([$advertId]);
        }

        $stmt = $this->conn->prepare("INSERT INTO `is_assigned` (`advert_id`, `category_id`) 
                     VALUES (?, ?);");
        try {
            $stmt->execute([$advertId, $categoryId]);
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

    public function getAdvByCategory(string $searchText): array
    {
        $result = array();
        $searchText = "%" . $searchText . "%";
        $sql1 = $this->conn->prepare("SELECT `id` FROM `categories` WHERE `name` LIKE ?");
        $sql1->execute([$searchText]);
        $tags = $sql1->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($tags)) {
            foreach ($tags as $tag) {
                $sql2 = $this->conn->prepare("SELECT `advert_id` FROM `is_assigned` WHERE `category_id` = ?");
                $sql2->execute([$tag["id"]]);
                $adverts = $sql2->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($adverts)) {
                    foreach ($adverts as $advert) {
                        array_push($result, $this->getAdById($advert["advert_id"]));

                    }
                }
            }
        }
        return $result;
    }

    public function getPostCategory($post_id)
    {
        $q = $this->conn->prepare("select * from is_assigned where advert_id = :advert_id");
        $q->execute([":advert_id" => $post_id]);
        $f = $q->fetch(PDO::FETCH_ASSOC);
        if ($f) {
            $category_id = $f["category_id"];
            $q = $this->conn->prepare("select * from categories where id = :id");
            $q->execute([":id" => $category_id]);
            $f = $q->fetch(PDO::FETCH_ASSOC);
        }
        return $f;
    }

    public static function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function deletePostById(int $id): bool
    {
        try {
            self::deleteDir($_SESSION["path"] . "/pictures/Adds/$id");
            $sql = $this->conn->prepare("DELETE FROM `favorite` WHERE `advert_id`=?");
            $sql->execute([$id]);
            $sql = $this->conn->prepare("DELETE FROM `is_assigned` WHERE `advert_id`=?");
            $sql->execute([$id]);
            $sql = $this->conn->prepare("DELETE FROM `adverts` WHERE `id`=?");
            $sql->execute([$id]);
            return true;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }

    }

    public function deleteUserById(int $id): bool
    {
        try {
            $posts = $this->getAdsByUser($id);
            foreach ($posts as $post) {
                $this->deletePostById($post->getId());
            }
            $sql = $this->conn->prepare("DELETE FROM `users` WHERE `id`=?");
            $sql->execute([$id]);
            return true;
        } catch (Exception $e) {
            var_dump($e);
            return false;
        }
    }

    public function getAdvSorted(string $searchterm): array
    {
        $result = array();
        switch ($searchterm) {
            case 'DateUp':
                $sql = $this->conn->prepare("SELECT * FROM `adverts` ORDER BY `adverts`.`createdAt` DESC");
                $sql->execute();
                $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                    }
                }
                return $result;

            case 'DateDown':
                $sql = $this->conn->prepare("SELECT * FROM `adverts` ORDER BY `adverts`.`createdAt` ASC");
                $sql->execute();
                $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                    }
                }
                return $result;
            case 'PriceUp':
                $sql = $this->conn->prepare("SELECT * FROM `adverts` ORDER BY `adverts`.`price` ASC");
                $sql->execute();
                $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                    }
                }
                return $result;
            case 'PriceDown':
                $sql = $this->conn->prepare("SELECT * FROM `adverts` ORDER BY `adverts`.`price` DESC");
                $sql->execute();
                $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                    }
                }
                return $result;
            case 'NameUp':
                $sql = $this->conn->prepare("SELECT * FROM `adverts` ORDER BY `adverts`.`title` ASC");
                $sql->execute();
                $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                    }
                }
                return $result;
            case 'NameDown':
                $sql = $this->conn->prepare("SELECT * FROM `adverts` ORDER BY `adverts`.`title` DESC");
                $sql->execute();
                $posts = $sql->fetchAll(PDO::FETCH_ASSOC);
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        array_push($result, new Advert($post["id"], $post["title"], $post["price"],
                            $this->getUserById(intval($post["user_id"])), new DateTime($post["createdAt"]), $post["text"]));
                    }
                }
                return $result;

            default:
                break;


        }

    }

    public function editAdv($id, $title, $price, $text) : bool
    {
        $stmt = $this->conn->prepare("UPDATE `adverts` SET `title` = ?, `price` = ?, `text` = ? WHERE `id` = ?;");
        try {
            $stmt->execute([$title, $price, $text, $id]);
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

   public function saveComment($author_id, $user_id, $score, $comment)
   {
        $stmt = $this->conn->prepare("INSERT INTO `comment` (author_id, user_id, score, comment) VALUES (?,?,?,?)");
        try {
            $stmt->execute([$author_id, $user_id, $score, $comment]);
            return true;
        } catch (PDOException $e) {
                throw $e;
        }
   }

   public function getCommentsByUser($user_id)
   {
        $stmt = $this->conn->prepare("SELECT * FROM `comment` WHERE user_id = ? ORDER BY created_at DESC");
        try {
            $stmt->execute([$user_id]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        } catch (PDOException $e) {
                throw $e;
        }
   }

   public function getCommentsByThisUser($user_id, $author_id)
   {
        $stmt = $this->conn->prepare("SELECT * FROM `comment` WHERE user_id = ? AND author_id = ? ORDER BY created_at DESC");
        try {
            $stmt->execute([$user_id, $author_id]);
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $comments;
        } catch (PDOException $e) {
                throw $e;
        }
   }

       /*
    Farasat Section starts
    */

    function getUserIdByPostId( $postId ) {
        $sql1 = $this->conn->prepare( 'SELECT user_id FROM `adverts` WHERE id = ?' );
        $sql1->execute( [$postId] );
        return $sql1->fetch()['user_id'];
    }

    function fetchUser( $postId ) {
        $userId['userId'] = $this->getUserIdByPostId( $postId );
        return $this->fetchUserById( $userId );
    }

    function getFriendDataByPostId( $postId, $buyerId ) {
        $sql1 = $this->conn->prepare( 'SELECT * FROM `friend` WHERE post_id = ? AND buyer_id = ?' );
        $sql1->execute( [$postId, $buyerId] );
        return $sql1->fetch();
    }

    function getFriendData( $postId, $buyerId, $sellerId ) {
        $sql1 = $this->conn->prepare( 'SELECT * FROM `friend` WHERE post_id = ? AND buyer_id = ? AND seller_id = ?' );
        $sql1->execute( [$postId, $buyerId, $sellerId] );
        return $sql1->fetch();
    }

    function fetchPostIdFromFiendTable( $id ) {
        $sql1 = $this->conn->prepare( 'SELECT post_id FROM `friend` WHERE buyer_id = ? OR seller_id = ?' );
        $sql1->execute( [$id, $id] );
        return $sql1->fetchAll();
    }

    function fetchAllFromFiendTable( $id ) {
        $sql1 = $this->conn->prepare( 'SELECT * FROM `friend` WHERE buyer_id = ? OR seller_id = ?' );
        $sql1->execute( [$id, $id] );
        return $sql1->fetchAll();
    }

    function fetchFriends() {
        $allData = array();
        $user = $this->getUser( $_SESSION['email'] );
        $data = $this->fetchAllFromFiendTable( $user->getID() );

        $length = Count( $data );
        for ( $i = 0; $i < $length; $i++ ) {
            $allData[$i]['postId'] = $data[$i]['post_id'];
            $allData[$i]['fId'] = $data[$i]['id'];

            if ( $user->getID() === $data[$i]['seller_id'] ) {
                $id['userId'] = $data[$i]['buyer_id'];
                $u = $this->fetchUserById( $id );
            } else {
                $id['userId'] = $data[$i]['seller_id'];
                $u = $this->fetchUserById( $id );
            }

            $allData[$i]['headerName'] = $u[0]['fname'];
            $allData[$i]['headerUserPic'] = $u[0]['picture'];

            $pData = $this->fetchPostDataById( $data[$i]['post_id'] );

            $allData[$i]['title'] = $pData['title'];
        }

        return $allData;
        ;
    }

    function fetchPostDataById( $id ) {
        $sql1 = $this->conn->prepare( 'SELECT * FROM `adverts` WHERE id = ?' );
        $sql1->execute( [$id] );
        return $sql1->fetch();
    }

    function fetchAddsBySessionUserId() {

        $sessionUserChatPost = array();

        $user = $this->getUser( $_SESSION['email'] );
        $sessionUserId = $user->getID();

        $data = $this->fetchAllFromFiendTable( $user->getID() );
        return $data;
    }

    function fetchMessage( $data ) {
        $post_id = $data['postId'];

        if ( isset( $_SESSION['email'] ) ) {
            $user = $this->getUser( $_SESSION['email'] );
        }

        $seller_id = $this->getUserIdByPostId( $post_id );

        if ( $user->getID() != $seller_id ) {

            $friendData = $this->getFriendData( $post_id, $user->getID(), $seller_id );
            $sender = 'buyer';
        } else {
            $friendData = $this->getFriendData( $post_id, $data['userId'], $seller_id );
            $sender = 'seller';
        }

        $friendId = $friendData['id'];

        $sql1 = $this->conn->prepare( 'SELECT * FROM `chat` WHERE f_id = ? ' );
        $sql1->execute( [$friendId] );
        return $sql1->fetchAll();
    }

    function fetchChat( $data ) {
        $sql1 = $this->conn->prepare( 'SELECT * FROM `chat` WHERE f_id = ? ' );
        $sql1->execute( [$data['fId']] );
        return $sql1->fetchAll();
    }

    function insertFriend( $userId, $postId ) {

        $seller_id = $this->getUserIdByPostId( $postId );

        if ( $userId != $seller_id ) {
            $friendData = $this->getFriendDataByPostId( $postId, $userId );
        }

        if ( $friendData != null ) {
            if ( $friendData['seller_id'] === $seller_id && $friendData['buyer_id'] === $userId && $postId === $friendData['post_id'] ) {
                return;
            }
        }

        if ( $seller_id != $userId ) {

            $stmt = $this->conn->prepare( "INSERT INTO `friend` (`buyer_id`, `seller_id`, `post_id`) 
            VALUES (?, ?, ?);" );
            try {
                $stmt->execute( [$userId, $seller_id, $postId] );
                return true;
            } catch ( PDOException $e ) {
                $existingkey = 'Integrity constraint violation: 1062 Duplicate entry';
                if ( strpos( $e->getMessage(), $existingkey ) !== FALSE ) {
                    return false;
                } else {
                    throw $e;
                }
            }
        } else {
            // error // personal post.
        }
    }

    function StoreMessage( $message ) {

        if ( isset( $_SESSION['email'] ) ) {
            $user = $this->getUser( $_SESSION['email'] );
        }

        $seller_id = $this->getUserIdByPostId( $message['post_id'] );

        if ( $user->getID() != $seller_id ) {

            $sender = 'buyer';
        } else {
            $sender = 'seller';
        }

        $stmt = $this->conn->prepare( 'INSERT INTO `chat` (`f_id`,`message`, `sender`,`senderName`, `senderId`, `senderPic`) VALUES (?, ?, ?,?,?, ? );' );
        $stmt->execute( [$message['f_id'], $message['message'], $sender, $user->getFname(), $user->getID(), $user->getPicture()] );
    }

    function InsertMessage( $message ) {

        if ( $message == null ) {
            return;
        }

        $post_id = $message['post_id'];

        if ( isset( $_SESSION['email'] ) ) {
            $user = $this->getUser( $_SESSION['email'] );
        }

        $seller_id = $this->getUserIdByPostId( $post_id );

        if ( $user->getID() != $seller_id ) {

            $friendData = $this->getFriendData( $post_id, $user->getID(), $seller_id );
            $sender = 'buyer';
        } else {
            $friendData = $this->getFriendData( $post_id, $message['id'], $seller_id );
            $sender = 'seller';
        }

        $friendId = $friendData['id'];

        $stmt = $this->conn->prepare( 'INSERT INTO `chat` (`f_id`,`message`, `sender`,`senderName`, `senderId`, `senderPic`) VALUES (?, ?, ?,?,?,? );' );
        $stmt->execute( [$friendId, $message['message'], $sender, $user->getFname(), $user->getID(), $user->getPicture()] );
    }

    function fetchAllBuyerByPostId( $postId ) {

        if ( $postId == null ) {
            return;
        }

        $buyer = array();
        $sql1 = $this->conn->prepare( 'SELECT buyer_id FROM `friend` WHERE post_id = ?' );
        $sql1->execute( [$postId] );

        $result = $sql1->fetchAll();
        $length = Count( $result );

        for ( $i = 0; $i < $length; $i++ ) {

            $sql1 = $this->conn->prepare( 'SELECT * FROM `users` WHERE id =  ?' );
            $sql1->execute( [$result[$i]['buyer_id']] );
            array_push( $buyer, $sql1->fetch() );
        }

        return $buyer;
    }

    function fetchBuyerId() {

        $sql1 = $this->conn->prepare( 'SELECT * FROM `users` WHERE email = ?' );
        $sql1->execute( [$_SESSION['email']] );

        return $sql1->fetchAll();
    }

    function fetchAllFriends() {

        $user = $this->getUser( $_SESSION['email'] );

        $sql1 = $this->conn->prepare( 'SELECT * FROM `friend` WHERE seller_id = ? OR buyer_id = ?' );
        $sql1->execute( [$user->getID(), $user->getID()] );

        return $sql1->fetchAll();
    }

    function fetchUserById( $data ) {

        if ( $data == null ) {
            return;
        }

        $sql1 = $this->conn->prepare( 'SELECT * FROM `users` WHERE id = ?' );
        $sql1->execute( [$data['userId']] );

        return $sql1->fetchAll();
    }

    function fetchBuyerByPostAndSellerId( $data ) {

        if ( $data == null ) {
            return;
        }

        $sql1 = $this->conn->prepare( 'SELECT * FROM `friend` WHERE seller_id = ? AND post_id = ?' );

        $sql1->execute( [$data['seller_id'], $data['post_id']] );

        return $sql1->fetch();
    }

    /*
    Farasat Section ends.
    */
}
