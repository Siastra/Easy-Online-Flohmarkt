<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';

$db = new DB();
session_start();

if ($_REQUEST["type"] == "insert") {
    $user = new User(1, $_REQUEST["title"], $_REQUEST["fname"], $_REQUEST["lname"],
        $_REQUEST["address"], $_REQUEST["plz"], $_REQUEST["city"], $_REQUEST["email"], $_REQUEST["pw"]);
    if ($db->registerUser($user)) {
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
}