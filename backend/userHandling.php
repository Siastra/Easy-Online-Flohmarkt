<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/utility/DB.php';

$db = new DB();
$user = new User(1, $_REQUEST["title"], $_REQUEST["fname"], $_REQUEST["lname"],
    $_REQUEST["address"], $_REQUEST["plz"], $_REQUEST["city"], $_REQUEST["email"], $_REQUEST["pw"]);
if ($_REQUEST["type"] == "insert") {
    if ($db->registerUser($user)) {
        header("Location: ../index.php?registration=success");
    }else {
        header("Location: ../index.php?section=register&registration=fail");
    }
}