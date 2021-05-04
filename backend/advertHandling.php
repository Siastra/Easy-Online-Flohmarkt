<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Easy-Online-Flohmarkt/backend/utility/DB.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Easy-Online-Flohmarkt/backend/utility/Upload.php';
$db = new DB();
$User=$db->getUser($_SESSION['email']);
$advertisment = new Advert(1,$User->getId(), $_REQUEST["title"], $_REQUEST["price"], $_REQUEST["description"]);


    if ($db->createAdv($advertisment)) {
        var_dump($_FILES);
        $pic=$_FILES["picture"];
        Upload::uploadPost($_FILES, $pic["name"]);
        header("Location: ../index.php?section=dashboard");
    }else {
        header("Location: ../index.php?section=upload");
}

?>