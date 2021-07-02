<?php
session_start();
include_once $_SESSION["path"] . '/backend/utility/DB.php';
include_once $_SESSION["path"] . '/backend/utility/Upload.php';
include_once $_SESSION["path"] . '/backend/utility/Email.php';

$db = new DB();

function generateRandomString($length = 10): string
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_REQUEST["type"] == "insert") {
    $user = new User(1, $_REQUEST["title"], $_REQUEST["fname"], $_REQUEST["lname"],
        $_REQUEST["address"], $_REQUEST["plz"], $_REQUEST["city"], $_REQUEST["email"], $_REQUEST["pw"],);
    if ($db->registerUser($user)) {
        $user = $db->getUser($_REQUEST["email"]);
        if ($_FILES["picture"]["size"])
            $path = Upload::uploadProfilePicture($_FILES, $user->getId());
        if (strlen($path) > 1) {
            $db->updateProfilePic($user->getId(), $path);
        }
        header("Location: ../index.php?registration=success");
    } else {
        header("Location: ../index.php?section=register&registration=fail");
    }
} else if ($_REQUEST["type"] == "login") {
    switch ($db->loginUser($_REQUEST["email"], $_REQUEST["pw"])) {
        case 0:
            header("Location: ../index.php?section=login&login=fail&fail=wrongPassword");
            break;
        case 1:
            $user = $db->getUser($_REQUEST["email"]);
            $_SESSION["email"] = $_REQUEST["email"];
            header("Location: ../index.php?login=success");
            break;
        case -1:
            header("Location: ../index.php?section=login&login=fail&fail=account404");
            break;
    }
} else if ($_REQUEST["type"] == "logout") {
    $_SESSION = array();
    session_destroy();
    header("Location: ../index.php?logout=success");
} else if ($_REQUEST["type"] == "updatePw") {
    if ($db->loginUser($_SESSION["email"], $_REQUEST["oldPw"])) {
        $newPw = $_REQUEST["pw"];
        $user = $db->getUser($_SESSION["email"]);
        $user->setPassword($newPw);
        if ($db->updatePassword($user)) {
            echo "Record updated successfully";
            header("Location: ../index.php?updatePassword=success");
        } else {
            header("Location: ../index.php?updatePassword=fail");
        }
    } else {
        header("Location: ../index.php?section=register&edit=true&updatePassword=wrongPassword");
    }
} else if ($_REQUEST["type"] == "update") {
    $user = new User($_REQUEST["id"], $_REQUEST["title"], $_REQUEST["fname"],
        $_REQUEST["lname"], $_REQUEST["address"], $_REQUEST["plz"], $_REQUEST["city"], $_REQUEST["email"], '');
    if (!empty($_FILES["picture"]["size"])) {
        $path = Upload::uploadProfilePicture($_FILES, $_REQUEST["id"]);
        if (strlen($path) > 1) {
            $db->updateProfilePic($_REQUEST["id"], $path);
        }
    }
    if ($db->updateUser($user)) {
        header("Location: ../index.php?update=success");
    } else {
        header("Location: ../index.php?section=register&edit=true&update=fail");
    }
} elseif ($_REQUEST["type"] == "forgotPassword") {

    $newPw = generateRandomString();
    $user = $db->getUser($_REQUEST["username"]);
    if ($user != NULL) {
        $user->setPassword($newPw);
        if ($db->updatePassword($user)) {
            Email::sendNewPw($user);
            header("Location: ../index.php?resetPassword=success");
        } else {
            header("Location: ../index.php?section=forgotPw&resetPassword=fail");
        }
    } else {
        header("Location: ../index.php?section=forgotPw&resetPassword=userNotFound");
    }
} elseif ($_REQUEST["type"] == "deleteUser") {
    $userId = intval($_REQUEST["id"]);
    if ($db->deleteUserById($userId)) {
        header("Location: ../index.php?deleteUser=success");
    } else {
        header("Location: ../index.php?deleteUser=fail");
    }
}