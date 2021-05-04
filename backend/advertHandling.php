<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Easy-Online-Flohmarkt/backend/utility/DB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Easy-Online-Flohmarkt/backend/utility/Upload.php';
$db = new DB();
$User=$db->getUser($_SESSION['email']);
$advertisment = new Advert($User->getId(),1, $_REQUEST["title"], $_REQUEST["price"], $_REQUEST["description"]);



    if ($db->createAdv($advertisment)) {
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
}

?>